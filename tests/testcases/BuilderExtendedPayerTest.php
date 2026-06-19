<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\tests\traits\HandlesXmlTests;

/**
 * Tests for the payer trade party (BG-X-73) including the payer contact (BG-X-74)
 * which are attached to /ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty.
 *
 * Mirrors the structure of the seller/payee tests in BuilderExtendedTest.php.
 */
class BuilderExtendedPayerTest extends TestCase
{
    use HandlesXmlTests;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EXTENDED);
    }

    public function testDocumentProfile(): void
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
    }

    public function testSetDocumentPayer(): void
    {
        (self::$document)->setDocumentPayer("Zahler GmbH", "ZP-001");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:ID', "ZP-001");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:Name', "Zahler GmbH");
    }

    public function testAddDocumentPayerId(): void
    {
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:ID', 0, "ZP-001");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:ID', 1);

        (self::$document)->addDocumentPayerId("ZP-002");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:ID', 0, "ZP-001");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:ID', 1, "ZP-002");
    }

    public function testAddDocumentPayerGlobalId(): void
    {
        (self::$document)->addDocumentPayerGlobalId("4000001999999", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:GlobalID', 0, "4000001999999", "schemeID", "0088");
    }

    public function testSetDocumentPayerLegalOrganisation(): void
    {
        (self::$document)->setDocumentPayerLegalOrganisation("DE99999", "FC", "Zahler AG");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE99999", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Zahler AG");
    }

    public function testSetDocumentPayerAddress(): void
    {
        (self::$document)->setDocumentPayerAddress("Zahlerstraße 10", "Haus C", "Aufgang D", "10115", "Berlin", "DE", "DE-BE");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "10115");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:PostalTradeAddress/ram:LineOne', "Zahlerstraße 10");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:PostalTradeAddress/ram:LineTwo', "Haus C");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:PostalTradeAddress/ram:LineThree', "Aufgang D");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:PostalTradeAddress/ram:CityName', "Berlin");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName', "DE-BE");
    }

    public function testSetDocumentPayerContact(): void
    {
        (self::$document)->setDocumentPayerContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@zahler.de", "LB");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 0, "Hans Müller");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:DepartmentName', 0, "Financials");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:TypeCode', 0, "LB");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', 0, "+49-111-2222222");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber', 0, "+49-111-3333333");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', 0, "info@zahler.de");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:DepartmentName', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:TypeCode', 1);

        // Calling set...Contact again replaces the whole DefinedTradeContact collection
        (self::$document)->setDocumentPayerContact("Hans Meier", "Bank", "+49-111-4444444", "+49-111-5555555", "info@meinpayer.de", "CP");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 0, "Hans Meier");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:DepartmentName', 0, "Bank");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:TypeCode', 0, "CP");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 1);

        // Reset to a known single contact for the following add-test
        (self::$document)->setDocumentPayerContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@zahler.de", "LB");
    }

    public function testAddDocumentPayerContact(): void
    {
        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 0, "Hans Müller");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 1);

        (self::$document)->addDocumentPayerContact("Hans Meier", "Bank", "+49-111-4444444", "+49-111-5555555", "info@meinpayer.de", "CP");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 0, "Hans Müller");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:TypeCode', 0, "LB");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 1, "Hans Meier");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:DepartmentName', 1, "Bank");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:TypeCode', 1, "CP");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', 1, "+49-111-4444444");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber', 1, "+49-111-5555555");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', 1, "info@meinpayer.de");

        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayerTradeParty/ram:DefinedTradeContact/ram:PersonName', 2);
    }
}
