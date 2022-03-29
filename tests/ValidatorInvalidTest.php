<?php

namespace horstoeko\zugferd\tests;

use \horstoeko\zugferd\ZugferdDocumentReader;
use \horstoeko\zugferd\ZugferdDocumentValidator;

class ValidatorInvalidTest extends TestCase
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
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/data/en16931_simple_invalid.xml");
        self::$validator = new ZugferdDocumentValidator(self::$document);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentValidator::validateDocument
     */
    public function testValidateDocument(): void
    {
        $validationResult = self::$validator->validateDocument();
        $this->assertEquals(1, count($validationResult));
        $this->assertArrayHasKey(0, $validationResult);
        $this->assertEquals("This value should not be null.", $validationResult[0]->getMessage());
        $this->assertEquals("supplyChainTradeTransaction.applicableHeaderTradeAgreement.sellerTradeParty", $validationResult[0]->getPropertyPath());
    }
}
