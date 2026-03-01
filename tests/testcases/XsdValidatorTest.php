<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdXsdValidator;

class XsdValidatorTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $documentValid;

    /**
     * @var ZugferdDocumentReader
     */
    protected static $documentInvalid;

    public static function setUpBeforeClass(): void
    {
        self::$documentValid = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../assets/xml_en16931_1.xml');
        self::$documentInvalid = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../assets/xml_en16931_5.xml');
    }

    public function testValidDocumentHasNoErrors(): void
    {
        $validator = new ZugferdXsdValidator(self::$documentValid);
        $validator->validate();

        self::assertTrue($validator->hasNoValidationErrors());
        self::assertFalse($validator->hasValidationErrors());
        self::assertEmpty($validator->validationErrors());
    }

    public function testValidDocumentStatusMethods(): void
    {
        $validator = new ZugferdXsdValidator(self::$documentValid);
        $validator->validate();

        self::assertTrue($validator->hasNoValidationErrors());
        self::assertFalse($validator->hasValidationErrors());
    }

    public function testValidateReturnsSelf(): void
    {
        $validator = new ZugferdXsdValidator(self::$documentValid);
        $result = $validator->validate();

        self::assertSame($validator, $result);
    }

    public function testValidationErrorsReturnArray(): void
    {
        $validator = new ZugferdXsdValidator(self::$documentValid);
        $validator->validate();

        self::assertIsArray($validator->validationErrors());
    }
}
