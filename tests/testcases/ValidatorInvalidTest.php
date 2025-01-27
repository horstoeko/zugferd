<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdDocumentValidator;

class ValidatorInvalidTest extends TestCase
{
    /**
     * The document instance
     *
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . "/../assets/xml_en16931_5.xml");
    }

    public function testValidateDocument(): void
    {
        $validator = new ZugferdDocumentValidator(self::$document);
        $validationResult = $validator->validateDocument();
        $this->assertCount(1, $validationResult);
        $this->assertArrayHasKey(0, $validationResult);
        $this->assertEquals("This value should not be null.", $validationResult[0]->getMessage());
        $this->assertEquals("supplyChainTradeTransaction.applicableHeaderTradeAgreement.sellerTradeParty", $validationResult[0]->getPropertyPath());
    }
}
