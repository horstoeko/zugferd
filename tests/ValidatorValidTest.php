<?php

namespace horstoeko\zugferd\tests;

use \horstoeko\zugferd\ZugferdDocumentReader;
use \horstoeko\zugferd\ZugferdDocumentValidator;

class ValidatorValidTest extends TestCase
{
    /**
     * The document instance
     *
     * @var ZugferdDocumentReader
     */
    protected static $document;

    /**
     * The validator instance
     *
     * @var ZugferdDocumentValidator
     */
    protected static $validator;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/data/en16931_simple.xml");
        self::$validator = new ZugferdDocumentValidator(self::$document);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentValidator::validateDocument
     */
    public function testValidateDocument(): void
    {
        $validationResult = self::$validator->validateDocument();
        $this->assertEquals(0, count($validationResult));
    }
}
