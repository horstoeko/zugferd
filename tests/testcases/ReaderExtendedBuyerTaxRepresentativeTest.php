<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentReader;

/**
 * Round-trip test for new fork features in the EXTENDED profile:
 * BuyerTaxRepresentativeParty (BG-X-54), getDocumentBusinessProcess, getDocumentForeignCurrency.
 * Builds a document with these features, then reads it back and verifies all values.
 */
class ReaderExtendedBuyerTaxRepresentativeTest extends TestCase
{
    /**
     * The document instance
     *
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        $builder = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EXTENDED);

        $builder
            ->setDocumentInformation("BTRTST-001", "380", \DateTime::createFromFormat("Ymd", "20250601"), "EUR")
            ->setDocumentBusinessProcess("urn:fdc:peppol.eu:2017:poacc:billing:01:1.0")
            ->addDocumentNote("Test document for BuyerTaxRepresentative")
            ->setDocumentSeller("Seller Corp", "SELL-01")
            ->setDocumentSellerAddress("Seller Street 1", "", "", "10115", "Berlin", "DE")
            ->addDocumentSellerTaxRegistration("VA", "DE123456789")
            ->setDocumentBuyer("Buyer Corp", "BUY-01")
            ->setDocumentBuyerAddress("Buyer Lane 5", "", "", "80331", "München", "DE")
            ->setDocumentBuyerTaxRepresentativeTradeParty("Tax Rep GmbH", "TAXREP-01")
            ->addDocumentBuyerTaxRepresentativeGlobalId("4000001123452", "0088")
            ->addDocumentBuyerTaxRepresentativeTaxRegistration("VA", "DE999888777")
            ->setDocumentBuyerTaxRepresentativeAddress("Steuerstr. 42", "Gebäude B", "3. OG", "50667", "Köln", "DE", "NRW")
            ->setDocumentBuyerTaxRepresentativeLegalOrganisation("REG-12345", "0002", "Tax Rep Trading")
            ->setDocumentBuyerTaxRepresentativeContact("Max Steuer", "Steuerabteilung", "+49 221 555 0001", "+49 221 555 0002", "max@taxrep.de")
            ->addDocumentBuyerTaxRepresentativeContact("Lisa Abgabe", "Buchhaltung", "+49 221 555 0003", "+49 221 555 0004", "lisa@taxrep.de")
            ->addNewPosition("1")
            ->setDocumentPositionProductDetails("Test Product")
            ->setDocumentPositionNetPrice(100.00)
            ->setDocumentPositionQuantity(1, "C62")
            ->addDocumentPositionTax("S", "VAT", 19.0)
            ->setDocumentPositionLineSummation(100.00)
            ->setDocumentSummation(119.00, 119.00, 100.00, 0.0, 0.0, 100.00, 19.00)
            ->addDocumentTax("S", "VAT", 100.00, 19.00, 19.0)
            ->setForeignCurrency("USD", 22.61, 1.19);

        $xml = $builder->getContent();
        self::$document = ZugferdDocumentReader::readAndGuessFromContent($xml);
    }

    public function testGetDocumentBusinessProcess(): void
    {
        self::$document->getDocumentBusinessProcess($businessProcess);

        self::assertSame("urn:fdc:peppol.eu:2017:poacc:billing:01:1.0", $businessProcess);
    }

    public function testGetDocumentForeignCurrency(): void
    {
        self::$document->getDocumentForeignCurrency($foreignCurrencyCode, $foreignTaxAmount, $exchangeRate);

        self::assertSame("USD", $foreignCurrencyCode);
        self::assertEqualsWithDelta(22.61, $foreignTaxAmount, 0.01);
        self::assertEqualsWithDelta(1.19, $exchangeRate, 0.01);
    }

    public function testGetDocumentForeignCurrencyEmptyWhenNotSet(): void
    {
        $emptyBuilder = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EXTENDED);
        $emptyBuilder
            ->setDocumentInformation("EMPTY-001", "380", \DateTime::createFromFormat("Ymd", "20250601"), "EUR")
            ->setDocumentSeller("Seller Corp")
            ->setDocumentSellerAddress("Street", "", "", "10115", "Berlin", "DE")
            ->addDocumentSellerTaxRegistration("VA", "DE123456789")
            ->setDocumentBuyer("Buyer Corp")
            ->addNewPosition("1")
            ->setDocumentPositionProductDetails("Test")
            ->setDocumentPositionNetPrice(100.00)
            ->setDocumentPositionQuantity(1, "C62")
            ->addDocumentPositionTax("S", "VAT", 19.0)
            ->setDocumentPositionLineSummation(100.00)
            ->setDocumentSummation(119.00, 119.00, 100.00, 0.0, 0.0, 100.00, 19.00)
            ->addDocumentTax("S", "VAT", 100.00, 19.00, 19.0);

        $reader = ZugferdDocumentReader::readAndGuessFromContent($emptyBuilder->getContent());
        $reader->getDocumentForeignCurrency($code, $amount, $rate);

        self::assertSame("", $code);
        self::assertEqualsWithDelta(0.0, $amount, 0.01);
        self::assertEqualsWithDelta(0.0, $rate, 0.01);
    }

    public function testGetDocumentBuyerTaxRepresentative(): void
    {
        self::$document->getDocumentBuyerTaxRepresentative($name, $id, $description);

        self::assertEquals("Tax Rep GmbH", $name);
        self::assertIsArray($id);
        self::assertNotEmpty($id);
        self::assertEquals("TAXREP-01", $id[0]);
        self::assertEquals("", $description);
    }

    public function testGetDocumentBuyerTaxRepresentativeGlobalId(): void
    {
        self::$document->getDocumentBuyerTaxRepresentativeGlobalId($globalID);

        self::assertIsArray($globalID);
        self::assertArrayHasKey("0088", $globalID);
        self::assertEquals("4000001123452", $globalID["0088"]);
    }

    public function testGetDocumentBuyerTaxRepresentativeTaxRegistration(): void
    {
        self::$document->getDocumentBuyerTaxRepresentativeTaxRegistration($taxReg);

        self::assertIsArray($taxReg);
        self::assertArrayHasKey("VA", $taxReg);
        self::assertEquals("DE999888777", $taxReg["VA"]);
    }

    public function testGetDocumentBuyerTaxRepresentativeAddress(): void
    {
        self::$document->getDocumentBuyerTaxRepresentativeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        self::assertEquals("Steuerstr. 42", $lineOne);
        self::assertEquals("Gebäude B", $lineTwo);
        self::assertEquals("3. OG", $lineThree);
        self::assertEquals("50667", $postCode);
        self::assertEquals("Köln", $city);
        self::assertEquals("DE", $country);
        self::assertIsArray($subDivision);
        self::assertContains("NRW", $subDivision);
    }

    public function testGetDocumentBuyerTaxRepresentativeLegalOrganisation(): void
    {
        self::$document->getDocumentBuyerTaxRepresentativeLegalOrganisation($legalOrgId, $legalOrgType, $legalOrgName);

        self::assertEquals("REG-12345", $legalOrgId);
        self::assertEquals("0002", $legalOrgType);
        self::assertEquals("Tax Rep Trading", $legalOrgName);
    }

    public function testFirstDocumentBuyerTaxRepresentativeContact(): void
    {
        self::assertTrue(self::$document->firstDocumentBuyerTaxRepresentativeContact());
    }

    public function testGetDocumentBuyerTaxRepresentativeContactFirst(): void
    {
        self::$document->firstDocumentBuyerTaxRepresentativeContact();
        self::$document->getDocumentBuyerTaxRepresentativeContact($personName, $deptName, $phone, $fax, $email);

        self::assertEquals("Max Steuer", $personName);
        self::assertEquals("Steuerabteilung", $deptName);
        self::assertEquals("+49 221 555 0001", $phone);
        self::assertEquals("+49 221 555 0002", $fax);
        self::assertEquals("max@taxrep.de", $email);
    }

    public function testNextDocumentBuyerTaxRepresentativeContact(): void
    {
        self::$document->firstDocumentBuyerTaxRepresentativeContact();
        self::assertTrue(self::$document->nextDocumentBuyerTaxRepresentativeContact());
    }

    public function testGetDocumentBuyerTaxRepresentativeContactSecond(): void
    {
        self::$document->firstDocumentBuyerTaxRepresentativeContact();
        self::$document->nextDocumentBuyerTaxRepresentativeContact();
        self::$document->getDocumentBuyerTaxRepresentativeContact($personName, $deptName, $phone, $fax, $email);

        self::assertEquals("Lisa Abgabe", $personName);
        self::assertEquals("Buchhaltung", $deptName);
        self::assertEquals("+49 221 555 0003", $phone);
        self::assertEquals("+49 221 555 0004", $fax);
        self::assertEquals("lisa@taxrep.de", $email);
    }

    public function testNoThirdContact(): void
    {
        self::$document->firstDocumentBuyerTaxRepresentativeContact();
        self::$document->nextDocumentBuyerTaxRepresentativeContact();
        self::assertFalse(self::$document->nextDocumentBuyerTaxRepresentativeContact());
    }
}