<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use DOMDocument;
use DOMXPath;
use Exception;
use Throwable;
use ZipArchive;
use horstoeko\stringmanagement\FileUtils;
use horstoeko\stringmanagement\PathUtils;
use horstoeko\stringmanagement\StringUtils;
use JMS\Serializer\Exception\RuntimeException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Class representing the validator against Schematron (Kosit) for documents
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdKositValidator
{
    /**
     * The invoice document reference
     *
     * @var string
     */
    private $documentContent = null;

    /**
     * Internal message bag
     *
     * @var array
     */
    private $messageBag = [];

    /**
     * Base directory (download)
     *
     * @var string
     */
    private $baseDirectory;

    /**
     * Kosit Validator download url
     *
     * @var string
     */
    private $validatorDownloadUrl = "https://github.com/itplr-kosit/validator/releases/download/v1.5.0/validator-1.5.0-distribution.zip";

    /**
     * Kosit Validator scenarios download url
     *
     * @var string
     */
    private $validatorScenarioDownloadUrl = "https://github.com/itplr-kosit/validator-configuration-xrechnung/releases/download/release-2023-11-15/validator-configuration-xrechnung_3.0.1_2023-11-15.zip";

    /**
     * The filename of the validation application zip archive
     *
     * @var string $validatorAppZipFilename
     */
    private $validatorAppZipFilename = "validator.zip";

    /**
     * The filename of the validation scenario zip archive
     *
     * @var string $validatorScenarioZipFilename
     */
    private $validatorScenarioZipFilename = "validator-configuration.zip";

    /**
     * The java application filename
     *
     * @var string $validatorAppJarFilename
     */
    private $validatorAppJarFilename = "validationtool-1.5.0-standalone.jar";

    /**
     * The java application scenario filename
     *
     * @var string
     */
    private $validatorAppScenarioFilename = "scenarios.xml";

    /**
     * The temporary filename which contains the xml data to validate
     *
     * @var string
     */
    private $fileToValidateFilename = "filetovalidate.xml";

    /**
     * Internal flag which indicates that the cleanup of the base directory is disables
     *
     * @var boolean
     */
    private $cleanupBaseDirectoryIsDisabled = false;

    /**
     * Message Type "Internal Error"
     */
    protected const MSG_TYPE_INTERNALERROR = 'internalerror';

    /**
     * Message Type "Validation Error"
     */
    protected const MSG_TYPE_VALIDATIONERROR = 'validationerror';

    /**
     * Message Type "Validation Warning"
     */
    protected const MSG_TYPE_VALIDATIONWARNING = 'validationwarning';

    /**
     * Message Type "Validation info"
     */
    protected const MSG_TYPE_VALIDATIONINFORMATION = 'validationinformation';

    /**
     * Message Type "Process Output"
     */
    protected const MSG_TYPE_PROCESSOUTPUT = 'processoutput';

    /**
     * Constructo
     *
     * @deprecated 1.0.76 Use static::fromDocument or static::fromString instead
     */
    public function __construct(?ZugferdDocument $document = null)
    {
        $this->baseDirectory = sys_get_temp_dir();

        if (!is_null($document)) {
            $this->setDocumentContent($document->serializeAsXml());
        }
    }

    /**
     * Initialize from a ZugferdDocument to validate
     *
     * @param  ZugferdDocument $document
     * @return static
     */
    public static function fromDocument(ZugferdDocument $document)
    {
        $instance = new static();
        $instance->setDocumentContent($document->serializeAsXml());

        return $instance;
    }

    /**
     * Initialize from a string which contains the XML to validate
     *
     * @param  string $documentContent
     * @return static
     */
    public static function fromString(string $documentContent)
    {
        $instance = new static();
        $instance->setDocumentContent($documentContent);

        return $instance;
    }

    /**
     * Set the ZugferdDocument instance to validate
     *
     * @param      ZugferdDocument $document
     * @return     ZugferdKositValidator
     * @throws     RuntimeException
     * @deprecated 1.0.76 Use static::fromDocument or static::fromString instead
     */
    public function setDocument(ZugferdDocument $document): ZugferdKositValidator
    {
        $this->setDocumentContent($document->serializeAsXml());

        return $this;
    }

    /**
     * Sets the content to validate
     *
     * @param  string $documentContent
     * @return ZugferdKositValidator
     */
    public function setDocumentContent(string $documentContent): ZugferdKositValidator
    {
        $this->documentContent = $documentContent;

        return $this;
    }

    /**
     * Setup the base directory. In the base directory all files will be downloaded
     * and created
     *
     * @param  string $newBaseDirectory
     * @return ZugferdKositValidator
     */
    public function setBaseDirectory(string $newBaseDirectory): ZugferdKositValidator
    {
        if (is_dir($newBaseDirectory)) {
            $this->baseDirectory = $newBaseDirectory;
        }

        return $this;
    }

    /**
     * Setup the KOSIT validator application download url
     *
     * @param  string $newValidatorDownloadUrl
     * @return ZugferdKositValidator
     */
    public function setValidatorDownloadUrl(string $newValidatorDownloadUrl): ZugferdKositValidator
    {
        if (filter_var($newValidatorDownloadUrl, FILTER_VALIDATE_URL) !== false) {
            $this->validatorDownloadUrl = $newValidatorDownloadUrl;
        }

        return $this;
    }

    /**
     * Setup the KOSIT validator scenario download url
     *
     * @param  string $newValidatorScenarioDownloadUrl
     * @return ZugferdKositValidator
     */
    public function setValidatorScenarioDownloadUrl(string $newValidatorScenarioDownloadUrl): ZugferdKositValidator
    {
        if (filter_var($newValidatorScenarioDownloadUrl, FILTER_VALIDATE_URL) !== false) {
            $this->validatorScenarioDownloadUrl = $newValidatorScenarioDownloadUrl;
        }

        return $this;
    }

    /**
     * Set the filename of the ZIP file which contains the validation application
     *
     * @param  string $newValidatorAppZipFilename
     * @return ZugferdKositValidator
     */
    public function setValidatorAppZipFilename(string $newValidatorAppZipFilename): ZugferdKositValidator
    {
        $this->validatorAppZipFilename = $newValidatorAppZipFilename;

        return $this;
    }

    /**
     * Set the filename of the ZIP file which contains the validation scenarios
     *
     * @param  string $newValidatorScenarioZipFilename
     * @return ZugferdKositValidator
     */
    public function setValidatorScenarioZipFilename(string $newValidatorScenarioZipFilename): ZugferdKositValidator
    {
        $this->validatorScenarioZipFilename = $newValidatorScenarioZipFilename;

        return $this;
    }

    /**
     * Set the filename of the applications JAR
     *
     * @param  string $newValidatorAppJarFilename
     * @return ZugferdKositValidator
     */
    public function setValidatorAppJarFilename(string $newValidatorAppJarFilename): ZugferdKositValidator
    {
        $this->validatorAppJarFilename = $newValidatorAppJarFilename;

        return $this;
    }

    /**
     * Set the filename of the application scenario file
     *
     * @param  string $newValidatorAppScenarioFilename
     * @return ZugferdKositValidator
     */
    public function setValidatorAppScenarioFilename(string $newValidatorAppScenarioFilename): ZugferdKositValidator
    {
        $this->validatorAppScenarioFilename = $newValidatorAppScenarioFilename;

        return $this;
    }

    /**
     * Set the filename of the file which contains the temporary xml data to validate
     *
     * @param  string $newFileToValidateFilename
     * @return ZugferdKositValidator
     */
    public function setFileToValidateFilename(string $newFileToValidateFilename): ZugferdKositValidator
    {
        $this->fileToValidateFilename = $newFileToValidateFilename;

        return $this;
    }

    /**
     * Disable cleanup base directory
     *
     * @return ZugferdKositValidator
     */
    public function disableCleanup(): ZugferdKositValidator
    {
        $this->cleanupBaseDirectoryIsDisabled = true;

        return $this;
    }

    /**
     * Enable cleanup base directory
     *
     * @return ZugferdKositValidator
     */
    public function enableCleanup(): ZugferdKositValidator
    {
        $this->cleanupBaseDirectoryIsDisabled = false;

        return $this;
    }

    /**
     * Perform validation
     *
     * @return ZugferdKositValidator
     */
    public function validate(): ZugferdKositValidator
    {
        $this->clearMessageBag();

        if ($this->checkRequirements() === false) {
            return $this;
        }

        if ($this->downloadRequiredFiles() === false) {
            $this->cleanupBaseDirectory();
            return $this;
        }

        if ($this->unpackRequiredFiles() === false) {
            $this->cleanupBaseDirectory();
            return $this;
        }

        $this->performValidation();

        $this->cleanupBaseDirectory();

        return $this;
    }

    /**
     * Internal get (and create) the directory for downloads and file creation
     *
     * @return string
     */
    private function resolveBaseDirectory(): string
    {
        $baseDirectorySuffix = md5($this->validatorDownloadUrl . $this->validatorScenarioDownloadUrl);

        $baseDirectory = PathUtils::combinePathWithPath($this->baseDirectory, sprintf("kositvalidator-%s", $baseDirectorySuffix));

        if (!is_dir($baseDirectory)) {
            @mkdir($baseDirectory);
        }

        return $baseDirectory;
    }

    /**
     * Get the full filename of the archive to download which contains the Java validation application
     *
     * @return string
     */
    private function resolveAppZipFilename(): string
    {
        return PathUtils::combinePathWithFile($this->resolveBaseDirectory(), $this->validatorAppZipFilename);
    }

    /**
     * Get the full filename of the archive to download which contains the Java validation application scenarios
     *
     * @return string
     */
    public function resolveScenatioZipFilename(): string
    {
        return PathUtils::combinePathWithFile($this->resolveBaseDirectory(), $this->validatorScenarioZipFilename);
    }

    /**
     * Get the full filename of the validator application jar file
     *
     * @return string
     */
    private function resolveAppJarFilename(): string
    {
        return PathUtils::combineAllPaths($this->resolveBaseDirectory(), $this->validatorAppJarFilename);
    }

    /**
     * Get the full filename of the validator application scenario file
     *
     * @return string
     */
    private function resolveAppScenarioFilename(): string
    {
        return PathUtils::combinePathWithFile($this->resolveBaseDirectory(), $this->validatorAppScenarioFilename);
    }

    /**
     * Get the full filename which contains the xml to validate
     *
     * @return string
     */
    private function resolveFileToValidateFilename(): string
    {
        return PathUtils::combinePathWithFile($this->resolveBaseDirectory(), $this->fileToValidateFilename);
    }

    /**
     * Clear the internal error bag
     *
     * @return void
     */
    private function clearMessageBag(): void
    {
        $this->messageBag = [];
    }

    /**
     * Add message to error bag
     *
     * @param  string|Exception|Throwable $error
     * @return void
     */
    private function addToMessageBag($error, string $messageType = ""): void
    {
        $messageType = StringUtils::stringIsNullOrEmpty($messageType) ? static::MSG_TYPE_INTERNALERROR : $messageType;

        if (is_string($error)) {
            $this->messageBag[] = ["type" => $messageType, "message" => $error];
        } elseif ($error instanceof Exception) {
            $this->messageBag[] = ["type" => $messageType, "message" => $error->getMessage()];
        } elseif ($error instanceof Throwable) {
            $this->messageBag[] = ["type" => $messageType, "message" => $error->getMessage()];
        }
    }

    /**
     * Get messages from messagebag filtered by message type
     *
     * @param  string $messageType
     * @return array
     */
    private function getMessageBagFiltered(string $messageType): array
    {
        return array_map(
            function ($data) {
                return $data["message"];
            },
            array_filter(
                $this->messageBag,
                function ($data) use ($messageType) {
                    return $data['type'] == $messageType;
                }
            )
        );
    }

    /**
     * Returns an array of all validation errors
     *
     * @return array
     */
    public function getValidationErrors(): array
    {
        return $this->getMessageBagFiltered(static::MSG_TYPE_VALIDATIONERROR);
    }

    /**
     * Returns true if __no__ validation errors are present otherwise false
     *
     * @return boolean
     */
    public function hasNoValidationErrors(): bool
    {
        return empty($this->getValidationErrors());
    }

    /**
     * Returns true if validation errors are present otherwise false
     *
     * @return boolean
     */
    public function hasValidationErrors(): bool
    {
        return !$this->hasNoValidationErrors();
    }

    /**
     * Returns an array of all validation warnings
     *
     * @return array
     */
    public function getValidationWarnings(): array
    {
        return $this->getMessageBagFiltered(static::MSG_TYPE_VALIDATIONWARNING);
    }

    /**
     * Returns true if __no__ validation warnings are present otherwise false
     *
     * @return boolean
     */
    public function hasNoValidationWarnings(): bool
    {
        return empty($this->getValidationWarnings());
    }

    /**
     * Returns true if validation warnings are present otherwise false
     *
     * @return boolean
     */
    public function hasValidationWarnings(): bool
    {
        return !$this->hasNoValidationWarnings();
    }

    /**
     * Returns an array of all validation information
     *
     * @return array
     */
    public function getValidationInformation(): array
    {
        return $this->getMessageBagFiltered(static::MSG_TYPE_VALIDATIONINFORMATION);
    }

    /**
     * Returns true if __no__ validation information are present otherwise false
     *
     * @return boolean
     */
    public function hasNoValidationInformation(): bool
    {
        return empty($this->getValidationInformation());
    }

    /**
     * Returns true if validation Information are present otherwise false
     *
     * @return boolean
     */
    public function hasValidationInformation(): bool
    {
        return !$this->hasNoValidationInformation();
    }

    /**
     * Return an array of all internal errors (such as download error or system exceptions)
     *
     * @return array
     */
    public function getProcessErrors(): array
    {
        return $this->getMessageBagFiltered(static::MSG_TYPE_INTERNALERROR);
    }

    /**
     * Returns true if there are __no__ system errors (e.g. exceptions before the validation app was called)
     *
     * @return boolean
     */
    public function hasNoProcessErrors(): bool
    {
        return empty($this->getProcessErrors());
    }

    /**
     * Returns true if there are any system errors (e.g. exceptions before the validation app was called)
     *
     * @return boolean
     */
    public function hasProcessErrors(): bool
    {
        return !$this->hasNoProcessErrors();
    }

    /**
     * Returns an array of all messages from process system (calling external applications)
     *
     * @return array
     */
    public function getProcessOutput(): array
    {
        return $this->getMessageBagFiltered(static::MSG_TYPE_PROCESSOUTPUT);
    }

    /**
     * Check Requirements
     *
     * @return boolean
     */
    private function checkRequirements(): bool
    {
        if (empty($this->documentContent)) {
            $this->addToMessageBag("You must specify the content to validate");
            return false;
        }

        if (!extension_loaded('zip')) {
            $this->addToMessageBag("ZIP extension not installed");
            return false;
        }

        $executeableFinder = new ExecutableFinder();

        if (is_null($executeableFinder->find('java'))) {
            $this->addToMessageBag("JAVA not installed on this machine");
            return false;
        }

        return true;
    }

    /**
     * Download required files
     *
     * @return boolean
     */
    private function downloadRequiredFiles(): bool
    {
        if (!$this->runFileDownload($this->validatorDownloadUrl, $this->resolveAppZipFilename())) {
            return false;
        }

        if (!$this->runFileDownload($this->validatorScenarioDownloadUrl, $this->resolveScenatioZipFilename())) {
            return false;
        }

        return true;
    }

    /**
     * Unpack required files
     *
     * @return boolean
     */
    private function unpackRequiredFiles(): bool
    {
        $validatorAppFile = $this->resolveAppZipFilename();
        $validatorScenarioFile = $this->resolveScenatioZipFilename();

        if ($this->unpackRequiredFile($validatorAppFile) !== true) {
            $this->addToMessageBag("Unable to unpack archive $validatorAppFile containing the JAVA-Application");
            return false;
        }

        if ($this->unpackRequiredFile($validatorScenarioFile) !== true) {
            $this->addToMessageBag("Unable to unpack archive $validatorScenarioFile containing the validation scenarios");
            return false;
        }

        return true;
    }

    /**
     * Unpack single required file
     *
     * @param  string $filename
     * @return boolean
     */
    private function unpackRequiredFile(string $filename): bool
    {
        $zip = new ZipArchive();

        if ($zip->open($filename) !== true) {
            return false;
        }

        $numFilesExists = 0;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $zipStat = $zip->statIndex($i);
            $realfilename = PathUtils::combinePathWithFile($this->resolveBaseDirectory(), $zipStat['name']);
            if (file_exists($realfilename)) {
                $numFilesExists++;
            }
        }

        if ($numFilesExists == $zip->numFiles) {
            return true;
        }

        if ($zip->extractTo($this->resolveBaseDirectory()) !== true) {
            $zip->close();
            return false;
        }

        $zip->close();

        return true;
    }

    /**
     * Runs the validator java application
     *
     * @return boolean
     */
    private function performValidation(): bool
    {
        if (file_put_contents($this->resolveFileToValidateFilename(), $this->documentContent) === false) {
            $this->addToMessageBag("Cannot create temporary file which contains the XML to validate");
            return false;
        }

        $applicationOptions = [
            'java',
            '-jar',
            $this->resolveAppJarFilename(),
            '-r',
            $this->resolveBaseDirectory(),
            '-s',
            $this->resolveAppScenarioFilename(),
            $this->resolveFileToValidateFilename()
        ];

        if (!$this->runValidationApplication($applicationOptions, $this->resolveBaseDirectory())) {
            $this->parseValidatorXmlReport();
            return false;
        }

        return true;
    }

    /**
     * Parses the XML report from the validation app (JAVA application) and put errors
     * to messagebag
     *
     * @return void
     */
    private function parseValidatorXmlReport(): void
    {
        $reportFilename =
            PathUtils::combinePathWithFile(
                $this->resolveBaseDirectory(),
                FileUtils::getFilenameWithoutExtension($this->resolveFileToValidateFilename()) . '-report.xml'
            );

        if (!file_exists($reportFilename)) {
            return;
        }

        $domDocument = new DOMDocument();
        $domDocument->load($reportFilename);

        $domXPath = new DOMXPath($domDocument);

        $messageTypeMaps = [
            static::MSG_TYPE_VALIDATIONERROR => 'error',
            static::MSG_TYPE_VALIDATIONWARNING => 'warning',
            static::MSG_TYPE_VALIDATIONINFORMATION => 'information',
        ];

        $resultAreas = [
            'val-xsd',
            'val-sch.1',
            'val-xml',
        ];

        foreach ($resultAreas as $resultArea) {
            $queryResult = $domXPath->query("//rep:report/rep:scenarioMatched/rep:validationStepResult[@id='$resultArea']/s:resource/s:name");
            $resourceName = isset($queryResult[0]) ? $queryResult[0]->nodeValue : $resultArea;
            foreach ($messageTypeMaps as $messageType => $reportMessageType) {
                $queryResult = $domXPath->query("//rep:report/rep:scenarioMatched/rep:validationStepResult[@id='$resultArea']/rep:message[@level='$reportMessageType']");
                foreach ($queryResult as $queryItem) {
                    $this->addToMessageBag(sprintf("%s: %s", $resourceName, $queryItem->nodeValue), $messageType);
                }
            }
        }
    }

    /**
     * Cleanup downloads and created files
     *
     * @return void
     */
    private function cleanupBaseDirectory(): void
    {
        if ($this->cleanupBaseDirectoryIsDisabled === true) {
            return;
        }

        if (!is_dir($this->resolveBaseDirectory())) {
            return;
        }

        $this->cleanupBaseDirectoryInternal($this->resolveBaseDirectory());
    }

    /**
     * Helper method for removeBaseDirectory
     *
     * @param  string $directoryToRemove
     * @return void
     */
    private function cleanupBaseDirectoryInternal(string $directoryToRemove): void
    {
        if (!is_dir($directoryToRemove)) {
            return;
        }

        $objects = scandir($directoryToRemove);

        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                $fullFilename = PathUtils::combinePathWithFile($directoryToRemove, $object);
                if (is_dir($fullFilename) && !is_link($fullFilename)) {
                    $this->cleanupBaseDirectoryInternal($fullFilename);
                } else {
                    unlink($fullFilename);
                }
            }
        }

        rmdir($directoryToRemove);
    }

    /**
     * Runs a process. If the process runned successfully this method
     * returns true, otherwise false
     *
     * @param  array  $command
     * @param  string $workingdirectory
     * @return boolean
     */
    private function runValidationApplication(array $command, string $workingdirectory): bool
    {
        try {
            $process = new Process($command);
            $process->setTimeout(0.0);
            $process->setWorkingDirectory($workingdirectory);
            $process->run();

            foreach (preg_split("/\r\n|\n|\r/", $process->getOutput()) as $outputLine) {
                $this->addToMessageBag($outputLine, static::MSG_TYPE_PROCESSOUTPUT);
            }

            if (!$process->isSuccessful()) {
                if ($process->getExitCode() == -1) {
                    $this->addToMessageBag("Parsing error. The commandline arguments specified are incorrect", static::MSG_TYPE_VALIDATIONERROR);
                }
                if ($process->getExitCode() == -2) {
                    $this->addToMessageBag("Configuration error. There is an error loading the configuration and/or validation targets", static::MSG_TYPE_VALIDATIONERROR);
                }
                if ($process->getExitCode() > 0) {
                    $this->addToMessageBag("Validation error. One ore more files were rejected", static::MSG_TYPE_VALIDATIONERROR);
                }
                return false;
            }
        } catch (Exception $e) {
            $this->addToMessageBag($e, static::MSG_TYPE_VALIDATIONERROR);
            return false;
        } catch (Throwable $e) {
            $this->addToMessageBag($e, static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        return true;
    }

    /**
     * Run a file download.
     *
     * @param  string  $url
     * @param  string  $toFilePath
     * @param  boolean $forceOverwrite
     * @return boolean
     */
    private function runFileDownload(string $url, string $toFilePath, bool $forceOverwrite = false): bool
    {
        try {
            if (file_exists($toFilePath) && !$forceOverwrite) {
                return true;
            }
            file_put_contents($toFilePath, file_get_contents($url));
        } catch (Exception $e) {
            $this->addToMessageBag($e);
            return false;
        } catch (Throwable $e) {
            $this->addToMessageBag($e);
            return false;
        }

        return true;
    }
}
