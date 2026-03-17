<?php

namespace horstoeko\zugferd\tests\testcases;

use DateTime;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

/**
 * Round-trip tests for position-level delivery getter methods in ZugferdDocumentReader.
 * These tests build an Extended invoice with position-level ShipTo, UltimateShipTo,
 * UltimateCustomerOrderReferencedDocument, and delivery event data, then read it back
 * to verify all getter methods return the correct values.
 */
class ReaderExtendedPositionDeliveryTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        $builder = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EXTENDED);

        $builder
            ->setDocumentInformation("INV-2025-001", "380", new DateTime("2025-01-15"), "EUR")
            ->setDocumentSeller("Seller Corp")
            ->addDocumentSellerTaxRegistration("VA", "DE123456789")
            ->setDocumentSellerAddress("Seller Street 1", null, null, "12345", "Berlin", "DE")
            ->setDocumentBuyer("Buyer Inc")
            ->setDocumentBuyerAddress("Buyer Lane 2", null, null, "54321", "Munich", "DE")
            ->addDocumentTax("S", "VAT", 100.00, 19.00, 19.00)
            ->setDocumentSummation(119.00, 119.00, 100.00, 0.00, 0.00, 100.00, 19.00);

        // Document-level UltimateCustomerOrderReferencedDocument
        $builder->addDocumentUltimateCustomerOrderReferencedDocument("UCORD-001", new DateTime("2024-12-01"));
        $builder->addDocumentUltimateCustomerOrderReferencedDocument("UCORD-002", new DateTime("2024-12-15"));

        // Position 1: with full ShipTo, UltimateShipTo, and delivery data
        $builder
            ->addNewPosition("1")
            ->setDocumentPositionProductDetails("Product A", "Description A")
            ->setDocumentPositionNetPrice(50.00)
            ->setDocumentPositionQuantity(1.00, "C62")
            ->addDocumentPositionTax("S", "VAT", 19.00)
            ->setDocumentPositionLineSummation(50.00);

        // Position-level ShipTo
        $builder
            ->setDocumentPositionShipTo("ShipTo Pos1", "SHIP-ID-1")
            ->addDocumentPositionShipToGlobalId("4000001234567", "0088")
            ->addDocumentPositionShipToTaxRegistration("VA", "DE111222333")
            ->setDocumentPositionShipToAddress("Ship Street 10", "Floor 3", "Building B", "55555", "Hamburg", "DE", "HH")
            ->setDocumentPositionShipToLegalOrganisation("SHIP-LEG-1", "0088", "ShipTo Legal Name")
            ->setDocumentPositionShipToContact("John Shipping", "Logistics Dept", "+49-111-1234", "+49-111-5678", "john@shipping.de")
            ->addDocumentPositionShipToContact("Jane Shipping", "Dispatch Dept", "+49-111-9876", "+49-111-5432", "jane@shipping.de");

        // Position-level UltimateShipTo
        $builder
            ->setDocumentPositionUltimateShipTo("UltShipTo Pos1", "ULTSHIP-ID-1")
            ->addDocumentPositionUltimateShipToGlobalId("4000009876543", "0088")
            ->addDocumentPositionUltimateShipToTaxRegistration("VA", "DE444555666")
            ->setDocumentPositionUltimateShipToAddress("Ultimate Street 20", "Suite 5", null, "66666", "Frankfurt", "DE", "HE")
            ->setDocumentPositionUltimateShipToLegalOrganisation("ULTSHIP-LEG-1", "0060", "UltShipTo Legal Name")
            ->setDocumentPositionUltimateShipToContact("Max Ultimate", "Final Delivery", "+49-222-1111", "+49-222-2222", "max@ultimate.de");

        // Position-level delivery events and references
        $builder
            ->setDocumentPositionSupplyChainEvent(new DateTime("2025-01-20"))
            ->setDocumentPositionDespatchAdviceReferencedDocument("DESP-POS1", "10", new DateTime("2025-01-18"))
            ->setDocumentPositionReceivingAdviceReferencedDocument("RECV-POS1", "20", new DateTime("2025-01-19"))
            ->setDocumentPositionDeliveryNoteReferencedDocument("DELNOTE-POS1", "30", new DateTime("2025-01-20"));

        // Position-level UltimateCustomerOrderReferencedDocument
        $builder
            ->addDocumentPositionUltimateCustomerOrderReferencedDocument("UCORD-POS1-A", "10", new DateTime("2024-11-01"))
            ->addDocumentPositionUltimateCustomerOrderReferencedDocument("UCORD-POS1-B", "20", new DateTime("2024-11-15"));

        // Position 2: minimal - no ShipTo data
        $builder
            ->addNewPosition("2")
            ->setDocumentPositionProductDetails("Product B")
            ->setDocumentPositionNetPrice(50.00)
            ->setDocumentPositionQuantity(1.00, "C62")
            ->addDocumentPositionTax("S", "VAT", 19.00)
            ->setDocumentPositionLineSummation(50.00);

        $xml = $builder->getContent();
        self::$document = ZugferdDocumentReader::readAndGuessFromContent($xml);
    }

    // =========================================================================
    // Document-level UltimateCustomerOrderReferencedDocument tests
    // =========================================================================

    public function testDocumentUltimateCustomerOrderReferencedDocumentsPlural(): void
    {
        self::$document->getDocumentUltimateCustomerOrderReferencedDocuments($refDocs);
        $this->assertIsArray($refDocs);
        $this->assertCount(2, $refDocs);
        $this->assertEquals("UCORD-001", $refDocs[0]["IssuerAssignedID"]);
        $this->assertEquals("UCORD-002", $refDocs[1]["IssuerAssignedID"]);
    }

    public function testDocumentUltimateCustomerOrderReferencedDocumentIteration(): void
    {
        self::assertTrue(self::$document->firstDocumentUltimateCustomerOrderReferencedDocument());

        self::$document->getDocumentUltimateCustomerOrderReferencedDocument($issuerAssignedId, $issueDate);
        $this->assertEquals("UCORD-001", $issuerAssignedId);
        $this->assertInstanceOf(DateTime::class, $issueDate);
        $this->assertEquals("20241201", $issueDate->format("Ymd"));

        self::assertTrue(self::$document->nextDocumentUltimateCustomerOrderReferencedDocument());

        self::$document->getDocumentUltimateCustomerOrderReferencedDocument($issuerAssignedId, $issueDate);
        $this->assertEquals("UCORD-002", $issuerAssignedId);
        $this->assertInstanceOf(DateTime::class, $issueDate);
        $this->assertEquals("20241215", $issueDate->format("Ymd"));

        self::assertFalse(self::$document->nextDocumentUltimateCustomerOrderReferencedDocument());
    }

    // =========================================================================
    // Position 1 tests
    // =========================================================================

    public function testPosition1ShipTo(): void
    {
        self::assertTrue(self::$document->firstDocumentPosition());

        self::$document->getDocumentPositionShipTo($name, $id, $description);
        $this->assertEquals("ShipTo Pos1", $name);
        $this->assertIsArray($id);
    }

    public function testPosition1ShipToGlobalId(): void
    {
        self::$document->getDocumentPositionShipToGlobalId($globalID);
        $this->assertIsArray($globalID);
        $this->assertArrayHasKey("0088", $globalID);
        $this->assertEquals("4000001234567", $globalID["0088"]);
    }

    public function testPosition1ShipToTaxRegistration(): void
    {
        self::$document->getDocumentPositionShipToTaxRegistration($taxReg);
        $this->assertIsArray($taxReg);
        $this->assertArrayHasKey("VA", $taxReg);
        $this->assertEquals("DE111222333", $taxReg["VA"]);
    }

    public function testPosition1ShipToAddress(): void
    {
        self::$document->getDocumentPositionShipToAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);
        $this->assertEquals("Ship Street 10", $lineOne);
        $this->assertEquals("Floor 3", $lineTwo);
        $this->assertEquals("Building B", $lineThree);
        $this->assertEquals("55555", $postCode);
        $this->assertEquals("Hamburg", $city);
        $this->assertEquals("DE", $country);
        $this->assertIsArray($subDivision);
        $this->assertContains("HH", $subDivision);
    }

    public function testPosition1ShipToLegalOrganisation(): void
    {
        self::$document->getDocumentPositionShipToLegalOrganisation($legalOrgId, $legalOrgType, $legalOrgName);
        $this->assertEquals("SHIP-LEG-1", $legalOrgId);
        $this->assertEquals("0088", $legalOrgType);
        $this->assertEquals("ShipTo Legal Name", $legalOrgName);
    }

    public function testPosition1ShipToContactIteration(): void
    {
        self::assertTrue(self::$document->firstDocumentPositionShipToContact());

        self::$document->getDocumentPositionShipToContact($personName, $departmentName, $phoneNo, $faxNo, $emailAddress);
        $this->assertEquals("John Shipping", $personName);
        $this->assertEquals("Logistics Dept", $departmentName);
        $this->assertEquals("+49-111-1234", $phoneNo);
        $this->assertEquals("+49-111-5678", $faxNo);
        $this->assertEquals("john@shipping.de", $emailAddress);

        self::assertTrue(self::$document->nextDocumentPositionShipToContact());

        self::$document->getDocumentPositionShipToContact($personName, $departmentName, $phoneNo, $faxNo, $emailAddress);
        $this->assertEquals("Jane Shipping", $personName);
        $this->assertEquals("Dispatch Dept", $departmentName);
        $this->assertEquals("+49-111-9876", $phoneNo);
        $this->assertEquals("+49-111-5432", $faxNo);
        $this->assertEquals("jane@shipping.de", $emailAddress);

        self::assertFalse(self::$document->nextDocumentPositionShipToContact());
    }

    public function testPosition1UltimateShipTo(): void
    {
        self::$document->getDocumentPositionUltimateShipTo($name, $id, $description);
        $this->assertEquals("UltShipTo Pos1", $name);
        $this->assertIsArray($id);
    }

    public function testPosition1UltimateShipToGlobalId(): void
    {
        self::$document->getDocumentPositionUltimateShipToGlobalId($globalID);
        $this->assertIsArray($globalID);
        $this->assertArrayHasKey("0088", $globalID);
        $this->assertEquals("4000009876543", $globalID["0088"]);
    }

    public function testPosition1UltimateShipToTaxRegistration(): void
    {
        self::$document->getDocumentPositionUltimateShipToTaxRegistration($taxReg);
        $this->assertIsArray($taxReg);
        $this->assertArrayHasKey("VA", $taxReg);
        $this->assertEquals("DE444555666", $taxReg["VA"]);
    }

    public function testPosition1UltimateShipToAddress(): void
    {
        self::$document->getDocumentPositionUltimateShipToAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);
        $this->assertEquals("Ultimate Street 20", $lineOne);
        $this->assertEquals("Suite 5", $lineTwo);
        $this->assertEquals("", $lineThree);
        $this->assertEquals("66666", $postCode);
        $this->assertEquals("Frankfurt", $city);
        $this->assertEquals("DE", $country);
        $this->assertIsArray($subDivision);
        $this->assertContains("HE", $subDivision);
    }

    public function testPosition1UltimateShipToLegalOrganisation(): void
    {
        self::$document->getDocumentPositionUltimateShipToLegalOrganisation($legalOrgId, $legalOrgType, $legalOrgName);
        $this->assertEquals("ULTSHIP-LEG-1", $legalOrgId);
        $this->assertEquals("0060", $legalOrgType);
        $this->assertEquals("UltShipTo Legal Name", $legalOrgName);
    }

    public function testPosition1UltimateShipToContact(): void
    {
        self::assertTrue(self::$document->firstDocumentPositionUltimateShipToContact());

        self::$document->getDocumentPositionUltimateShipToContact($personName, $departmentName, $phoneNo, $faxNo, $emailAddress);
        $this->assertEquals("Max Ultimate", $personName);
        $this->assertEquals("Final Delivery", $departmentName);
        $this->assertEquals("+49-222-1111", $phoneNo);
        $this->assertEquals("+49-222-2222", $faxNo);
        $this->assertEquals("max@ultimate.de", $emailAddress);

        self::assertFalse(self::$document->nextDocumentPositionUltimateShipToContact());
    }

    public function testPosition1SupplyChainEvent(): void
    {
        self::$document->getDocumentPositionSupplyChainEvent($date);
        $this->assertInstanceOf(DateTime::class, $date);
        $this->assertEquals("20250120", $date->format("Ymd"));
    }

    public function testPosition1DespatchAdviceReferencedDocument(): void
    {
        self::$document->getDocumentPositionDespatchAdviceReferencedDocument($issuerAssignedId, $lineId, $issueDate);
        $this->assertEquals("DESP-POS1", $issuerAssignedId);
        $this->assertEquals("10", $lineId);
        $this->assertInstanceOf(DateTime::class, $issueDate);
        $this->assertEquals("20250118", $issueDate->format("Ymd"));
    }

    public function testPosition1ReceivingAdviceReferencedDocument(): void
    {
        self::$document->getDocumentPositionReceivingAdviceReferencedDocument($issuerAssignedId, $lineId, $issueDate);
        $this->assertEquals("RECV-POS1", $issuerAssignedId);
        $this->assertEquals("20", $lineId);
        $this->assertInstanceOf(DateTime::class, $issueDate);
        $this->assertEquals("20250119", $issueDate->format("Ymd"));
    }

    public function testPosition1DeliveryNoteReferencedDocument(): void
    {
        self::$document->getDocumentPositionDeliveryNoteReferencedDocument($issuerAssignedId, $lineId, $issueDate);
        $this->assertEquals("DELNOTE-POS1", $issuerAssignedId);
        $this->assertEquals("30", $lineId);
        $this->assertInstanceOf(DateTime::class, $issueDate);
        $this->assertEquals("20250120", $issueDate->format("Ymd"));
    }

    public function testPosition1UltimateCustomerOrderReferencedDocumentIteration(): void
    {
        self::assertTrue(self::$document->firstDocumentPositionUltimateCustomerOrderReferencedDocument());

        self::$document->getDocumentPositionUltimateCustomerOrderReferencedDocument($issuerAssignedId, $lineId, $issueDate);
        $this->assertEquals("UCORD-POS1-A", $issuerAssignedId);
        $this->assertEquals("10", $lineId);
        $this->assertInstanceOf(DateTime::class, $issueDate);
        $this->assertEquals("20241101", $issueDate->format("Ymd"));

        self::assertTrue(self::$document->nextDocumentPositionUltimateCustomerOrderReferencedDocument());

        self::$document->getDocumentPositionUltimateCustomerOrderReferencedDocument($issuerAssignedId, $lineId, $issueDate);
        $this->assertEquals("UCORD-POS1-B", $issuerAssignedId);
        $this->assertEquals("20", $lineId);
        $this->assertInstanceOf(DateTime::class, $issueDate);
        $this->assertEquals("20241115", $issueDate->format("Ymd"));

        self::assertFalse(self::$document->nextDocumentPositionUltimateCustomerOrderReferencedDocument());
    }

    // =========================================================================
    // Position 2 tests - verify empty/missing data returns defaults
    // =========================================================================

    public function testPosition2HasNoShipTo(): void
    {
        self::assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionShipTo($name, $id, $description);
        $this->assertEquals("", $name);
        $this->assertEquals("", $description);
    }

    public function testPosition2HasNoShipToGlobalId(): void
    {
        self::$document->getDocumentPositionShipToGlobalId($globalID);
        $this->assertIsArray($globalID);
        $this->assertEmpty($globalID);
    }

    public function testPosition2HasNoShipToAddress(): void
    {
        self::$document->getDocumentPositionShipToAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);
        $this->assertEquals("", $lineOne);
        $this->assertEquals("", $city);
        $this->assertEquals("", $country);
    }

    public function testPosition2HasNoShipToContact(): void
    {
        self::assertFalse(self::$document->firstDocumentPositionShipToContact());
    }

    public function testPosition2HasNoUltimateShipTo(): void
    {
        self::$document->getDocumentPositionUltimateShipTo($name, $id, $description);
        $this->assertEquals("", $name);
        $this->assertEquals("", $description);
    }

    public function testPosition2HasNoUltimateShipToContact(): void
    {
        self::assertFalse(self::$document->firstDocumentPositionUltimateShipToContact());
    }

    public function testPosition2HasNoUltimateCustomerOrderReferencedDocument(): void
    {
        self::assertFalse(self::$document->firstDocumentPositionUltimateCustomerOrderReferencedDocument());
    }

    public function testPosition2NoMorePositions(): void
    {
        self::assertFalse(self::$document->nextDocumentPosition());
    }
}
