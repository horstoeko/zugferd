<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdDocumentValidator;

class ValidatorValidTest extends TestCase
{
    /**
     * The document instance
     *
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . "/../assets/xml_en16931_1.xml");
    }

    public function testValidateDocument(): void
    {
        $validator = new ZugferdDocumentValidator(self::$document);
        $validationResult = $validator->validateDocument();
        $this->assertEmpty($validationResult);
    }
}
