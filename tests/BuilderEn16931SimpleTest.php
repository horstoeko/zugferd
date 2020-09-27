<?php

namespace horstoeko\zugferd\tests;

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;

use function PHPUnit\Framework\assertNull;

class BuilderEn16931SimpleTest extends TestCase
{
    /**
     * @var ZugferdDocumentBuilder
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);
    }

    public function testDocumentProfile()
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->profile);
    }

    public function testXmlGenerals()
    {
        $xml = $this->getXml();
        $namespaces = $xml->getNamespaces(true);

        $this->assertArrayHasKey("rsm", $namespaces);
        $this->assertArrayHasKey("ram", $namespaces);
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID', (self::$document)->profiledef["contextparameter"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInformation
     */
    public function testSetDocumentInformation()
    {
        (self::$document)->SetDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:ID', "471102");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:TypeCode', "380");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IssueDateTime/udt:DateTimeString', "20180305", "format", "102");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceCurrencyCode', "EUR");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentGeneralPaymentInformation
     */
    public function testSetDocumentGeneralPaymentInformation()
    {
        (self::$document)->SetDocumentGeneralPaymentInformation("1111111111", "2222222222");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:CreditorReferenceID', "1111111111");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PaymentReference', "2222222222");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetIsDocumentCopy
     */
    public function testSetIsDocumentCopy()
    {
        (self::$document)->SetIsDocumentCopy();

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:CopyIndicator');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetIsTestDocument
     */
    public function testSetIsTestDocument()
    {
        (self::$document)->SetIsTestDocument();

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:TestIndicator/udt:Indicator');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentNote
     */
    public function testAddDocumentNote()
    {
        (self::$document)->AddDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.');
        (self::$document)->AddDocumentNote('Lieferant GmbH', null, 'REG');

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IncludedNote/ram:Content', 0, "Rechnung gemäß Bestellung vom 01.03.2018.");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IncludedNote/ram:Content', 1, "Lieferant GmbH");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IncludedNote/ram:SubjectCode', 0, "REG");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSupplyChainEvent
     */
    public function testSetDocumentSupplyChainEvent()
    {
        (self::$document)->SetDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'));

        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ActualDeliverySupplyChainEvent/ram:OccurrenceDateTime/udt:DateTimeString', "20180305", "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSeller
     */
    public function testSetDocumentSeller()
    {
        (self::$document)->SetDocumentSeller("Lieferant GmbH", "549910");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:Name', "Lieferant GmbH");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentSellerGlobalId
     */
    public function testAddDocumentSellerGlobalId()
    {
        (self::$document)->AddDocumentSellerGlobalId("4000001123452", "0088");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentSellerTaxRegistration
     */
    public function testAddDocumentSellerTaxRegistration()
    {
        (self::$document)->AddDocumentSellerTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentSellerTaxRegistration("VA", "DE123456789");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSellerAddress
     */
    public function testSetDocumentSellerAddress()
    {
        (self::$document)->SetDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "80333");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:LineOne', "Lieferantenstraße 20");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:CityName', "München");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSellerLegalOrganisation
     */
    public function testSetDocumentSellerLegalOrganisation()
    {
        (self::$document)->SetDocumentSellerLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Lieferant AG");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSellerContact
     */
    public function testSetDocumentSellerContact()
    {
        (self::$document)->SetDocumentSellerContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:PersonName', "Hans Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@lieferant.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentBuyer
     */
    public function testSetDocumentBuyer()
    {
        (self::$document)->SetDocumentBuyer("Kunden AG Mitte", "549910");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:Name', "Kunden AG Mitte");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentBuyerGlobalId
     */
    public function testAddDocumentBuyerGlobalId()
    {
        (self::$document)->AddDocumentBuyerGlobalId("4000001123452", "0088");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentBuyerTaxRegistration
     */
    public function testAddDocumentBuyerTaxRegistration()
    {
        (self::$document)->AddDocumentBuyerTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentBuyerTaxRegistration("VA", "DE123456789");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentBuyerAddress
     */
    public function testSetDocumentBuyerAddress()
    {
        (self::$document)->SetDocumentBuyerAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "69876");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:LineOne', "Kundenstrasse 15");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:CityName', "Frankfurt");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentBuyerLegalOrganisation
     */
    public function testSetDocumentBuyerLegalOrganisation()
    {
        (self::$document)->SetDocumentBuyerLegalOrganisation("DE12345", "FC", "Kunden Holding");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Kunden Holding");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentBuyerContact
     */
    public function testSetDocumentBuyerContact()
    {
        (self::$document)->SetDocumentBuyerContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:PersonName', "Otto Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@kunde.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSellerTaxRepresentativeTradeParty
     */
    public function testSetDocumentSellerTaxRepresentativeTradeParty()
    {
        (self::$document)->SetDocumentSellerTaxRepresentativeTradeParty("Lieferant GmbH", "549910");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:Name', "Lieferant GmbH");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentSellerTaxRepresentativeGlobalId
     */
    public function testAddSellerTaxRepresentativeGlobalId()
    {
        (self::$document)->AddDocumentSellerTaxRepresentativeGlobalId("4000001123452", "0088");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentSellerTaxRepresentativeTaxRegistration
     */
    public function testAddDocumentSellerTaxRepresentativeTaxRegistration()
    {
        (self::$document)->AddDocumentSellerTaxRepresentativeTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentSellerTaxRepresentativeTaxRegistration("VA", "DE123456789");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSellerTaxRepresentativeAddress
     */
    public function testSetDocumentSellerTaxRepresentativeAddress()
    {
        (self::$document)->SetDocumentSellerTaxRepresentativeAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "80333");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:LineOne', "Lieferantenstraße 20");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:CityName', "München");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSellerTaxRepresentativeLegalOrganisation
     */
    public function testSetDocumentSellerTaxRepresentativeLegalOrganisation()
    {
        (self::$document)->SetDocumentSellerTaxRepresentativeLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Lieferant AG");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSellerTaxRepresentativeContact
     */
    public function testSetDocumentSellerTaxRepresentativeContact()
    {
        (self::$document)->SetDocumentSellerTaxRepresentativeContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:PersonName', "Hans Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@lieferant.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentProductEndUser
     */
    public function testSetDocumentProductEndUser()
    {
        (self::$document)->SetDocumentProductEndUser("Kunden AG Mitte", "549910");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentProductEndUserGlobalId
     */
    public function testAddDocumentProductEndUserGlobalId()
    {
        (self::$document)->AddDocumentProductEndUserGlobalId("4000001123452", "0088");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentProductEndUserTaxRegistration
     */
    public function testAddDocumentProductEndUserTaxRegistration()
    {
        (self::$document)->AddDocumentProductEndUserTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentProductEndUserTaxRegistration("VA", "DE123456789");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentProductEndUserAddress
     */
    public function testSetDocumentProductEndUserAddress()
    {
        (self::$document)->SetDocumentProductEndUserAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentProductEndUserLegalOrganisation
     */
    public function testSetDocumentProductEndUserLegalOrganisation()
    {
        (self::$document)->SetDocumentProductEndUserLegalOrganisation("DE12345", "FC", "Kunden Holding");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentProductEndUserContact
     */
    public function testSetDocumentProductEndUserContact()
    {
        (self::$document)->SetDocumentProductEndUserContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentShipTo
     */
    public function testSetDocumentShipTo()
    {
        (self::$document)->SetDocumentShipTo("Kunden AG Mitte", "549910");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:Name', "Kunden AG Mitte");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentShipToGlobalId
     */
    public function testAddDocumentShipToGlobalId()
    {
        (self::$document)->AddDocumentShipToGlobalId("4000001123452", "0088");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentShipToTaxRegistration
     */
    public function testAddDocumentShipToTaxRegistration()
    {
        (self::$document)->AddDocumentShipToTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentShipToTaxRegistration("VA", "DE123456789");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentShipToAddress
     */
    public function testSetDocumentShipToAddress()
    {
        (self::$document)->SetDocumentShipToAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "69876");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:LineOne', "Kundenstrasse 15");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CityName', "Frankfurt");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentShipToLegalOrganisation
     */
    public function testSetDocumentShipToLegalOrganisation()
    {
        (self::$document)->SetDocumentShipToLegalOrganisation("DE12345", "FC", "Kunden Holding");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Kunden Holding");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentShipToContact
     */
    public function testSetDocumentShipToContact()
    {
        (self::$document)->SetDocumentShipToContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:PersonName', "Otto Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@kunde.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentUltimateShipTo
     */
    public function testSetDocumentUltimateShipTo()
    {
        (self::$document)->SetDocumentUltimateShipTo("Kunden AG Mitte", "549910");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentUltimateShipToGlobalId
     */
    public function testAddDocumentUltimateShipToGlobalId()
    {
        (self::$document)->AddDocumentUltimateShipToGlobalId("4000001123452", "0088");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentUltimateShipToTaxRegistration
     */
    public function testAddDocumentUltimateShipToTaxRegistration()
    {
        (self::$document)->AddDocumentUltimateShipToTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentUltimateShipToTaxRegistration("VA", "DE123456789");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentUltimateShipToAddress
     */
    public function testSetDocumentUltimateShipToAddress()
    {
        (self::$document)->SetDocumentUltimateShipToAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentUltimateShipToLegalOrganisation
     */
    public function testSetDocumentUltimateShipToLegalOrganisation()
    {
        (self::$document)->SetDocumentUltimateShipToLegalOrganisation("DE12345", "FC", "Kunden Holding");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentUltimateShipToContact
     */
    public function testSetDocumentUltimateShipToContact()
    {
        (self::$document)->SetDocumentUltimateShipToContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentShipFrom
     */
    public function testSetDocumentShipFrom()
    {
        (self::$document)->SetDocumentShipFrom("Lieferant GmbH", "549910");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentShipFromGlobalId
     */
    public function testAddDocumentShipFromGlobalId()
    {
        (self::$document)->AddDocumentShipFromGlobalId("4000001123452", "0088");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentShipFromTaxRegistration
     */
    public function testAddDocumentShipFromTaxRegistration()
    {
        (self::$document)->AddDocumentShipFromTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentShipFromTaxRegistration("VA", "DE123456789");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentShipFromAddress
     */
    public function testSetDocumentShipFromAddress()
    {
        (self::$document)->SetDocumentShipFromAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentShipFromLegalOrganisation
     */
    public function testSetDocumentShipFromLegalOrganisation()
    {
        (self::$document)->SetDocumentShipFromLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentShipFromContact
     */
    public function testSetDocumentShipFromContact()
    {
        (self::$document)->SetDocumentShipFromContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoicer
     */
    public function testSetDocumentInvoicer()
    {
        (self::$document)->SetDocumentInvoicer("Lieferant GmbH", "549910");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentInvoicerGlobalId
     */
    public function testAddDocumentInvoicerGlobalId()
    {
        (self::$document)->AddDocumentInvoicerGlobalId("4000001123452", "0088");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentInvoicerTaxRegistration
     */
    public function testAddDocumentInvoicerTaxRegistration()
    {
        (self::$document)->AddDocumentInvoicerTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentInvoicerTaxRegistration("VA", "DE123456789");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoicerAddress
     */
    public function testSetDocumentInvoicerAddress()
    {
        (self::$document)->SetDocumentInvoicerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoicerLegalOrganisation
     */
    public function testSetDocumentInvoicerLegalOrganisation()
    {
        (self::$document)->SetDocumentInvoicerLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoicerContact
     */
    public function testSetDocumentInvoicerContact()
    {
        (self::$document)->SetDocumentInvoicerContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoicee
     */
    public function testSetDocumentInvoicee()
    {
        (self::$document)->SetDocumentInvoicee("Lieferant GmbH", "549910");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentInvoiceeGlobalId
     */
    public function testAddDocumentInvoiceeGlobalId()
    {
        (self::$document)->AddDocumentInvoiceeGlobalId("4000001123452", "0088");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentInvoiceeTaxRegistration
     */
    public function testAddDocumentInvoiceeTaxRegistration()
    {
        (self::$document)->AddDocumentInvoiceeTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentInvoiceeTaxRegistration("VA", "DE123456789");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoiceeAddress
     */
    public function testSetDocumentInvoiceeAddress()
    {
        (self::$document)->SetDocumentInvoiceeAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoiceeLegalOrganisation
     */
    public function testSetDocumentInvoiceeLegalOrganisation()
    {
        (self::$document)->SetDocumentInvoiceeLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoiceeContact
     */
    public function testSetDocumentInvoiceeContact()
    {
        (self::$document)->SetDocumentInvoiceeContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentPayee
     */
    public function testSetDocumentPayee()
    {
        (self::$document)->SetDocumentPayee("Lieferant GmbH", "549910");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:Name', "Lieferant GmbH");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentPayeeGlobalId
     */
    public function testAddDocumentPayeeGlobalId()
    {
        (self::$document)->AddDocumentPayeeGlobalId("4000001123452", "0088");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentPayeeTaxRegistration
     */
    public function testAddDocumentPayeeTaxRegistration()
    {
        (self::$document)->AddDocumentPayeeTaxRegistration("FC", "201/113/40209");
        (self::$document)->AddDocumentPayeeTaxRegistration("VA", "DE123456789");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentPayeeAddress
     */
    public function testSetDocumentPayeeAddress()
    {
        (self::$document)->SetDocumentPayeeAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "80333");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:LineOne', "Lieferantenstraße 20");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:CityName', "München");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentPayeeLegalOrganisation
     */
    public function testSetDocumentPayeeLegalOrganisation()
    {
        (self::$document)->SetDocumentPayeeLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Lieferant AG");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentPayeeContact
     */
    public function testSetDocumentPayeeContact()
    {
        (self::$document)->SetDocumentPayeeContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:PersonName', "Hans Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@lieferant.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentDeliveryTerms
     */
    public function testSetDocumentDeliveryTerms()
    {
        (self::$document)->SetDocumentDeliveryTerms("term");

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ApplicableTradeDeliveryTerms/ram:DeliveryTypeCode');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSellerOrderReferencedDocument
     */
    public function testSetDocumentSellerOrderReferencedDocument()
    {
        (self::$document)->SetDocumentSellerOrderReferencedDocument('B-1010', new \DateTime());

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerOrderReferencedDocument/ram:IssuerAssignedID', "B-1010");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerOrderReferencedDocument/ram:FormattedIssueDateTime/ram:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentBuyerOrderReferencedDocument
     */
    public function testSetDocumentBuyerOrderReferencedDocument()
    {
        (self::$document)->SetDocumentBuyerOrderReferencedDocument('O-2020', new \DateTime());

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerOrderReferencedDocument/ram:IssuerAssignedID', "O-2020");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerOrderReferencedDocument/ram:FormattedIssueDateTime/ram:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentContractReferencedDocument
     */
    public function testSetDocumentContractReferencedDocument()
    {
        (self::$document)->SetDocumentContractReferencedDocument("CON-4711", new \DateTime());

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ContractReferencedDocument/ram:IssuerAssignedID', "CON-4711");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ContractReferencedDocument/ram:FormattedIssueDateTime/ram:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentAdditionalReferencedDocument
     */
    public function testAddDocumentAdditionalReferencedDocument()
    {
        (self::$document)->AddDocumentAdditionalReferencedDocument("A-1011", "type", "http://lieferant.de/docs/a1011.pdf", "Leistungsnachweis", "reftype", new \DateTime());
        (self::$document)->AddDocumentAdditionalReferencedDocument("B-2233", "type2", "http://lieferant.de/docs/b2233.pdf", "Lieferliste", "reftype2", new \DateTime());

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:IssuerAssignedID', 0, "A-1011");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:IssuerAssignedID', 1, "B-2233");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:URIID', 0, "http://lieferant.de/docs/a1011.pdf");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:URIID', 1, "http://lieferant.de/docs/b2233.pdf");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:TypeCode', 0, "type");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:TypeCode', 1, "type2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:Name', 0, "Leistungsnachweis");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:Name', 1, "Lieferliste");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:ReferenceTypeCode', 0, "reftype");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:ReferenceTypeCode', 1, "reftype2");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 0, (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 1, (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentInvoiceReferencedDocument
     */
    public function testSetDocumentInvoiceReferencedDocument()
    {
        (self::$document)->SetDocumentInvoiceReferencedDocument("INV-1", new \DateTime());

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceReferencedDocument/ram:IssuerAssignedID', "INV-1");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentProcuringProject
     */
    public function testSetDocumentProcuringProject()
    {
        (self::$document)->SetDocumentProcuringProject("HB-8378732", "Hausbau");

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SpecifiedProcuringProject/ram:ID', "HB-8378732");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SpecifiedProcuringProject/ram:Name', "Hausbau");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentUltimateCustomerOrderReferencedDocument
     */
    public function testAddDocumentUltimateCustomerOrderReferencedDocument()
    {
        (self::$document)->AddDocumentUltimateCustomerOrderReferencedDocument("DOC-11", new \DateTime());
        (self::$document)->AddDocumentUltimateCustomerOrderReferencedDocument("DOC-22", new \DateTime());

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:UltimateCustomerOrderReferencedDocument/ram:IssuerAssignedID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:UltimateCustomerOrderReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentDespatchAdviceReferencedDocument
     */
    public function testSetDocumentDespatchAdviceReferencedDocument()
    {
        (self::$document)->SetDocumentDespatchAdviceReferencedDocument("DADV-001", new \DateTime());

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:IssuerAssignedID', "DADV-001");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentReceivingAdviceReferencedDocument
     */
    public function testSetDocumentReceivingAdviceReferencedDocument()
    {
        (self::$document)->SetDocumentReceivingAdviceReferencedDocument("RADV-002", new \DateTime());

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:IssuerAssignedID', "RADV-002");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentDeliveryNoteReferencedDocument
     */
    public function testSetDocumentDeliveryNoteReferencedDocument()
    {
        (self::$document)->SetDocumentDeliveryNoteReferencedDocument("DNOTE-003", new \DateTime());

        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:IssuerAssignedID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentPaymentMean
     */
    public function testAddDocumentPaymentMean()
    {
        (self::$document)->AddDocumentPaymentMean("42", "Paying information", "cardtype", "cardid", "cardholder", "DE00000000000", "DE11111111111", "Bank", "44444444", "NOLADEQLB21");
        (self::$document)->AddDocumentPaymentMean("49", "Paying information 2", "cardtype2", "cardid2", "cardholder2", "DE22222222222", "DE33333333333", "Bank 2", "22222222", "BIC");

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:TypeCode', 0, "42");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:Information', 0, "Paying information");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:ApplicableTradeSettlementFinancialCard/ram:ID', 0, "cardid", "schemeID", "cardtype");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:ApplicableTradeSettlementFinancialCard/ram:CardholderName', 0, "cardholder");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayerPartyDebtorFinancialAccount/ram:IBANID', 0, "DE00000000000");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayeePartyCreditorFinancialAccount/ram:IBANID', 0, "DE11111111111");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayeePartyCreditorFinancialAccount/ram:AccountName', 0, "Bank");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayeePartyCreditorFinancialAccount/ram:ProprietaryID', 0, "44444444");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayeeSpecifiedCreditorFinancialInstitution/ram:BICID', 0, "NOLADEQLB21");

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:TypeCode', 1, "49");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:Information', 1, "Paying information 2");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:ApplicableTradeSettlementFinancialCard/ram:ID', 1, "cardid2", "schemeID", "cardtype2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:ApplicableTradeSettlementFinancialCard/ram:CardholderName', 1, "cardholder2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayerPartyDebtorFinancialAccount/ram:IBANID', 1, "DE22222222222");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayeePartyCreditorFinancialAccount/ram:IBANID', 1, "DE33333333333");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayeePartyCreditorFinancialAccount/ram:AccountName', 1, "Bank 2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayeePartyCreditorFinancialAccount/ram:ProprietaryID', 1, "22222222");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementPaymentMeans/ram:PayeeSpecifiedCreditorFinancialInstitution/ram:BICID', 1, "BIC");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentTax
     */
    public function testAddDocumentTax()
    {
        (self::$document)->AddDocumentTax("S", "VAT", 100.0, 19.0, 19, "exreason", "exreasoncode", 100.0, 1.0, new \DateTime(), "duetypecode");
        (self::$document)->AddDocumentTax("S", "VAT", 200.0, 14.0, 7, "exreason2", "exreasoncode2", 200.0, 2.0, new \DateTime(), "duetypecode2");

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:CalculatedAmount', 0, "19.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:TypeCode', 0, "VAT");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReason', 0, "exreason");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:BasisAmount', 0, "100.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:CategoryCode', 0, "S");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReasonCode', 0, "exreasoncode");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:TaxPointDate/udt:DateString', 0, (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:DueDateTypeCode', 0, "duetypecode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:RateApplicablePercent', 0, "19.0");

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:CalculatedAmount', 1, "14.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:TypeCode', 1, "VAT");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReason', 1, "exreason2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:BasisAmount', 1, "200.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:CategoryCode', 1, "S");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReasonCode', 1, "exreasoncode2");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:TaxPointDate/udt:DateString', 1, (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:DueDateTypeCode', 1, "duetypecode2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:RateApplicablePercent', 1, "7.0");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentTaxSimple
     */
    public function testAddDocumentTaxSimple()
    {
        (self::$document)->AddDocumentTaxSimple("S", "VAT", 100.0, 19.0, 19.0);

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:CalculatedAmount', 2, "19.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:TypeCode', 2, "VAT");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReason', 2);
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:BasisAmount', 2, "100.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:CategoryCode', 2, "S");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReasonCode', 2);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:TaxPointDate/udt:DateString', 2);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:DueDateTypeCode', 2);
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:ApplicableTradeTax/ram:RateApplicablePercent', 2, "19.0");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentBillingPeriod
     */
    public function testSetDocumentBillingPeriod()
    {
        (self::$document)->SetDocumentBillingPeriod(new \DateTime(), new \DateTime(), "Project");

        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:BillingSpecifiedPeriod/ram:StartDateTime/udt:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:BillingSpecifiedPeriod/ram:EndDateTime/udt:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentAllowanceCharge
     */
    public function testAddDocumentAllowanceCharge()
    {
        (self::$document)->AddDocumentAllowanceCharge(10.0, false, "S", "VAT", 19.0, 1, 10.0, 100.0, 1, "C62", "reasoncode", "reason");
        (self::$document)->AddDocumentAllowanceCharge(10.0, false, "S", "VAT", 19.0, 1, 10.0, 100.0, 1, "C62", "reasoncode", "reason");

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CalculationPercent', 0, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:BasisAmount', 0, "100.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ActualAmount', 0, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ReasonCode', 0, "reasoncode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:Reason', 0, "reason");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CategoryTradeTax/ram:TypeCode', 0, "VAT");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CategoryTradeTax/ram:CategoryCode', 0, "S");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CategoryTradeTax/ram:RateApplicablePercent', 0, "19.0");

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CalculationPercent', 1, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:BasisAmount', 1, "100.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ActualAmount', 1, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ReasonCode', 1, "reasoncode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:Reason', 1, "reason");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CategoryTradeTax/ram:TypeCode', 1, "VAT");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CategoryTradeTax/ram:CategoryCode', 1, "S");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CategoryTradeTax/ram:RateApplicablePercent', 1, "19.0");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentLogisticsServiceCharge
     */
    public function testAddDocumentLogisticsServiceCharge()
    {
        (self::$document)->AddDocumentLogisticsServiceCharge("Service", 10.0, ["S"], ["VAT"], [19.0]);

        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:Description', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:AppliedAmount', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:AppliedTradeTax/ram:TypeCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:AppliedTradeTax/ram:CategoryCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:AppliedTradeTax/ram:RateApplicablePercent', 0);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentPaymentTerm
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDiscountTermsToPaymentTerms
     */
    public function testAddDocumentPaymentTermAndDiscount()
    {
        (self::$document)->AddDocumentPaymentTerm("Payment", new \DateTime(), "mandate");
        (self::$document)->AddDiscountTermsToPaymentTerms(10.0, new \DateTime(), 1, "DAY", 20.0, 2.0);

        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:Description', 0, "Payment");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:DueDateDateTime/udt:DateTimeString', 0, (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:DirectDebitMandateID', 0, "mandate");
    
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ApplicableTradePaymentDiscountTerms/ram:BasisDateTime/udt:DateTimeString', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ApplicableTradePaymentDiscountTerms/ram:BasisPeriodMeasure', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ApplicableTradePaymentDiscountTerms/ram:BasisAmount', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ApplicableTradePaymentDiscountTerms/ram:CalculationPercent', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ApplicableTradePaymentDiscountTerms/ram:ActualDiscountAmount', 0);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::AddDocumentReceivableSpecifiedTradeAccountingAccount
     */
    public function testAddDocumentReceivableSpecifiedTradeAccountingAccount()
    {
        (self::$document)->AddDocumentReceivableSpecifiedTradeAccountingAccount("accountid", "typecode");
        (self::$document)->AddDocumentReceivableSpecifiedTradeAccountingAccount("accountid2", "typecode2");

        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ReceivableSpecifiedTradeAccountingAccount/ram:ID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ReceivableSpecifiedTradeAccountingAccount/ram:TypeCode', 0);

        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ReceivableSpecifiedTradeAccountingAccount/ram:ID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ReceivableSpecifiedTradeAccountingAccount/ram:TypeCode', 1);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::WriteFile
     */
    public function testWriteFile()
    {
        (self::$document)->WriteFile(getcwd() . "/myfile.xml");
        $this->assertTrue(file_exists(getcwd() . "/myfile.xml"));
        //@unlink(getcwd() . "/myfile.xml");
    }

    /**
     * Get XML-Object from documents content
     *
     * @return \SimpleXMLElement
     */
    private function getXml(): \SimpleXMLElement
    {
        return new \SimpleXMLElement((self::$document)->GetContent());
    }

    /**
     * Assert a xpath with $expected value
     *
     * @param string $xpath
     * @param string $expected
     * @return void
     */
    private function assertXPathValue(string $xpath, string $expected): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey(0, $xmlvalue);
        $this->assertEquals($expected, $xmlvalue[0]);
    }

    /**
     * Assert a xpath with $expected value in a multiple element resultset
     *
     * @param string $xpath
     * @param integer $index
     * @param string $expected
     * @return void
     */
    private function assertXPathValueWithIndex(string $xpath, int $index, string $expected): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey($index, $xmlvalue);
        $this->assertEquals($expected, $xmlvalue[$index]);
    }

    /**
     * Assert a xpath with $expected value and an expected attribute value
     *
     * @param string $xpath
     * @param string $expected
     * @param string $expectedAttribute
     * @param string $expectedAttributeValue
     * @return void
     */
    private function assertXPathValueWithAttribute(string $xpath, string $expected, string $expectedAttribute, string $expectedAttributeValue): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey(0, $xmlvalue);
        $this->assertEquals($expected, $xmlvalue[0]);
        $this->assertNotNull($xmlvalue[0]->attributes()[$expectedAttribute]);
        $this->assertNotNull($xmlvalue[0]->attributes()[$expectedAttribute][0]);
        $this->assertEquals($expectedAttributeValue, $xmlvalue[0]->attributes()[$expectedAttribute][0]);
    }

    /**
     * Assert a xpath with $expected value in a multiple resule and an expected attribute value
     *
     * @param string $xpath
     * @param string $expected
     * @param string $expectedAttribute
     * @param string $expectedAttributeValue
     * @return void
     */
    private function assertXPathValueWithIndexAndAttribute(string $xpath, int $index, string $expected, string $expectedAttribute, string $expectedAttributeValue): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey($index, $xmlvalue);
        $this->assertEquals($expected, $xmlvalue[$index]);
        $this->assertNotNull($xmlvalue[$index]->attributes()[$expectedAttribute]);
        $this->assertNotNull($xmlvalue[$index]->attributes()[$expectedAttribute][0]);
        $this->assertEquals($expectedAttributeValue, $xmlvalue[$index]->attributes()[$expectedAttribute][0]);
    }

    /**
     * Test that an xml element does not exist
     *
     * @param string $xpath
     * @return void
     */
    public function assertXPathNotExists(string $xpath)
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertEmpty($xmlvalue);
    }

    /**
     * Test that an xml element does not exist at index
     *
     * @param string $xpath
     * @param integer $index
     * @return void
     */
    public function assertXPathNotExistsWithIndex(string $xpath, int $index)
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayNotHasKey($index, $xmlvalue);
    }
}
