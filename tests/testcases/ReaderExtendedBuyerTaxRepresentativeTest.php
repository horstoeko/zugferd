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
            ->setForeignCurrency("USD", 22.61, 1.19)
            ->addDocumentUltimateCustomerOrderReferencedDocument("UCO-001", \DateTime::createFromFormat("Ymd", "20250501"))
            ->addDocumentUltimateCustomerOrderReferencedDocument("UCO-002", \DateTime::createFromFormat("Ymd", "20250515"))
            ->addDocumentPositionUltimateCustomerOrderReferencedDocument("POS-UCO-001", "10", \DateTime::createFromFormat("Ymd", "20250520"));

        $xml = $builder->getContent();
        self::$document = ZugferdDocumentReader::readAndGuessFromContent($xml);
    }

    public function testGetDocumentBusinessProcess(): void
    {
        self::$document->getDocumentBusinessProcess($businessProcess);

        $this->assertSame("urn:fdc:peppol.eu:2017:poacc:billing:01:1.0", $businessProcess);
    }

    public function testGetDocumentForeignCurrency(): void
    {
        self::$document->getDocumentForeignCurrency($foreignCurrencyCode, $foreignTaxAmount, $exchangeRate);

        $this->assertSame("USD", $foreignCurrencyCode);
        $this->assertEqualsWithDelta(22.61, $foreignTaxAmount, 0.01);
        $this->assertEqualsWithDelta(1.19, $exchangeRate, 0.01);
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

        $this->assertSame("", $code);
        $this->assertEqualsWithDelta(0.0, $amount, 0.01);
        $this->assertEqualsWithDelta(0.0, $rate, 0.01);
    }

    public function testGetDocumentBuyerTaxRepresentative(): void
    {
        self::$document->getDocumentBuyerTaxRepresentative($name, $id, $description);

        $this->assertEquals("Tax Rep GmbH", $name);
        $this->assertIsArray($id);
        $this->assertNotEmpty($id);
        $this->assertEquals("TAXREP-01", $id[0]);
        $this->assertEquals("", $description);
    }

    public function testGetDocumentBuyerTaxRepresentativeGlobalId(): void
    {
        self::$document->getDocumentBuyerTaxRepresentativeGlobalId($globalID);

        $this->assertIsArray($globalID);
        $this->assertArrayHasKey("0088", $globalID);
        $this->assertEquals("4000001123452", $globalID["0088"]);
    }

    public function testGetDocumentBuyerTaxRepresentativeTaxRegistration(): void
    {
        self::$document->getDocumentBuyerTaxRepresentativeTaxRegistration($taxReg);

        $this->assertIsArray($taxReg);
        $this->assertArrayHasKey("VA", $taxReg);
        $this->assertEquals("DE999888777", $taxReg["VA"]);
    }

    public function testGetDocumentBuyerTaxRepresentativeAddress(): void
    {
        self::$document->getDocumentBuyerTaxRepresentativeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->assertEquals("Steuerstr. 42", $lineOne);
        $this->assertEquals("Gebäude B", $lineTwo);
        $this->assertEquals("3. OG", $lineThree);
        $this->assertEquals("50667", $postCode);
        $this->assertEquals("Köln", $city);
        $this->assertEquals("DE", $country);
        $this->assertIsArray($subDivision);
        $this->assertContains("NRW", $subDivision);
    }

    public function testGetDocumentBuyerTaxRepresentativeLegalOrganisation(): void
    {
        self::$document->getDocumentBuyerTaxRepresentativeLegalOrganisation($legalOrgId, $legalOrgType, $legalOrgName);

        $this->assertEquals("REG-12345", $legalOrgId);
        $this->assertEquals("0002", $legalOrgType);
        $this->assertEquals("Tax Rep Trading", $legalOrgName);
    }

    public function testFirstDocumentBuyerTaxRepresentativeContact(): void
    {
        $this->assertTrue(self::$document->firstDocumentBuyerTaxRepresentativeContact());
    }

    public function testGetDocumentBuyerTaxRepresentativeContactFirst(): void
    {
        self::$document->firstDocumentBuyerTaxRepresentativeContact();
        self::$document->getDocumentBuyerTaxRepresentativeContact($personName, $deptName, $phone, $fax, $email);

        $this->assertEquals("Max Steuer", $personName);
        $this->assertEquals("Steuerabteilung", $deptName);
        $this->assertEquals("+49 221 555 0001", $phone);
        $this->assertEquals("+49 221 555 0002", $fax);
        $this->assertEquals("max@taxrep.de", $email);
    }

    public function testNextDocumentBuyerTaxRepresentativeContact(): void
    {
        self::$document->firstDocumentBuyerTaxRepresentativeContact();
        $this->assertTrue(self::$document->nextDocumentBuyerTaxRepresentativeContact());
    }

    public function testGetDocumentBuyerTaxRepresentativeContactSecond(): void
    {
        self::$document->firstDocumentBuyerTaxRepresentativeContact();
        self::$document->nextDocumentBuyerTaxRepresentativeContact();
        self::$document->getDocumentBuyerTaxRepresentativeContact($personName, $deptName, $phone, $fax, $email);

        $this->assertEquals("Lisa Abgabe", $personName);
        $this->assertEquals("Buchhaltung", $deptName);
        $this->assertEquals("+49 221 555 0003", $phone);
        $this->assertEquals("+49 221 555 0004", $fax);
        $this->assertEquals("lisa@taxrep.de", $email);
    }

    public function testNoThirdContact(): void
    {
        self::$document->firstDocumentBuyerTaxRepresentativeContact();
        self::$document->nextDocumentBuyerTaxRepresentativeContact();
        $this->assertFalse(self::$document->nextDocumentBuyerTaxRepresentativeContact());
    }

    public function testGetDocumentUltimateCustomerOrderReferencedDocuments(): void
    {
        self::$document->getDocumentUltimateCustomerOrderReferencedDocuments($refdocs);

        $this->assertIsArray($refdocs);
        $this->assertCount(2, $refdocs);
        $this->assertEquals("UCO-001", $refdocs[0]['issuerAssignedId']);
        $this->assertEquals("UCO-002", $refdocs[1]['issuerAssignedId']);
    }

    public function testFirstDocumentUltimateCustomerOrderReferencedDocument(): void
    {
        $this->assertTrue(self::$document->firstDocumentUltimateCustomerOrderReferencedDocument());
    }

    public function testGetDocumentUltimateCustomerOrderReferencedDocumentFirst(): void
    {
        self::$document->firstDocumentUltimateCustomerOrderReferencedDocument();
        self::$document->getDocumentUltimateCustomerOrderReferencedDocument($issuerAssignedId, $issueDate);

        $this->assertEquals("UCO-001", $issuerAssignedId);
        $this->assertInstanceOf(\DateTime::class, $issueDate);
        $this->assertEquals("20250501", $issueDate->format("Ymd"));
    }

    public function testNextDocumentUltimateCustomerOrderReferencedDocument(): void
    {
        self::$document->firstDocumentUltimateCustomerOrderReferencedDocument();
        $this->assertTrue(self::$document->nextDocumentUltimateCustomerOrderReferencedDocument());

        self::$document->getDocumentUltimateCustomerOrderReferencedDocument($issuerAssignedId, $issueDate);

        $this->assertEquals("UCO-002", $issuerAssignedId);
        $this->assertEquals("20250515", $issueDate->format("Ymd"));
    }

    public function testNoThirdDocumentUltimateCustomerOrderReferencedDocument(): void
    {
        self::$document->firstDocumentUltimateCustomerOrderReferencedDocument();
        self::$document->nextDocumentUltimateCustomerOrderReferencedDocument();
        $this->assertFalse(self::$document->nextDocumentUltimateCustomerOrderReferencedDocument());
    }

    public function testFirstDocumentPositionUltimateCustomerOrderReferencedDocument(): void
    {
        self::$document->firstDocumentPosition();
        $this->assertTrue(self::$document->firstDocumentPositionUltimateCustomerOrderReferencedDocument());
    }

    public function testGetDocumentPositionUltimateCustomerOrderReferencedDocument(): void
    {
        self::$document->firstDocumentPosition();
        self::$document->firstDocumentPositionUltimateCustomerOrderReferencedDocument();
        self::$document->getDocumentPositionUltimateCustomerOrderReferencedDocument($issuerAssignedId, $lineId, $issueDate);

        $this->assertEquals("POS-UCO-001", $issuerAssignedId);
        $this->assertEquals("10", $lineId);
        $this->assertInstanceOf(\DateTime::class, $issueDate);
        $this->assertEquals("20250520", $issueDate->format("Ymd"));
    }

    public function testNoSecondDocumentPositionUltimateCustomerOrderReferencedDocument(): void
    {
        self::$document->firstDocumentPosition();
        self::$document->firstDocumentPositionUltimateCustomerOrderReferencedDocument();
        $this->assertFalse(self::$document->nextDocumentPositionUltimateCustomerOrderReferencedDocument());
    }
}