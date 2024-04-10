<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use Exception;
use horstoeko\stringmanagement\PathUtils;
use SebastianBergmann\CodeCoverage\Driver\PathExistsButIsNotDirectoryException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Throwable;
use ZipArchive;

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
     * @var ZugferdDocument
     */
    private $document = null;

    /**
     * Internal error bag
     *
     * @var array
     */
    private $errorBag = [];

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
    private $validatorScenarioDownloadUrl = "https://github.com/itplr-kosit/validator-configuration-xrechnung/releases/download/release-2023-07-31/validator-configuration-xrechnung_3.0.0_2023-07-31.zip";

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
     * Constructor
     *
     * @codeCoverageIgnore
     * @param ZugferdDocument|null $document
     */
    public function __construct(?ZugferdDocument $document = null)
    {
        $this->document = $document;
        $this->baseDirectory = sys_get_temp_dir();
    }

    /**
     * Set the ZugferdDocument instance to validate
     *
     * @param ZugferdDocument $document
     * @return ZugferdKositValidator
     */
    public function setDocument(ZugferdDocument $document): ZugferdKositValidator
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Setup the base directory. In the base directory all files will be downloaded
     * and created
     *
     * @param string $newBaseDirectory
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
     * @param string $newValidatorDownloadUrl
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
     * @param string $newValidatorScenarioDownloadUrl
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
     * @param string $newValidatorAppZipFilename
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
     * @param string $newValidatorScenarioZipFilename
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
     * @param string $newValidatorAppJarFilename
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
     * @param string $newValidatorAppScenarioFilename
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
     * @param string $newFileToValidateFilename
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
        $this->clearErrorBag();

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

        $this->runValidator();

        //$this->cleanupBaseDirectory();

        return $this;
    }

    /**
     * Internal get (and create) the directory for downloads and file creation
     *
     * @return string
     */
    private function resolveBaseDirectory(): string
    {
        $baseDirectory = PathUtils::combinePathWithPath($this->baseDirectory, "kositvalidator");

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
    private function clearErrorBag(): void
    {
        $this->errorBag = [];
    }

    /**
     * Add message to error bag
     *
     * @param string|Exception|Throwable $error
     * @return void
     */
    private function addToErrorBag($error): void
    {
        if (is_string($error)) {
            $this->errorBag[] = $error;
        } elseif ($error instanceof Exception) {
            $this->errorBag[] = $error->getMessage();
        } elseif ($error instanceof Throwable) {
            $this->errorBag[] = $error->getMessage();
        }
    }

    /**
     * Returns true if validation passed otherwise false
     *
     * @return boolean
     */
    public function validationPased(): bool
    {
        return empty($this->errorBag);
    }

    /**
     * Returns true if validation failed otherwise false
     *
     * @return boolean
     */
    public function validationFailed(): bool
    {
        return !$this->validationPased();
    }

    /**
     * Returns an array of all validation errors
     *
     * @return array
     */
    public function validationErrors(): array
    {
        return $this->errorBag;
    }

    /**
     * Check Requirements
     *
     * @return boolean
     */
    private function checkRequirements(): bool
    {
        if (is_null($this->document)) {
            $this->addToErrorBag("You must specify an instance of the ZugferdDocument class");
            return false;
        }

        if (!extension_loaded('zip')) {
            $this->addToErrorBag("ZIP extension not installed");
            return false;
        }

        $executeableFinder = new ExecutableFinder();

        if (is_null($executeableFinder->find('java'))) {
            $this->addToErrorBag("JAVA not installed on this machine");
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

        if (!$this->runFileDownload($this->validatorScenarioDownloadUrl, $this->resolveAppScenarioFilename())) {
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
        $validatorAppFile = PathUtils::combinePathWithFile($this->resolveBaseDirectory(), $this->validatorAppZipFilename);
        $validatorScenarioFile = PathUtils::combinePathWithFile($this->resolveBaseDirectory(), $this->validatorScenarioZipFilename);

        if ($this->unpackRequiredFile($validatorAppFile) !== true) {
            $this->addToErrorBag("Unable to unpack ZIP archive $validatorAppFile");
            return false;
        }

        if ($this->unpackRequiredFile($validatorScenarioFile) !== true) {
            $this->addToErrorBag("Unable to unpack ZIP archive $validatorScenarioFile");
            return false;
        }

        return true;
    }

    /**
     * Unpack single required file
     *
     * @param string $filename
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

        if ($zip->extractTo($this->resolveBaseDirectory()) !== true) {;
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
    private function runValidator(): bool
    {
        if ($this->cleanupBaseDirectoryIsDisabled === true) {
            return true;
        }

        $jarFilename = $this->resolveAppJarFilename();
        $scenarioFilename = $this->resolveAppScenarioFilename();
        $fileToValidateFilename = $this->resolveFileToValidateFilename();

        if (file_put_contents($fileToValidateFilename, $this->document->serializeAsXml()) === false) {
            $this->addToErrorBag("Cannot create temporary file which contains the XML to validate");
            return false;
        }

        if (!$this->runProcess(['java', '-jar', $jarFilename, '-r', $this->resolveBaseDirectory(), '-s', $scenarioFilename, $fileToValidateFilename])) {
            return false;
        }

        return true;
    }

    /**
     * Cleanup downloads and created files
     *
     * @return void
     */
    private function cleanupBaseDirectory(): void
    {
        if (!is_dir($this->resolveBaseDirectory())) {
            return;
        }

        $this->cleanupBaseDirectoryInternal($this->resolveBaseDirectory());
    }

    /**
     * Helper method for removeBaseDirectory
     *
     * @param string $directoryToRemove
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
                if (is_dir($fullFilename) && !is_link($fullFilename))
                    $this->cleanupBaseDirectoryInternal($fullFilename);
                else
                    unlink($fullFilename);
            }
        }

        rmdir($directoryToRemove);
    }

    /**
     * Runs a process. If the process runned successfully this method
     * returns true, otherwise false
     *
     * @param array $command
     * @return boolean
     */
    private function runProcess(array $command): bool
    {
        try {
            $process = new Process($command);
            $process->setTimeout(0.0);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        } catch (ProcessFailedException $e) {
            $this->addToErrorBag($e);
            return false;
        } catch (Exception $e) {
            $this->addToErrorBag($e);
            return false;
        }

        return true;
    }

    /**
     * Run a file download.
     *
     * @param string $url
     * @param string $toFilePath
     * @param boolean $forceOverwrite
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
            $this->addToErrorBag($e);
            return false;
        } catch (Throwable $e) {
            $this->addToErrorBag($e);
            return false;
        }

        return true;
    }
}
