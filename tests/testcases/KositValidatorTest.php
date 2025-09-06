<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\stringmanagement\PathUtils;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\tests\traits\RunsOnlyWithJavaEnvironmentTrait;
use horstoeko\zugferd\ZugferdDocument;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdKositValidator;

class KositValidatorTest extends TestCase
{
    use RunsOnlyWithJavaEnvironmentTrait;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        //$this->markAsSkippedIfJavaIsNotAvailable();
    }

    public function testMessageBag(): void
    {
        $kositValidator = ZugferdKositValidator::fromString(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertEmpty($this->getPrivatePropertyFromObject($kositValidator, 'messageBag')->getValue($kositValidator));
        $this->assertEmpty($kositValidator->getProcessOutput());
        $this->assertEmpty($kositValidator->getProcessErrors());
        $this->assertTrue($kositValidator->hasNoProcessErrors());
        $this->assertFalse($kositValidator->hasProcessErrors());
        $this->assertEmpty($kositValidator->getValidationErrors());
        $this->assertTrue($kositValidator->hasNoValidationErrors());
        $this->assertFalse($kositValidator->hasValidationErrors());
        $this->assertEmpty($kositValidator->getValidationWarnings());
        $this->assertTrue($kositValidator->hasNoValidationWarnings());
        $this->assertFalse($kositValidator->hasValidationWarnings());
        $this->assertEmpty($kositValidator->getValidationInformation());
        $this->assertTrue($kositValidator->hasNoValidationInformation());
        $this->assertFalse($kositValidator->hasValidationInformation());

        $this->getPrivateMethodFromObject($kositValidator, 'addToMessageBag')->invokeArgs($kositValidator, ['SomeError']);

        $this->assertEmpty($kositValidator->getProcessOutput());
        $this->assertCount(1, $kositValidator->getProcessErrors());
        $this->assertFalse($kositValidator->hasNoProcessErrors());
        $this->assertTrue($kositValidator->hasProcessErrors());
        $this->assertEmpty($kositValidator->getValidationErrors());
        $this->assertTrue($kositValidator->hasNoValidationErrors());
        $this->assertFalse($kositValidator->hasValidationErrors());
        $this->assertEmpty($kositValidator->getValidationWarnings());
        $this->assertTrue($kositValidator->hasNoValidationWarnings());
        $this->assertFalse($kositValidator->hasValidationWarnings());
        $this->assertEmpty($kositValidator->getValidationInformation());
        $this->assertTrue($kositValidator->hasNoValidationInformation());
        $this->assertFalse($kositValidator->hasValidationInformation());
        $this->assertArrayHasKey(0, $kositValidator->getProcessErrors());
        $this->assertSame('SomeError', $kositValidator->getProcessErrors()[0] ?? "");

        $this->getPrivateMethodFromObject($kositValidator, 'addToMessageBag')->invokeArgs($kositValidator, ['SomeError', 'validationerror']);

        $this->assertEmpty($kositValidator->getProcessOutput());
        $this->assertCount(1, $kositValidator->getProcessErrors());
        $this->assertFalse($kositValidator->hasNoProcessErrors());
        $this->assertTrue($kositValidator->hasProcessErrors());
        $this->assertCount(1, $kositValidator->getValidationErrors());
        $this->assertFalse($kositValidator->hasNoValidationErrors());
        $this->assertTrue($kositValidator->hasValidationErrors());
        $this->assertEmpty($kositValidator->getValidationWarnings());
        $this->assertTrue($kositValidator->hasNoValidationWarnings());
        $this->assertFalse($kositValidator->hasValidationWarnings());
        $this->assertEmpty($kositValidator->getValidationInformation());
        $this->assertTrue($kositValidator->hasNoValidationInformation());
        $this->assertFalse($kositValidator->hasValidationInformation());
        $this->assertSame('SomeError', $kositValidator->getProcessErrors()[0]);

        $this->getPrivateMethodFromObject($kositValidator, 'addToMessageBag')->invokeArgs($kositValidator, ['SomeError', 'validationwarning']);

        $this->assertEmpty($kositValidator->getProcessOutput());
        $this->assertCount(1, $kositValidator->getProcessErrors());
        $this->assertFalse($kositValidator->hasNoProcessErrors());
        $this->assertTrue($kositValidator->hasProcessErrors());
        $this->assertCount(1, $kositValidator->getValidationErrors());
        $this->assertFalse($kositValidator->hasNoValidationErrors());
        $this->assertTrue($kositValidator->hasValidationErrors());
        $this->assertCount(1, $kositValidator->getValidationWarnings());
        $this->assertFalse($kositValidator->hasNoValidationWarnings());
        $this->assertTrue($kositValidator->hasValidationWarnings());
        $this->assertEmpty($kositValidator->getValidationInformation());
        $this->assertTrue($kositValidator->hasNoValidationInformation());
        $this->assertFalse($kositValidator->hasValidationInformation());
        $this->assertSame('SomeError', $kositValidator->getProcessErrors()[0]);

        $this->getPrivateMethodFromObject($kositValidator, 'addToMessageBag')->invokeArgs($kositValidator, ['SomeError', 'validationinformation']);

        $this->assertEmpty($kositValidator->getProcessOutput());
        $this->assertCount(1, $kositValidator->getProcessErrors());
        $this->assertFalse($kositValidator->hasNoProcessErrors());
        $this->assertTrue($kositValidator->hasProcessErrors());
        $this->assertCount(1, $kositValidator->getValidationErrors());
        $this->assertFalse($kositValidator->hasNoValidationErrors());
        $this->assertTrue($kositValidator->hasValidationErrors());
        $this->assertCount(1, $kositValidator->getValidationWarnings());
        $this->assertFalse($kositValidator->hasNoValidationWarnings());
        $this->assertTrue($kositValidator->hasValidationWarnings());
        $this->assertCount(1, $kositValidator->getValidationInformation());
        $this->assertFalse($kositValidator->hasNoValidationInformation());
        $this->assertTrue($kositValidator->hasValidationInformation());
        $this->assertSame('SomeError', $kositValidator->getProcessErrors()[0]);

        $this->assertClearMessageBag($kositValidator);
    }

    public function testInstanciateFromStringFactory(): void
    {
        $kositValidator = ZugferdKositValidator::fromString(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $this->assertIsString($this->getPrivatePropertyFromObject($kositValidator, 'document')->getValue($kositValidator));
        $this->assertStringStartsWith("<?xml version='1.0' encoding='UTF-8'?>", $this->getPrivatePropertyFromObject($kositValidator, 'document')->getValue($kositValidator));
        $this->assertStringStartsWith("<?xml version='1.0' encoding='UTF-8'?>", $this->getPrivateMethodFromObject($kositValidator, 'getDocumentContent')->invokeArgs($kositValidator, []));
    }

    public function testInstanciateFromDocumentFactory(): void
    {
        $zugferdDocumentReader = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../assets/xml_en16931_1.xml');
        $kositValidator = ZugferdKositValidator::fromZugferdDocument($zugferdDocumentReader);

        $this->assertInitialValues($kositValidator);

        $this->assertInstanceOf(ZugferdDocument::class, $this->getPrivatePropertyFromObject($kositValidator, 'document')->getValue($kositValidator));
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $this->getPrivateMethodFromObject($kositValidator, 'getDocumentContent')->invokeArgs($kositValidator, []));
    }

    public function testInstanciateFromStringDirect(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $this->assertIsString($this->getPrivatePropertyFromObject($kositValidator, 'document')->getValue($kositValidator));
        $this->assertStringStartsWith("<?xml version='1.0' encoding='UTF-8'?>", $this->getPrivatePropertyFromObject($kositValidator, 'document')->getValue($kositValidator));
        $this->assertStringStartsWith("<?xml version='1.0' encoding='UTF-8'?>", $this->getPrivateMethodFromObject($kositValidator, 'getDocumentContent')->invokeArgs($kositValidator, []));
    }

    public function testInstanciateFromDocumentDirect(): void
    {
        $zugferdDocumentReader = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../assets/xml_en16931_1.xml');
        $kositValidator = new ZugferdKositValidator($zugferdDocumentReader);

        $this->assertInitialValues($kositValidator);

        $this->assertInstanceOf(ZugferdDocument::class, $this->getPrivatePropertyFromObject($kositValidator, 'document')->getValue($kositValidator));
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $this->getPrivateMethodFromObject($kositValidator, 'getDocumentContent')->invokeArgs($kositValidator, []));
    }

    public function testInstanciateFromNullDirect(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $this->assertNull($this->getPrivatePropertyFromObject($kositValidator, 'document')->getValue($kositValidator));
        $this->assertNull($this->getPrivatePropertyFromObject($kositValidator, 'document')->getValue($kositValidator));
    }

    public function testSetBaseDirectoryWhichExists(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setBaseDirectory(__DIR__);

        $this->assertSame(__DIR__, $this->getPrivatePropertyFromObject($kositValidator, 'baseDirectory')->getValue($kositValidator));
    }

    public function testSetBaseDirectoryWhichNotExists(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setBaseDirectory("/dummydirectory");

        $this->assertNotEquals("/dummydirectory", $this->getPrivatePropertyFromObject($kositValidator, 'baseDirectory')->getValue($kositValidator));
        $this->assertSame(sys_get_temp_dir(), $this->getPrivatePropertyFromObject($kositValidator, 'baseDirectory')->getValue($kositValidator));
    }

    public function testSetValidValidatorDownloadUrl(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorDownloadUrl("https://some.url");

        $this->assertSame("https://some.url", $this->getPrivatePropertyFromObject($kositValidator, 'validatorDownloadUrl')->getValue($kositValidator));
    }

    public function testSetInvalidValidatorDownloadUrl(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorDownloadUrl("dummy");

        $this->assertSame("https://github.com/itplr-kosit/validator/releases/download/v1.5.0/validator-1.5.0-distribution.zip", $this->getPrivatePropertyFromObject($kositValidator, 'validatorDownloadUrl')->getValue($kositValidator));
    }

    public function testSetValidValidatorScenarioDownloadUrl(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorScenarioDownloadUrl("https://some.url");

        $this->assertSame("https://some.url", $this->getPrivatePropertyFromObject($kositValidator, 'validatorScenarioDownloadUrl')->getValue($kositValidator));
    }

    public function testSetInvalidValidatorScenarioDownloadUrl(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorDownloadUrl("dummy");

        $this->assertSame("https://github.com/itplr-kosit/validator-configuration-xrechnung/releases/download/release-2025-03-21/validator-configuration-xrechnung_3.0.2_2025-03-21.zip", $this->getPrivatePropertyFromObject($kositValidator, 'validatorScenarioDownloadUrl')->getValue($kositValidator));
    }

    public function testSetValidatorAppZipFilename(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorAppZipFilename("dummy.zip");

        $this->assertSame("dummy.zip", $this->getPrivatePropertyFromObject($kositValidator, 'validatorAppZipFilename')->getValue($kositValidator));
    }

    public function testSetValidatorScenarioZipFilename(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorScenarioZipFilename("dummyscenario.zip");

        $this->assertSame("dummyscenario.zip", $this->getPrivatePropertyFromObject($kositValidator, 'validatorScenarioZipFilename')->getValue($kositValidator));
    }

    public function testSetValidatorAppJarFilename(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorAppJarFilename("dummy.jar");

        $this->assertSame("dummy.jar", $this->getPrivatePropertyFromObject($kositValidator, 'validatorAppJarFilename')->getValue($kositValidator));
    }

    public function testSetValidatorAppScenarioFilename(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorAppScenarioFilename("dummyscenario.xml");

        $this->assertSame("dummyscenario.xml", $this->getPrivatePropertyFromObject($kositValidator, 'validatorAppScenarioFilename')->getValue($kositValidator));
    }

    public function testDisableCleanup(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->disableCleanup();

        $this->assertTrue($this->getPrivatePropertyFromObject($kositValidator, 'cleanupBaseDirectoryIsDisabled')->getValue($kositValidator));
    }

    public function testEnableCleanup(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->enableCleanup();

        $this->assertFalse($this->getPrivatePropertyFromObject($kositValidator, 'cleanupBaseDirectoryIsDisabled')->getValue($kositValidator));
    }

    public function testDisableRemoteMode(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->disableRemoteMode();

        $this->assertFalse($this->getPrivatePropertyFromObject($kositValidator, 'remoteModeEnabled')->getValue($kositValidator));
    }

    public function testEnableRemoteMode(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->enableRemoteMode();

        $this->assertTrue($this->getPrivatePropertyFromObject($kositValidator, 'remoteModeEnabled')->getValue($kositValidator));
    }

    public function testSetRemoteModeHostWhichIsValid(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setRemoteModeHost("127.0.0.1");

        $this->assertSame("127.0.0.1", $this->getPrivatePropertyFromObject($kositValidator, 'remoteModeHost')->getValue($kositValidator));
    }

    public function testSetRemoteModeHostWhichIsInvalid(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setRemoteModeHost("127.0.0.1");

        $this->assertSame("127.0.0.1", $this->getPrivatePropertyFromObject($kositValidator, 'remoteModeHost')->getValue($kositValidator));

        $kositValidator->setRemoteModeHost("");

        $this->assertSame("127.0.0.1", $this->getPrivatePropertyFromObject($kositValidator, 'remoteModeHost')->getValue($kositValidator));
    }

    public function testSetRemoteModePortWhichIsValid(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setRemoteModePort(8080);

        $this->assertSame(8080, $this->getPrivatePropertyFromObject($kositValidator, 'remoteModePort')->getValue($kositValidator));
    }

    public function testSetRemoteModePortWhichIsInvalid(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->setRemoteModePort(8080);

        $this->assertSame(8080, $this->getPrivatePropertyFromObject($kositValidator, 'remoteModePort')->getValue($kositValidator));

        $kositValidator->setRemoteModePort(-1);

        $this->assertSame(8080, $this->getPrivatePropertyFromObject($kositValidator, 'remoteModePort')->getValue($kositValidator));
    }

    public function testGetRemoteModeUrl(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $this->assertSame("http://:0", $kositValidator->getRemoteModeUrl());
    }

    public function testCheckRequirementsLocalNoDocument(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $this->assertFalse($this->getPrivateMethodFromObject($kositValidator, 'checkRequirements')->invokeArgs($kositValidator, []), 'A document is missing');
        $this->assertCount(1, $kositValidator->getProcessErrors());
        $this->assertSame("You must specify an instance of the ZugferdDocument class", $kositValidator->getProcessErrors()[0]);
    }

    public function testCheckRequirementsLocalWithDocument(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        if ($this->isJavaAvailable()) {
            $this->assertTrue($this->getPrivateMethodFromObject($kositValidator, 'checkRequirements')->invokeArgs($kositValidator, []));
            $this->assertEmpty($kositValidator->getProcessErrors());
        } else {
            $this->assertFalse($this->getPrivateMethodFromObject($kositValidator, 'checkRequirements')->invokeArgs($kositValidator, []));
            $this->assertCount(1, $kositValidator->getProcessErrors());
            $this->assertSame("JAVA not installed on this machine", $kositValidator->getProcessErrors()[0]);
        }
    }

    public function testCheckRequirementsRemoteNoDocument(): void
    {
        $kositValidator = new ZugferdKositValidator();

        $this->assertInitialValues($kositValidator);

        $kositValidator->enableRemoteMode();
        $kositValidator->setRemoteModeHost("127.0.0.1");
        $kositValidator->setRemoteModePort(8080);

        $this->assertFalse($this->getPrivateMethodFromObject($kositValidator, 'checkRequirements')->invokeArgs($kositValidator, []), 'A document is missing');
        $this->assertCount(1, $kositValidator->getProcessErrors());
        $this->assertSame("You must specify an instance of the ZugferdDocument class", $kositValidator->getProcessErrors()[0]);
        $this->assertClearMessageBag($kositValidator);
    }

    public function testCheckRequirementsRemoteWithDocumentNoRemoteHost(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->enableRemoteMode();

        $this->assertFalse($this->getPrivateMethodFromObject($kositValidator, 'checkRequirements')->invokeArgs($kositValidator, []));
        $this->assertCount(1, $kositValidator->getProcessErrors());
        $this->assertSame("You must specify the hostname or it's IP where the Validator is running in daemon mode", $kositValidator->getProcessErrors()[0]);
        $this->assertClearMessageBag($kositValidator);
    }

    public function testCheckRequirementsRemoteWithDocumentNoRemotePort(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->enableRemoteMode();
        $kositValidator->setRemoteModeHost("127.0.0.1");

        $this->assertFalse($this->getPrivateMethodFromObject($kositValidator, 'checkRequirements')->invokeArgs($kositValidator, []));
        $this->assertCount(1, $kositValidator->getProcessErrors());
        $this->assertSame("You must specify the port of the host where the Validator is running in daemon mode", $kositValidator->getProcessErrors()[0]);
        $this->assertClearMessageBag($kositValidator);
    }

    public function testCheckRequirementsRemoteWithCompleteSetup(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->enableRemoteMode();
        $kositValidator->setRemoteModeHost("127.0.0.1");
        $kositValidator->setRemoteModePort(8080);

        $this->assertFalse($this->getPrivateMethodFromObject($kositValidator, 'checkRequirements')->invokeArgs($kositValidator, []));
        $this->assertCount(2, $kositValidator->getProcessErrors());
        $this->assertSame("Failed to connect to the host where the Validator is running in daemon mode", $kositValidator->getProcessErrors()[0]);
        $this->assertClearMessageBag($kositValidator);
    }

    public function testDownloadRequiredFilesLocal(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $filenameAppZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveAppZipFilename')->invokeArgs($kositValidator, []);
        $filenameScenarioZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveScenatioZipFilename')->invokeArgs($kositValidator, []);

        $this->registerFileForTeardown($filenameAppZip);
        $this->registerFileForTeardown($filenameScenarioZip);

        $this->assertTrue($this->getPrivateMethodFromObject($kositValidator, 'downloadRequiredFiles')->invokeArgs($kositValidator, []));
        $this->assertFileExists($filenameAppZip);
        $this->assertFileExists($filenameScenarioZip);
        $this->assertEmpty($kositValidator->getProcessErrors());
        $this->assertClearMessageBag($kositValidator);

        $this->invokeCleanup($kositValidator);
    }

    public function testDownloadRequiredFilesRemote(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->enableRemoteMode();
        $kositValidator->setRemoteModeHost("127.0.0.1");
        $kositValidator->setRemoteModePort(8080);

        $filenameAppZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveAppZipFilename')->invokeArgs($kositValidator, []);
        $filenameScenarioZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveScenatioZipFilename')->invokeArgs($kositValidator, []);

        $this->registerFileForTeardown($filenameAppZip);
        $this->registerFileForTeardown($filenameScenarioZip);

        $this->assertTrue($this->getPrivateMethodFromObject($kositValidator, 'downloadRequiredFiles')->invokeArgs($kositValidator, []));
        $this->assertFileDoesNotExist($filenameAppZip);
        $this->assertFileDoesNotExist($filenameScenarioZip);
        $this->assertEmpty($kositValidator->getProcessErrors());
        $this->assertClearMessageBag($kositValidator);

        $this->invokeCleanup($kositValidator);
    }

    public function testDownloadRequiredFilesLocalWithNotExistingValidatorDownload(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorDownloadUrl('https://github.com/itplr-kosit/validator/releases/download/v1.5.0/validator-1.5.0-distribution-unknown.zip');

        $filenameAppZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveAppZipFilename')->invokeArgs($kositValidator, []);
        $filenameScenarioZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveScenatioZipFilename')->invokeArgs($kositValidator, []);

        $this->registerFileForTeardown($filenameAppZip);
        $this->registerFileForTeardown($filenameScenarioZip);

        $this->assertFalse($this->getPrivateMethodFromObject($kositValidator, 'downloadRequiredFiles')->invokeArgs($kositValidator, []));
        $this->assertFileDoesNotExist($filenameAppZip);
        $this->assertFileDoesNotExist($filenameScenarioZip);
        $this->assertCount(2, $kositValidator->getProcessErrors());
        $this->assertStringContainsString("HTTP/1.1 404 Not Found", $kositValidator->getProcessErrors()[0]);
        $this->assertStringContainsString("Unable to download from", $kositValidator->getProcessErrors()[1]);
        $this->assertStringContainsString("containing the JAVA-Application", $kositValidator->getProcessErrors()[1]);
        $this->assertClearMessageBag($kositValidator);

        $this->invokeCleanup($kositValidator);
    }

    public function testDownloadRequiredFilesLocalWithNotExistingScenarioDownload(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->setValidatorScenarioDownloadUrl('https://github.com/itplr-kosit/validator-configuration-xrechnung/releases/download/release-2025-03-21/validator-configuration-xrechnung_3.0.2_2024-10-31-unknown.zip');

        $filenameAppZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveAppZipFilename')->invokeArgs($kositValidator, []);
        $filenameScenarioZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveScenatioZipFilename')->invokeArgs($kositValidator, []);

        $this->registerFileForTeardown($filenameAppZip);
        $this->registerFileForTeardown($filenameScenarioZip);

        $this->assertFalse($this->getPrivateMethodFromObject($kositValidator, 'downloadRequiredFiles')->invokeArgs($kositValidator, []));
        $this->assertFileExists($filenameAppZip);
        $this->assertFileDoesNotExist($filenameScenarioZip);
        $this->assertCount(2, $kositValidator->getProcessErrors());
        $this->assertStringContainsString("HTTP/1.1 404 Not Found", $kositValidator->getProcessErrors()[0]);
        $this->assertStringContainsString("Unable to download from", $kositValidator->getProcessErrors()[1]);
        $this->assertStringContainsString("containing the validation scenarios", $kositValidator->getProcessErrors()[1]);
        $this->assertClearMessageBag($kositValidator);

        $this->invokeCleanup($kositValidator);
    }

    public function testUnpackRequiredFilesLocal(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $filenameAppZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveAppZipFilename')->invokeArgs($kositValidator, []);
        $filenameScenarioZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveScenatioZipFilename')->invokeArgs($kositValidator, []);

        $baseDirectory = $this->getPrivateMethodFromObject($kositValidator, 'resolveBaseDirectory')->invokeArgs($kositValidator, []);

        $this->registerFileForTeardown($filenameAppZip);
        $this->registerFileForTeardown($filenameScenarioZip);

        $this->assertTrue($this->getPrivateMethodFromObject($kositValidator, 'downloadRequiredFiles')->invokeArgs($kositValidator, []));
        $this->assertFileExists($filenameAppZip);
        $this->assertFileExists($filenameScenarioZip);
        $this->assertEmpty($kositValidator->getProcessErrors());
        $this->assertClearMessageBag($kositValidator);

        $this->assertTrue($this->getPrivateMethodFromObject($kositValidator, 'unpackRequiredFiles')->invokeArgs($kositValidator, []));
        $this->assertFileExists(PathUtils::combinePathWithFile($baseDirectory, "scenarios.xml"));
        $this->assertFileExists(PathUtils::combinePathWithFile($baseDirectory, "validationtool-1.5.0.jar"));
        $this->assertFileExists(PathUtils::combinePathWithFile($baseDirectory, "validationtool-1.5.0-java8-standalone.jar"));
        $this->assertFileExists(PathUtils::combinePathWithFile($baseDirectory, "validationtool-1.5.0-standalone.jar"));
        $this->assertDirectoryExists(PathUtils::combinePathWithPath($baseDirectory, "resources"));
        $this->assertDirectoryExists(PathUtils::combinePathWithPath($baseDirectory, "libs"));

        $this->invokeCleanup($kositValidator);
    }

    public function testUnpackRequiredFilesRemote(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->enableRemoteMode();
        $kositValidator->setRemoteModeHost("127.0.0.1");
        $kositValidator->setRemoteModePort(8080);

        $filenameAppZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveAppZipFilename')->invokeArgs($kositValidator, []);
        $filenameScenarioZip = $this->getPrivateMethodFromObject($kositValidator, 'resolveScenatioZipFilename')->invokeArgs($kositValidator, []);

        $baseDirectory = $this->getPrivateMethodFromObject($kositValidator, 'resolveBaseDirectory')->invokeArgs($kositValidator, []);

        $this->registerFileForTeardown($filenameAppZip);
        $this->registerFileForTeardown($filenameScenarioZip);

        $this->assertTrue($this->getPrivateMethodFromObject($kositValidator, 'downloadRequiredFiles')->invokeArgs($kositValidator, []));
        $this->assertFileDoesNotExist($filenameAppZip);
        $this->assertFileDoesNotExist($filenameScenarioZip);
        $this->assertEmpty($kositValidator->getProcessErrors());
        $this->assertClearMessageBag($kositValidator);

        $this->assertTrue($this->getPrivateMethodFromObject($kositValidator, 'unpackRequiredFiles')->invokeArgs($kositValidator, []));
        $this->assertFileDoesNotExist(PathUtils::combinePathWithFile($baseDirectory, "scenarios.xml"));
        $this->assertFileDoesNotExist(PathUtils::combinePathWithFile($baseDirectory, "validationtool-1.5.0.jar"));
        $this->assertFileDoesNotExist(PathUtils::combinePathWithFile($baseDirectory, "validationtool-1.5.0-java8-standalone.jar"));
        $this->assertFileDoesNotExist(PathUtils::combinePathWithFile($baseDirectory, "validationtool-1.5.0-standalone.jar"));
        $this->assertDirectoryDoesNotExist(PathUtils::combinePathWithPath($baseDirectory, "resources"));
        $this->assertDirectoryDoesNotExist(PathUtils::combinePathWithPath($baseDirectory, "libs"));

        $this->invokeCleanup($kositValidator);
    }

    public function testValidateValidDocument(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_en16931_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->validate();

        if ($this->isJavaAvailable()) {
            $this->assertTrue($kositValidator->hasNoProcessErrors());
            $this->assertFalse($kositValidator->hasProcessErrors());
            $this->assertTrue($kositValidator->hasNoValidationErrors());
            $this->assertFalse($kositValidator->hasValidationErrors());
            $this->assertTrue($kositValidator->hasNoValidationWarnings());
            $this->assertFalse($kositValidator->hasValidationWarnings());
            $this->assertTrue($kositValidator->hasNoValidationInformation());
            $this->assertFalse($kositValidator->hasValidationInformation());
            $this->assertEmpty($kositValidator->getProcessErrors());
            $this->assertNotEmpty($kositValidator->getProcessOutput());
        } else {
            $this->assertFalse($kositValidator->hasNoProcessErrors());
            $this->assertTrue($kositValidator->hasProcessErrors());
            $this->assertTrue($kositValidator->hasNoValidationErrors());
            $this->assertFalse($kositValidator->hasValidationErrors());
            $this->assertTrue($kositValidator->hasNoValidationWarnings());
            $this->assertFalse($kositValidator->hasValidationWarnings());
            $this->assertTrue($kositValidator->hasNoValidationInformation());
            $this->assertFalse($kositValidator->hasValidationInformation());
            $this->assertCount(1, $kositValidator->getProcessErrors());
            $this->assertStringContainsString("JAVA not installed on this machine", $kositValidator->getProcessErrors()[0]);
            $this->assertEmpty($kositValidator->getProcessOutput());
        }
    }

    public function testValidateInvalidDocument(): void
    {
        $kositValidator = new ZugferdKositValidator(file_get_contents(__DIR__ . '/../assets/xml_invalid_1.xml'));

        $this->assertInitialValues($kositValidator);

        $kositValidator->validate();

        if ($this->isJavaAvailable()) {
            $this->assertTrue($kositValidator->hasNoProcessErrors());
            $this->assertFalse($kositValidator->hasProcessErrors());
            $this->assertFalse($kositValidator->hasNoValidationErrors());
            $this->assertTrue($kositValidator->hasValidationErrors());
            $this->assertTrue($kositValidator->hasNoValidationWarnings());
            $this->assertFalse($kositValidator->hasValidationWarnings());
            $this->assertTrue($kositValidator->hasNoValidationInformation());
            $this->assertFalse($kositValidator->hasValidationInformation());
            $this->assertEmpty($kositValidator->getProcessErrors());
            $this->assertNotEmpty($kositValidator->getProcessOutput());
            $this->assertCount(1, $kositValidator->getValidationErrors());
            $this->assertContains("Validation error. One ore more files were rejected", $kositValidator->getValidationErrors());
        } else {
            $this->assertFalse($kositValidator->hasNoProcessErrors());
            $this->assertTrue($kositValidator->hasProcessErrors());
            $this->assertTrue($kositValidator->hasNoValidationErrors());
            $this->assertFalse($kositValidator->hasValidationErrors());
            $this->assertTrue($kositValidator->hasNoValidationWarnings());
            $this->assertFalse($kositValidator->hasValidationWarnings());
            $this->assertTrue($kositValidator->hasNoValidationInformation());
            $this->assertFalse($kositValidator->hasValidationInformation());
            $this->assertCount(1, $kositValidator->getProcessErrors());
            $this->assertEmpty($kositValidator->getProcessOutput());
            $this->assertEmpty($kositValidator->getValidationErrors());
            $this->assertStringContainsString("JAVA not installed on this machine", $kositValidator->getProcessErrors()[0]);
        }
    }

    /**
     * Check initial values after instanciation
     *
     * @param  ZugferdKositValidator $kositValidator
     * @return void
     */
    private function assertInitialValues(ZugferdKositValidator $kositValidator): void
    {
        $this->assertMessageBagIsEmpty($kositValidator);
        $this->assertIsString($this->getPrivatePropertyFromObject($kositValidator, 'baseDirectory')->getValue($kositValidator));
        $this->assertNotSame("", $this->getPrivatePropertyFromObject($kositValidator, 'baseDirectory')->getValue($kositValidator));
        $this->assertSame(sys_get_temp_dir(), $this->getPrivatePropertyFromObject($kositValidator, 'baseDirectory')->getValue($kositValidator));
        $this->assertSame("https://github.com/itplr-kosit/validator/releases/download/v1.5.0/validator-1.5.0-distribution.zip", $this->getPrivatePropertyFromObject($kositValidator, 'validatorDownloadUrl')->getValue($kositValidator));
        $this->assertSame("https://github.com/itplr-kosit/validator-configuration-xrechnung/releases/download/release-2025-03-21/validator-configuration-xrechnung_3.0.2_2025-03-21.zip", $this->getPrivatePropertyFromObject($kositValidator, 'validatorScenarioDownloadUrl')->getValue($kositValidator));
        $this->assertSame("validator.zip", $this->getPrivatePropertyFromObject($kositValidator, 'validatorAppZipFilename')->getValue($kositValidator));
        $this->assertSame("validator-configuration.zip", $this->getPrivatePropertyFromObject($kositValidator, 'validatorScenarioZipFilename')->getValue($kositValidator));
        $this->assertSame("validationtool-1.5.0-standalone.jar", $this->getPrivatePropertyFromObject($kositValidator, 'validatorAppJarFilename')->getValue($kositValidator));
        $this->assertSame("scenarios.xml", $this->getPrivatePropertyFromObject($kositValidator, 'validatorAppScenarioFilename')->getValue($kositValidator));
        $this->assertSame("", $this->getPrivatePropertyFromObject($kositValidator, 'fileToValidateFilename')->getValue($kositValidator));
        $this->assertFalse($this->getPrivatePropertyFromObject($kositValidator, 'cleanupBaseDirectoryIsDisabled')->getValue($kositValidator));
        $this->assertFalse($this->getPrivatePropertyFromObject($kositValidator, 'remoteModeEnabled')->getValue($kositValidator));
        $this->assertSame("", $this->getPrivatePropertyFromObject($kositValidator, 'remoteModeHost')->getValue($kositValidator));
        $this->assertSame(0, $this->getPrivatePropertyFromObject($kositValidator, 'remoteModePort')->getValue($kositValidator));

        $this->assertStringStartsWith(sys_get_temp_dir(), $this->getPrivateMethodFromObject($kositValidator, 'resolveBaseDirectory')->invokeArgs($kositValidator, []));
        $this->assertStringEndsWith('validator.zip', $this->getPrivateMethodFromObject($kositValidator, 'resolveAppZipFilename')->invokeArgs($kositValidator, []));
        $this->assertStringEndsWith('validator-configuration.zip', $this->getPrivateMethodFromObject($kositValidator, 'resolveScenatioZipFilename')->invokeArgs($kositValidator, []));
        $this->assertStringEndsWith('validationtool-1.5.0-standalone.jar', $this->getPrivateMethodFromObject($kositValidator, 'resolveAppJarFilename')->invokeArgs($kositValidator, []));
        $this->assertStringEndsWith('scenarios.xml', $this->getPrivateMethodFromObject($kositValidator, 'resolveAppScenarioFilename')->invokeArgs($kositValidator, []));
        $this->assertStringStartsWith(sys_get_temp_dir(), $this->getPrivateMethodFromObject($kositValidator, 'resolveFileToValidateFilename')->invokeArgs($kositValidator, []));
        $this->assertStringEndsWith('.xml', $this->getPrivateMethodFromObject($kositValidator, 'resolveFileToValidateFilename')->invokeArgs($kositValidator, []));
    }

    /**
     * Check for empty message bag
     *
     * @param  ZugferdKositValidator $kositValidator
     * @return void
     */
    private function assertMessageBagIsEmpty(ZugferdKositValidator $kositValidator): void
    {
        $this->assertEmpty($this->getPrivatePropertyFromObject($kositValidator, 'messageBag')->getValue($kositValidator));
    }

    /**
     * Clear message bag assertions
     *
     * @param  ZugferdKositValidator $kositValidator
     * @return void
     */
    private function assertClearMessageBag(ZugferdKositValidator $kositValidator): void
    {
        $this->getPrivateMethodFromObject($kositValidator, 'clearMessageBag')->invokeArgs($kositValidator, []);
        $this->assertMessageBagIsEmpty($kositValidator);
    }

    /**
     * Invoke cleanup directories
     *
     * @param  ZugferdKositValidator $kositValidator
     * @return void
     */
    private function invokeCleanup(ZugferdKositValidator $kositValidator): void
    {
        $this->getPrivateMethodFromObject($kositValidator, 'cleanupBaseDirectory')->invokeArgs($kositValidator, []);
    }
}
