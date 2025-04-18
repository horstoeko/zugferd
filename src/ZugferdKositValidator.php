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
use Throwable;
use ZipArchive;
use horstoeko\stringmanagement\FileUtils;
use horstoeko\stringmanagement\PathUtils;
use horstoeko\stringmanagement\StringUtils;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Class representing the validator against Schematron (Kosit) for documents.
 * This class requires a JAVA running setup
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
     * @var ZugferdDocument|string|null
     */
    private $document;

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
    private $validatorScenarioDownloadUrl = "https://github.com/itplr-kosit/validator-configuration-xrechnung/releases/download/release-2025-03-21/validator-configuration-xrechnung_3.0.2_2025-03-21.zip";

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
    private $fileToValidateFilename = "";

    /**
     * Internal flag which indicates that the cleanup of the base directory is disables
     *
     * @var boolean
     */
    private $cleanupBaseDirectoryIsDisabled = false;

    /**
     * Use remote validation (JAVA application is running in daemon mode on a remote host)
     *
     * @var boolean
     */
    private $remoteModeEnabled = false;

    /**
     * The remote hostname or -ip
     *
     * @var string
     */
    private $remoteModeHost = "";

    /**
     * The remote host port
     *
     * @var integer
     */
    private $remoteModePort = 0;

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
     * Create a KositValidator-Instance by a given content string
     *
     * @param  string $document
     * @return ZugferdKositValidator
     */
    public static function fromString(string $document): ZugferdKositValidator
    {
        return new ZugferdKositValidator($document);
    }

    /**
     * Create a KositValidator-Instance by a given ZugferdDocument (ZugferdDocumentReader, ZugferdDocumentBuilder)
     *
     * @param  ZugferdDocument $zugferdDocument
     * @return ZugferdKositValidator
     */
    public static function fromZugferdDocument(ZugferdDocument $zugferdDocument): ZugferdKositValidator
    {
        return new ZugferdKositValidator($zugferdDocument);
    }

    /**
     * Constructor
     *
     * @param ZugferdDocument|string|null $document
     */
    public function __construct($document = null)
    {
        $this->baseDirectory = sys_get_temp_dir();
        $this->setDocument($document);
    }

    /**
     * Set the ZugferdDocument instance to validate
     *
     * @param  ZugferdDocument|string $document
     * @return ZugferdKositValidator
     */
    public function setDocument($document): ZugferdKositValidator
    {
        if (!is_string($document) && !($document instanceof ZugferdDocument)) {
            return $this;
        }

        $this->document = $document;

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
     * Disable the usage of a remote host validation
     *
     * @return ZugferdKositValidator
     */
    public function disableRemoteMode(): ZugferdKositValidator
    {
        $this->remoteModeEnabled = false;

        return $this;
    }

    /**
     * Enable the usage of a remote host validation
     *
     * @return ZugferdKositValidator
     */
    public function enableRemoteMode(): ZugferdKositValidator
    {
        $this->remoteModeEnabled = true;

        return $this;
    }

    /**
     * Set the hostname or the ip of the remote host where the validation application
     * is running in daemon mode
     *
     * @param  string $remoteModeHost
     * @return ZugferdKositValidator
     */
    public function setRemoteModeHost(string $remoteModeHost): ZugferdKositValidator
    {
        if (StringUtils::stringIsNullOrEmpty($remoteModeHost)) {
            return $this;
        }

        $this->remoteModeHost = $remoteModeHost;

        return $this;
    }

    /**
     * Set the port of the remote host where the validation application
     * is running in daemon mode
     *
     * @param  integer $remoteModePort
     * @return ZugferdKositValidator
     */
    public function setRemoteModePort(int $remoteModePort): ZugferdKositValidator
    {
        if ($remoteModePort <= 0) {
            return $this;
        }

        $this->remoteModePort = $remoteModePort;

        return $this;
    }

    /**
     * Returns the full remote mode URL
     *
     * @return string
     */
    public function getRemoteModeUrl(): string
    {
        return sprintf("http://%s:%s", $this->remoteModeHost, $this->remoteModePort);
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
     * Internal get the content of the document
     *
     * @return string
     */
    private function getDocumentContent(): string
    {
        if (is_string($this->document)) {
            return $this->document;
        }

        return $this->document->serializeAsXml();
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
    private function resolveScenatioZipFilename(): string
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
     * Reset the internal filename where data of the PDF to validate are stored
     *
     * @return void
     */
    private function resetFileToValidateFilename(): void
    {
        $this->fileToValidateFilename = "";
    }

    /**
     * Get the full filename which contains the PDF to validate
     *
     * @return string
     */
    private function resolveFileToValidateFilename(): string
    {
        if (StringUtils::stringIsNullOrEmpty($this->fileToValidateFilename)) {
            $this->fileToValidateFilename = PathUtils::combinePathWithFile($this->resolveBaseDirectory(), sprintf('filetovalidate-%s-%s.xml', uniqid(), uniqid()));
        }

        return $this->fileToValidateFilename;
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
     * @param  string|Throwable $error
     * @return void
     */
    private function addToMessageBag($error, string $messageType = ""): void
    {
        $messageType = StringUtils::stringIsNullOrEmpty($messageType) ? static::MSG_TYPE_INTERNALERROR : $messageType;

        if (is_string($error)) {
            $this->messageBag[] = ["type" => $messageType, "message" => $error];
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
        return $this->getValidationErrors() === [];
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
        return $this->getValidationWarnings() === [];
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
        return $this->getValidationInformation() === [];
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
        return $this->getProcessErrors() === [];
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
        if ($this->checkRequirementsGeneral() === false) {
            return false;
        }

        if ($this->remoteModeEnabled === true) {
            return $this->checkRequirementsRemote();
        }

        return $this->checkRequirementsLocal();
    }

    /**
     * CHeck general requirements (common for local and remote validation)
     *
     * @return boolean
     */
    private function checkRequirementsGeneral(): bool
    {
        if (is_null($this->document)) {
            $this->addToMessageBag("You must specify an instance of the ZugferdDocument class");
            return false;
        }

        return true;
    }

    /**
     * CHeck requirements for usage on a local installation
     *
     * @return boolean
     */
    private function checkRequirementsLocal(): bool
    {
        if ($this->remoteModeEnabled === true) {
            return true;
        }

        if (!extension_loaded('zip')) {
            $this->addToMessageBag("ZIP extension not installed");
            return false;
        }

        $executableFinder = new ExecutableFinder();

        if (is_null($executableFinder->find('java'))) {
            $this->addToMessageBag("JAVA not installed on this machine");
            return false;
        }

        return true;
    }

    /**
     * CHeck requirements for usage on a remote host which is running the application
     * in daemon mode
     *
     * @return boolean
     */
    private function checkRequirementsRemote(): bool
    {
        if ($this->remoteModeEnabled !== true) {
            return true;
        }

        if (!extension_loaded('curl')) {
            $this->addToMessageBag("PHP-Curl not installed or activated");
            return false;
        }

        if (StringUtils::stringIsNullOrEmpty($this->remoteModeHost)) {
            $this->addToMessageBag("You must specify the hostname or it's IP where the Validator is running in daemon mode");
            return false;
        }

        if ($this->remoteModePort <= 0) {
            $this->addToMessageBag("You must specify the port of the host where the Validator is running in daemon mode");
            return false;
        }

        try {
            $httpConnection = curl_init($this->getRemoteModeUrl());

            curl_setopt($httpConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($httpConnection, CURLOPT_HEADER, true);
            curl_setopt($httpConnection, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($httpConnection, CURLOPT_ENCODING, '');
            curl_setopt($httpConnection, CURLOPT_AUTOREFERER, true);
            curl_setopt($httpConnection, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($httpConnection, CURLOPT_TIMEOUT, 120);

            $response = curl_exec($httpConnection);

            if ($response === false) {
                $this->addToMessageBag("Failed to connect to the host where the Validator is running in daemon mode");
                $this->addToMessageBag(curl_error($httpConnection));
                return false;
            }

            $responseStatusCode = curl_getinfo($httpConnection, CURLINFO_HTTP_CODE);

            curl_close($httpConnection);

            if (($responseStatusCode < 200) || ($responseStatusCode >= 400)) {
                $this->addToMessageBag("Failed to connect to the host where the Validator is running in daemon mode");
                $this->addToMessageBag(curl_error($httpConnection));
                return false;
            }
        } catch (Throwable $throwable) {
            $this->addToMessageBag($throwable);
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
        if ($this->remoteModeEnabled === true) {
            return true;
        }

        if (!$this->runFileDownload($this->validatorDownloadUrl, $this->resolveAppZipFilename())) {
            $this->addToMessageBag(sprintf("Unable to download from %s containing the JAVA-Application", $this->validatorDownloadUrl));
            return false;
        }

        if (!$this->runFileDownload($this->validatorScenarioDownloadUrl, $this->resolveScenatioZipFilename())) {
            $this->addToMessageBag(sprintf("Unable to download from %s containing the validation scenarios", $this->validatorScenarioDownloadUrl));
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
        if ($this->remoteModeEnabled === true) {
            return true;
        }

        $validatorAppFile = $this->resolveAppZipFilename();
        $validatorScenarioFile = $this->resolveScenatioZipFilename();

        if (!$this->unpackRequiredFile($validatorAppFile)) {
            $this->addToMessageBag(sprintf("Unable to unpack archive %s containing the JAVA-Application", $validatorAppFile));
            return false;
        }

        if (!$this->unpackRequiredFile($validatorScenarioFile)) {
            $this->addToMessageBag(sprintf("Unable to unpack archive %s containing the validation scenarios", $validatorScenarioFile));
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
        if ($this->remoteModeEnabled === true) {
            return true;
        }

        $zipArchive = new ZipArchive();

        if ($zipArchive->open($filename) !== true) {
            $this->addToMessageBag(sprintf("Failed to open ZIP archive %s", $filename));
            return false;
        }

        $numFilesExists = 0;

        for ($i = 0; $i < $zipArchive->numFiles; $i++) {
            $zipStat = $zipArchive->statIndex($i);
            $realfilename = PathUtils::combinePathWithFile($this->resolveBaseDirectory(), $zipStat['name']);
            if (file_exists($realfilename)) {
                $numFilesExists++;
            }
        }

        if ($numFilesExists == $zipArchive->numFiles) {
            return true;
        }

        if (!$zipArchive->extractTo($this->resolveBaseDirectory())) {
            $zipArchive->close();
            $this->addToMessageBag(sprintf("Failed to extract ZIP archive %s", $filename));
            return false;
        }

        $zipArchive->close();

        return true;
    }

    /**
     * Runs the validator java application
     *
     * @return boolean
     */
    private function performValidation(): bool
    {
        if ($this->remoteModeEnabled === true) {
            return $this->performValidationRemote();
        }

        return $this->performValidationLocal();
    }

    /**
     * Runs the validator java application locally
     *
     * @return boolean
     */
    private function performValidationLocal(): bool
    {
        if ($this->remoteModeEnabled === true) {
            return true;
        }

        $this->resetFileToValidateFilename();

        if (file_put_contents($this->resolveFileToValidateFilename(), $this->getDocumentContent()) === false) {
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
            $this->parseValidatorXmlReportByFile();
            return false;
        }

        return true;
    }

    /**
     * Runs the validator java application on the remote host
     *
     * @return boolean
     */
    private function performValidationRemote(): bool
    {
        if ($this->remoteModeEnabled !== true) {
            return true;
        }

        try {
            $httpConnection = curl_init($this->getRemoteModeUrl());

            curl_setopt($httpConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($httpConnection, CURLOPT_HEADER, true);
            curl_setopt($httpConnection, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($httpConnection, CURLOPT_ENCODING, '');
            curl_setopt($httpConnection, CURLOPT_AUTOREFERER, true);
            curl_setopt($httpConnection, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($httpConnection, CURLOPT_TIMEOUT, 120);
            curl_setopt($httpConnection, CURLOPT_POST, true);
            curl_setopt($httpConnection, CURLOPT_POSTFIELDS, $this->getDocumentContent());
            curl_setopt($httpConnection, CURLOPT_HTTPHEADER, ["Content-Type: application/xml"]);

            $response = curl_exec($httpConnection);

            if ($response === false) {
                $this->addToMessageBag("Failed to connect to the host where the Validator is running in daemon mode");
                $this->addToMessageBag(curl_error($httpConnection));
                return false;
            }

            $responseStatusCode = curl_getinfo($httpConnection, CURLINFO_HTTP_CODE);

            curl_close($httpConnection);

            if (($responseStatusCode < 200) || ($responseStatusCode >= 400)) {
                if (preg_match('/<\?xml.*?\?>.*<\/.+>/s', $response, $matches)) {
                    $this->parseValidatorXmlReportByContent($matches[0]);
                }

                return false;
            }
        } catch (Throwable $throwable) {
            $this->addToMessageBag($throwable);
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
    private function parseValidatorXmlReportByFile(): void
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

        $this->parseValidatorXmlReportByDomDocument($domDocument);
    }

    /**
     * Parses the XML content string containing the response from the validation app (JAVA application) and put errors
     * to messagebag
     *
     * @param  string $xmlContent
     * @return void
     */
    private function parseValidatorXmlReportByContent(string $xmlContent): void
    {
        if (StringUtils::stringIsNullOrEmpty($xmlContent)) {
            return;
        }

        $domDocument = new DOMDocument();
        $domDocument->loadXML($xmlContent);

        $this->parseValidatorXmlReportByDomDocument($domDocument);
    }

    /**
     * Parses the XML DOMDocument containing the response from the validation app (JAVA application) and put errors
     * to messagebag
     *
     * @param  DOMDocument $domDocument
     * @return void
     */
    private function parseValidatorXmlReportByDomDocument(DOMDocument $domDocument): void
    {
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
            $queryResult = $domXPath->query(sprintf("//rep:report/rep:scenarioMatched/rep:validationStepResult[@id='%s']/s:resource/s:name", $resultArea));
            $resourceName = isset($queryResult[0]) ? $queryResult[0]->nodeValue : $resultArea;
            foreach ($messageTypeMaps as $messageType => $reportMessageType) {
                $queryResult = $domXPath->query(sprintf("//rep:report/rep:scenarioMatched/rep:validationStepResult[@id='%s']/rep:message[@level='%s']", $resultArea, $reportMessageType));
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
        if ($this->remoteModeEnabled === true) {
            return;
        }

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
        if ($this->remoteModeEnabled === true) {
            return;
        }

        if (!is_dir($directoryToRemove)) {
            return;
        }

        $objects = scandir($directoryToRemove);

        foreach ($objects as $object) {
            if ($object !== "." && $object !== "..") {
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
        } catch (Throwable $throwable) {
            $this->addToMessageBag($throwable, static::MSG_TYPE_VALIDATIONERROR);
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
        } catch (Throwable $throwable) {
            $this->addToMessageBag($throwable);
            return false;
        }

        return true;
    }
}
