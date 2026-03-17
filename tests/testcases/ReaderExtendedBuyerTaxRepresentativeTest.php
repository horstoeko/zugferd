<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentReader;

/**
 * Round-trip test for BuyerTaxRepresentativeParty (BG-X-54) in the EXTENDED profile.
 * Builds a document with buyer tax representative data, then reads it back and verifies all values.
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
            ->addDocumentTax("S", "VAT", 100.00, 19.00, 19.0);

        $xml = $builder->getContent();
        self::$document = ZugferdDocumentReader::readAndGuessFromContent($xml);
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
        self::assertTrue(self::$document->firstDocumentBuyerTaxRepresentativeContact());
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
        self::assertTrue(self::$document->nextDocumentBuyerTaxRepresentativeContact());
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
        self::assertFalse(self::$document->nextDocumentBuyerTaxRepresentativeContact());
    }
}
