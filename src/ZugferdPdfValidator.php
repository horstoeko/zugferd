<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use LogicException;
use Throwable;
use ZipArchive;
use horstoeko\stringmanagement\PathUtils;
use horstoeko\stringmanagement\StringUtils;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdFileNotReadableException;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Class representing the validator against PDF files using VeraPDF.
 * This class requires a JAVA running setup
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdPdfValidator
{
    /**
     * The PDF content
     *
     * @var string|null
     */
    private $pdfContent;

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
     * VeraPDF Validator download url
     *
     * @var string
     */
    private $validatorDownloadUrl = "https://software.verapdf.org/rel/verapdf-installer.zip";

    /**
     * The filename of the validation application zip archive
     *
     * @var string $validatorAppZipFilename
     */
    private $validatorAppZipFilename = "verapdf-installer.zip";

    /**
     * The ruleset to use
     * Allowed values are 0, 1a, 1b, 2a, 2b, 2u, 3a, 3b, 3u, 4, 4f, 4e, ua1, ua2
     *
     * @var string
     */
    private $validatorRuleset = "3a";

    /**
     * The temporary filename which contains the PDF data to validate
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
     * Ruleset for Automatic detection based on a file's metadata
     */
    public const RULESET_PDF_A_0 = '0';

    /**
     * Ruleset PDF/A-1A validation profile
     */
    public const RULESET_PDF_A_1A = '1a';

    /**
     * Ruleset PDF/A-1B validation profile
     */
    public const RULESET_PDF_A_1B = '1b';

    /**
     * Ruleset PDF/A-2A validation profile
     */
    public const RULESET_PDF_A_2A = '2a';

    /**
     * Ruleset PDF/A-2B validation profile
     */
    public const RULESET_PDF_A_2B = '2b';

    /**
     * Ruleset PDF/A-2U validation profile
     */
    public const RULESET_PDF_A_2U = '2u';

    /**
     * Ruleset PDF/A-3A validation profile
     */
    public const RULESET_PDF_A_3A = '3a';

    /**
     * Ruleset PDF/A-3B validation profile
     */
    public const RULESET_PDF_A_3B = '3b';

    /**
     * Ruleset PDF/A-3U validation profile
     */
    public const RULESET_PDF_A_3U = '3u';

    /**
     * Ruleset PDF/A-4 validation profile
     */
    public const RULESET_PDF_A_4 = '4';

    /**
     * Ruleset PDF/A-4F validation profile
     */
    public const RULESET_PDF_A_4F = '4f';

    /**
     * Ruleset PDF/A-4E validation profile
     */
    public const RULESET_PDF_A_4E = '4e';

    /**
     * Ruleset PDF/UA-1 validation profile
     */
    public const RULESET_PDF_UA_1 = 'ua1';

    /**
     * Ruleset PDF/UA-2 + Tagged PDF validation profile
     */
    public const RULESET_PDF_UA_2 = 'ua2';

    /**
     * Create a ZugferdPdfValidator-Instance by an existing PDF-File
     *
     * @param  string $pdfFilename
     * @return ZugferdPdfValidator
     */
    public static function fromFile(string $pdfFilename): ZugferdPdfValidator
    {
        if (!file_exists($pdfFilename)) {
            throw new ZugferdFileNotFoundException($pdfFilename);
        }

        $pdfContent = file_get_contents($pdfFilename);

        if ($pdfContent === false) {
            throw new ZugferdFileNotReadableException($pdfFilename);
        }

        return ZugferdPdfValidator::fromContent($pdfContent);
    }

    /**
     * Create a ZugferdPdfValidator-Instance by a given content string
     *
     * @param  string $pdfContent
     * @return ZugferdPdfValidator
     */
    public static function fromContent(string $pdfContent): ZugferdPdfValidator
    {
        return new ZugferdPdfValidator($pdfContent);
    }

    /**
     * Constructor
     *
     * @param string|null $pdfContent
     */
    final protected function __construct(?string $pdfContent = null)
    {
        $this->setBaseDirectory(sys_get_temp_dir());
        $this->setPdfContent($pdfContent);
    }

    /**
     * Set the PDF content to validate
     *
     * @param  string $pdfContent
     * @return ZugferdPdfValidator
     */
    public function setPdfContent(string $pdfContent): ZugferdPdfValidator
    {
        $this->pdfContent = $pdfContent;

        return $this;
    }

    /**
     * Setup the base directory. In the base directory all files will be downloaded
     * and created
     *
     * @param  string $newBaseDirectory
     * @return ZugferdPdfValidator
     */
    public function setBaseDirectory(string $newBaseDirectory): ZugferdPdfValidator
    {
        if (is_dir($newBaseDirectory)) {
            $this->baseDirectory = $newBaseDirectory;
        }

        return $this;
    }

    /**
     * Setup the VeraPDF validator application download url
     *
     * @param  string $newValidatorDownloadUrl
     * @return ZugferdPdfValidator
     */
    public function setValidatorDownloadUrl(string $newValidatorDownloadUrl): ZugferdPdfValidator
    {
        if (filter_var($newValidatorDownloadUrl, FILTER_VALIDATE_URL) !== false) {
            $this->validatorDownloadUrl = $newValidatorDownloadUrl;
        }

        return $this;
    }

    /**
     * Set the filename of the ZIP file which contains the validation application
     *
     * @param  string $newValidatorAppZipFilename
     * @return ZugferdPdfValidator
     */
    public function setValidatorAppZipFilename(string $newValidatorAppZipFilename): ZugferdPdfValidator
    {
        $this->validatorAppZipFilename = $newValidatorAppZipFilename;

        return $this;
    }

    /**
     * Set the Ruleset to use for validation.
     * Allowed values are 0, 1a, 1b, 2a, 2b, 2u, 3a, 3b, 3u, 4, 4f, 4e, ua1, ua2
     *
     * @param  string $newVlidatorRuleset
     * @return ZugferdPdfValidator
     */
    public function setValidatorRuleset(string $newVlidatorRuleset): ZugferdPdfValidator
    {
        $newVlidatorRuleset = strtolower($newVlidatorRuleset);

        if (in_array($newVlidatorRuleset, [static::RULESET_PDF_A_0, static::RULESET_PDF_A_1A, static::RULESET_PDF_A_1B, static::RULESET_PDF_A_2A, static::RULESET_PDF_A_2B, static::RULESET_PDF_A_2U, static::RULESET_PDF_A_3A, static::RULESET_PDF_A_3B, static::RULESET_PDF_A_3U, static::RULESET_PDF_A_4, static::RULESET_PDF_A_4E, static::RULESET_PDF_A_4F, static::RULESET_PDF_UA_1, static::RULESET_PDF_UA_2])) {
            $this->validatorRuleset = $newVlidatorRuleset;
        }

        return $this;
    }

    /**
     * Disable cleanup base directory
     *
     * @return ZugferdPdfValidator
     */
    public function disableCleanup(): ZugferdPdfValidator
    {
        $this->cleanupBaseDirectoryIsDisabled = true;

        return $this;
    }

    /**
     * Enable cleanup base directory
     *
     * @return ZugferdPdfValidator
     */
    public function enableCleanup(): ZugferdPdfValidator
    {
        $this->cleanupBaseDirectoryIsDisabled = false;

        return $this;
    }

    /**
     * Perform validation
     *
     * @return ZugferdPdfValidator
     */
    public function validate(): ZugferdPdfValidator
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

        if ($this->installValidator() === false) {
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
        $baseDirectorySuffix = md5($this->validatorDownloadUrl);

        $baseDirectory = PathUtils::combinePathWithPath($this->baseDirectory, sprintf("verapdf-%s", $baseDirectorySuffix));

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
     * Get the executable of the validator
     *
     * @return string
     */
    private function resolveValidatorExecutable(): string
    {
        return PathUtils::combinePathWithFile($this->resolveBaseDirectory(), 'verapdf');
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
            $this->fileToValidateFilename = PathUtils::combinePathWithFile($this->resolveBaseDirectory(), sprintf('filetovalidate-%s-%s.pdf', uniqid(), uniqid()));
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
        if (is_null($this->pdfContent)) {
            $this->addToMessageBag("You must specify the content or a filename of a PDF to validate");
            return false;
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
     * Download required files
     *
     * @return boolean
     */
    private function downloadRequiredFiles(): bool
    {
        if (!$this->runFileDownload($this->validatorDownloadUrl, $this->resolveAppZipFilename())) {
            $this->addToMessageBag(sprintf("Unable to download from %s containing the JAVA-Application", $this->validatorDownloadUrl));
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

        if (!$this->unpackRequiredFile($validatorAppFile, true)) {
            $this->addToMessageBag(sprintf("Unable to unpack archive %s containing the JAVA-Application", $validatorAppFile));
            return false;
        }

        return true;
    }

    /**
     * Unpack single required file
     *
     * @param  string $zipFilename
     * @param  bool   $flatExtraction
     * @return bool
     */
    private function unpackRequiredFile(string $zipFilename, bool $flatExtraction = false): bool
    {
        if ($flatExtraction) {
            return $this->unpackRequiredFileFlat($zipFilename);
        }

        return $this->unpackRequiredFileNonFlat($zipFilename);
    }

    /**
     * Unpack single required file (Non-Flat)
     *
     * @param  string $zipFilename
     * @return bool
     */
    private function unpackRequiredFileNonFlat(string $zipFilename): bool
    {
        $zipArchive = new ZipArchive();

        if ($zipArchive->open($zipFilename) !== true) {
            $this->addToMessageBag(sprintf("Failed to open ZIP archive %s", $zipFilename));
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
            $this->addToMessageBag(sprintf("Failed to extract ZIP archive %s", $zipFilename));
            return false;
        }

        $zipArchive->close();

        return true;
    }

    /**
     * Unpack single required file (Flat)
     *
     * @param  string $zipFilename
     * @return bool
     */
    private function unpackRequiredFileFlat(string $zipFilename): bool
    {
        $zipArchive = new ZipArchive();

        if ($zipArchive->open($zipFilename) !== true) {
            $this->addToMessageBag(sprintf("Failed to open ZIP archive %s", $zipFilename));
            return false;
        }

        for ($i = 0; $i < $zipArchive->numFiles; $i++) {
            $filenameInZip = $zipArchive->getNameIndex($i);

            if (substr($filenameInZip, -1) === '/') {
                continue;
            }

            $realfilename = $this->resolveBaseDirectory() . DIRECTORY_SEPARATOR . basename($filenameInZip);

            if (file_exists($realfilename)) {
                continue;
            }

            if (!copy('zip://' . realpath($zipFilename) . '#' . $filenameInZip, $realfilename)) {
                $zipArchive->close();
                $this->addToMessageBag(sprintf("Failed to extract %s", $filenameInZip));
                return false;
            }
        }

        $zipArchive->close();

        return true;
    }

    /**
     * Install the validator
     *
     * @return bool
     * @throws DirectoryNotFoundException
     * @throws LogicException
     */
    private function installValidator(): bool
    {
        if (file_exists($this->resolveValidatorExecutable())) {
            return true;
        }

        $installerJarFinder = new Finder();
        $installerJarFinder->files()->name('verapdf-izpack-installer*.jar')->in($this->resolveBaseDirectory());

        if ($installerJarFinder->hasResults() === false) {
            $this->addToMessageBag("There was no installer in the form of a JAR-File found");
            return false;
        }

        $installerScriptFilename = PathUtils::combinePathWithFile($this->resolveBaseDirectory(), 'install.xml');

        if (
            file_put_contents(
                $installerScriptFilename,
                sprintf(
                    '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <AutomatedInstallation langpack="eng">
                <com.izforge.izpack.panels.htmlhello.HTMLHelloPanel id="welcome"/>
                <com.izforge.izpack.panels.target.TargetPanel id="install_dir">
                    <installpath>%s</installpath>
                </com.izforge.izpack.panels.target.TargetPanel>
                <com.izforge.izpack.panels.packs.PacksPanel id="sdk_pack_select">
                    <pack index="0" name="veraPDF Mac and *nix Scripts" selected="true"/>
                    <pack index="1" name="veraPDF Validation model" selected="true"/>
                    <pack index="2" name="veraPDF Documentation" selected="true"/>
                    <pack index="3" name="veraPDF Sample Plugins" selected="true"/>
                </com.izforge.izpack.panels.packs.PacksPanel>
                <com.izforge.izpack.panels.install.InstallPanel id="install"/>
                <com.izforge.izpack.panels.finish.FinishPanel id="finish"/>
            </AutomatedInstallation>',
                    $this->resolveBaseDirectory()
                )
            ) === false
        ) {
            $this->addToMessageBag("Failed to create install script");
            return false;
        }

        $installerJarIterator = $installerJarFinder->getIterator();
        $installerJarIterator->rewind();

        $installerJarFilename = $installerJarIterator->current()->getPathname();

        $installerJarOptions = [
            'java',
            '-jar',
            $installerJarFilename,
            $installerScriptFilename,
        ];

        if ($this->runProcess($installerJarOptions, $this->resolveBaseDirectory()) === false) {
            $this->addToMessageBag("Failed to run installer");
            return false;
        }

        return true;
    }

    /**
     * Runs the validator java application
     *
     * @return boolean
     */
    private function performValidation(): bool
    {
        if (!file_exists($this->resolveValidatorExecutable())) {
            $this->addToMessageBag("Validation application not found");
            return false;
        }

        $this->resetFileToValidateFilename();

        if (file_put_contents($this->resolveFileToValidateFilename(), $this->pdfContent) === false) {
            $this->addToMessageBag("Cannot create temporary file which contains the PDF to validate");
            return false;
        }

        $validatorExecutableOptions = [
            $this->resolveValidatorExecutable(),
            '--format',
            'json',
            '--flavour',
            $this->validatorRuleset,
            $this->resolveFileToValidateFilename(),
        ];

        if ($this->runProcessAndGetOutput($validatorExecutableOptions, $this->resolveBaseDirectory(), $validatorExecutableOutput) === false) {
            $this->checkValidatorExecutableOutput($validatorExecutableOutput);
            return false;
        }

        return $this->checkValidatorExecutableOutput($validatorExecutableOutput);
    }

    /**
     * Read and parse the JSON response
     *
     * @param  string $validatorExecutableOutput
     * @return bool
     */
    private function checkValidatorExecutableOutput(string $validatorExecutableOutput): bool
    {
        $validatorExecutableOutputObject = json_decode($validatorExecutableOutput);

        if ($validatorExecutableOutputObject === null && json_last_error() !== JSON_ERROR_NONE) {
            $this->addToMessageBag(sprintf("Cannot decode JSON result. Error %s", json_last_error_msg()), static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        if (!isset($validatorExecutableOutputObject->report)) {
            $this->addToMessageBag("Invalid report response - no report property found", static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        if (!isset($validatorExecutableOutputObject->report->jobs)) {
            $this->addToMessageBag("Invalid report response - no jobs property found", static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        if (!is_array($validatorExecutableOutputObject->report->jobs)) {
            $this->addToMessageBag("Invalid report response - jobs property is not an array", static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        if (count($validatorExecutableOutputObject->report->jobs) != 1) {
            $this->addToMessageBag("Invalid report response - jobs property should be an array with one element", static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        $validatorExecutableOutputJobObject = $validatorExecutableOutputObject->report->jobs[0];

        if (!isset($validatorExecutableOutputJobObject->validationResult)) {
            $this->addToMessageBag("Invalid report response - job has not a validationResult property", static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        if (!isset($validatorExecutableOutputJobObject->validationResult->details)) {
            $this->addToMessageBag("Invalid report response - job has not a details property", static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        if (!isset($validatorExecutableOutputJobObject->validationResult->details->failedRules)) {
            $this->addToMessageBag("Invalid report response - job has not a failedRules property", static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        if (!isset($validatorExecutableOutputJobObject->validationResult->details->failedChecks)) {
            $this->addToMessageBag("Invalid report response - job has not a failedChecks property", static::MSG_TYPE_VALIDATIONERROR);
            return false;
        }

        if ($validatorExecutableOutputJobObject->validationResult->details->failedRules == 0 && $validatorExecutableOutputJobObject->validationResult->details->failedChecks == 0) {
            return true;
        }

        $this->addToMessageBag(
            sprintf(
                "Validation failed. Failed rules: %s, Failed Checks: %s",
                $validatorExecutableOutputJobObject->validationResult->details->failedRules,
                $validatorExecutableOutputJobObject->validationResult->details->failedChecks
            ),
            static::MSG_TYPE_VALIDATIONERROR
        );

        foreach ($validatorExecutableOutputJobObject->validationResult->details->ruleSummaries ?? [] as $ruleSummary) {
            $this->addToMessageBag(
                sprintf(
                    "%s, %s, %s --> %s",
                    $ruleSummary->specification,
                    $ruleSummary->clause,
                    $ruleSummary->object,
                    $ruleSummary->description
                ),
                static::MSG_TYPE_VALIDATIONERROR
            );
        }

        return false;
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
     * @return bool
     */
    private function runProcess(array $command, string $workingdirectory): bool
    {
        return $this->runProcessAndGetOutput($command, $workingdirectory, $_);
    }

    /**
     * Runs a process. If the process runned successfully this method
     * returns true, otherwise false. The output of the process wil be
     * returned in $processOutput
     *
     * @param  array       $command
     * @param  string      $workingdirectory
     * @param  null|string &$processOutput
     * @return bool
     */
    private function runProcessAndGetOutput(array $command, string $workingdirectory, ?string &$processOutput): bool
    {
        try {
            $process = new Process($command);
            $process->setTimeout(0.0);
            $process->setWorkingDirectory($workingdirectory);
            $process->run();

            $processOutput = $process->getOutput();

            foreach (preg_split("/\r\n|\n|\r/", $processOutput) as $outputLine) {
                $this->addToMessageBag($outputLine, static::MSG_TYPE_PROCESSOUTPUT);
            }

            if (!$process->isSuccessful()) {
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
     * @param  string $url
     * @param  string $toFilePath
     * @param  bool   $forceOverwrite
     * @return bool
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
