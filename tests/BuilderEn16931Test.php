<?php

namespace horstoeko\zugferd\tests;

use \horstoeko\zugferd\tests\BuilderBaseTest;
use \horstoeko\zugferd\ZugferdProfiles;
use \horstoeko\zugferd\ZugferdDocumentBuilder;

class BuilderEn16931Test extends BuilderBaseTest
{
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

        $this->disableRenderXmlContent();
        $this->assertArrayHasKey("rsm", $namespaces);
        $this->assertArrayHasKey("ram", $namespaces);
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID', (self::$document)->profiledef["contextparameter"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInformation
     */
    public function testSetDocumentInformation()
    {
        (self::$document)->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:ID', "471102");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:TypeCode', "380");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IssueDateTime/udt:DateTimeString', "20180305", "format", "102");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceCurrencyCode', "EUR");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentGeneralPaymentInformation
     */
    public function testSetDocumentGeneralPaymentInformation()
    {
        (self::$document)->setDocumentGeneralPaymentInformation("1111111111", "2222222222");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:CreditorReferenceID', "1111111111");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PaymentReference', "2222222222");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setIsDocumentCopy
     */
    public function testSetIsDocumentCopy()
    {
        (self::$document)->setIsDocumentCopy();

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:CopyIndicator');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setIsTestDocument
     */
    public function testSetIsTestDocument()
    {
        (self::$document)->SetIsTestDocument();

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:TestIndicator/udt:Indicator');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentNote
     */
    public function testAddDocumentNote()
    {
        (self::$document)->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.');
        (self::$document)->addDocumentNote('Lieferant GmbH', null, 'REG');

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IncludedNote/ram:Content', 0, "Rechnung gemäß Bestellung vom 01.03.2018.");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IncludedNote/ram:Content', 1, "Lieferant GmbH");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IncludedNote/ram:SubjectCode', 0, "REG");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSupplyChainEvent
     */
    public function testSetDocumentSupplyChainEvent()
    {
        (self::$document)->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'));

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ActualDeliverySupplyChainEvent/ram:OccurrenceDateTime/udt:DateTimeString', "20180305", "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentBuyerReference
     */
    public function testSetDocumentBuyerReference()
    {
        (self::$document)->setDocumentBuyerReference("buyerref");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerReference', "buyerref");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSeller
     */
    public function testSetDocumentSeller()
    {
        (self::$document)->setDocumentSeller("Lieferant GmbH", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:Name', "Lieferant GmbH");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentSellerGlobalId
     */
    public function testAddDocumentSellerGlobalId()
    {
        (self::$document)->addDocumentSellerGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentSellerTaxRegistration
     */
    public function testAddDocumentSellerTaxRegistration()
    {
        (self::$document)->addDocumentSellerTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentSellerTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSellerAddress
     */
    public function testSetDocumentSellerAddress()
    {
        (self::$document)->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "80333");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:LineOne', "Lieferantenstraße 20");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:CityName', "München");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSellerLegalOrganisation
     */
    public function testSetDocumentSellerLegalOrganisation()
    {
        (self::$document)->setDocumentSellerLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Lieferant AG");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSellerContact
     */
    public function testSetDocumentSellerContact()
    {
        (self::$document)->setDocumentSellerContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:PersonName', "Hans Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@lieferant.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentBuyer
     */
    public function testSetDocumentBuyer()
    {
        (self::$document)->setDocumentBuyer("Kunden AG Mitte", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:Name', "Kunden AG Mitte");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentBuyerGlobalId
     */
    public function testAddDocumentBuyerGlobalId()
    {
        (self::$document)->addDocumentBuyerGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentBuyerTaxRegistration
     */
    public function testAddDocumentBuyerTaxRegistration()
    {
        (self::$document)->addDocumentBuyerTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentBuyerTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentBuyerAddress
     */
    public function testSetDocumentBuyerAddress()
    {
        (self::$document)->setDocumentBuyerAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "69876");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:LineOne', "Kundenstrasse 15");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:CityName', "Frankfurt");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentBuyerLegalOrganisation
     */
    public function testSetDocumentBuyerLegalOrganisation()
    {
        (self::$document)->setDocumentBuyerLegalOrganisation("DE12345", "FC", "Kunden Holding");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Kunden Holding");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentBuyerContact
     */
    public function testSetDocumentBuyerContact()
    {
        (self::$document)->setDocumentBuyerContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:PersonName', "Otto Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@kunde.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSellerTaxRepresentativeTradeParty
     */
    public function testSetDocumentSellerTaxRepresentativeTradeParty()
    {
        (self::$document)->setDocumentSellerTaxRepresentativeTradeParty("Lieferant GmbH", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:Name', "Lieferant GmbH");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentSellerTaxRepresentativeGlobalId
     */
    public function testAddDocumentSellerTaxRepresentativeGlobalId()
    {
        (self::$document)->addDocumentSellerTaxRepresentativeGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentSellerTaxRepresentativeTaxRegistration
     */
    public function testAddDocumentSellerTaxRepresentativeTaxRegistration()
    {
        (self::$document)->addDocumentSellerTaxRepresentativeTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentSellerTaxRepresentativeTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSellerTaxRepresentativeAddress
     */
    public function testSetDocumentSellerTaxRepresentativeAddress()
    {
        (self::$document)->setDocumentSellerTaxRepresentativeAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "80333");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:LineOne', "Lieferantenstraße 20");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:CityName', "München");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSellerTaxRepresentativeLegalOrganisation
     */
    public function testSetDocumentSellerTaxRepresentativeLegalOrganisation()
    {
        (self::$document)->setDocumentSellerTaxRepresentativeLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Lieferant AG");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSellerTaxRepresentativeContact
     */
    public function testSetDocumentSellerTaxRepresentativeContact()
    {
        (self::$document)->setDocumentSellerTaxRepresentativeContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:PersonName', "Hans Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTaxRepresentativeTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@lieferant.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentProductEndUser
     */
    public function testSetDocumentProductEndUser()
    {
        (self::$document)->setDocumentProductEndUser("Kunden AG Mitte", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentProductEndUserGlobalId
     */
    public function testAddDocumentProductEndUserGlobalId()
    {
        (self::$document)->addDocumentProductEndUserGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentProductEndUserTaxRegistration
     */
    public function testAddDocumentProductEndUserTaxRegistration()
    {
        (self::$document)->addDocumentProductEndUserTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentProductEndUserTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentProductEndUserAddress
     */
    public function testSetDocumentProductEndUserAddress()
    {
        (self::$document)->setDocumentProductEndUserAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentProductEndUserLegalOrganisation
     */
    public function testSetDocumentProductEndUserLegalOrganisation()
    {
        (self::$document)->setDocumentProductEndUserLegalOrganisation("DE12345", "FC", "Kunden Holding");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentProductEndUserContact
     */
    public function testSetDocumentProductEndUserContact()
    {
        (self::$document)->setDocumentProductEndUserContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ProductEndUserTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentShipTo
     */
    public function testSetDocumentShipTo()
    {
        (self::$document)->setDocumentShipTo("Kunden AG Mitte", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:Name', "Kunden AG Mitte");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentShipToGlobalId
     */
    public function testAddDocumentShipToGlobalId()
    {
        (self::$document)->addDocumentShipToGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentShipToTaxRegistration
     */
    public function testAddDocumentShipToTaxRegistration()
    {
        (self::$document)->addDocumentShipToTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentShipToTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentShipToAddress
     */
    public function testSetDocumentShipToAddress()
    {
        (self::$document)->setDocumentShipToAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "69876");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:LineOne', "Kundenstrasse 15");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CityName', "Frankfurt");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentShipToLegalOrganisation
     */
    public function testSetDocumentShipToLegalOrganisation()
    {
        (self::$document)->setDocumentShipToLegalOrganisation("DE12345", "FC", "Kunden Holding");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Kunden Holding");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentShipToContact
     */
    public function testSetDocumentShipToContact()
    {
        (self::$document)->setDocumentShipToContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:PersonName', "Otto Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@kunde.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentUltimateShipTo
     */
    public function testSetDocumentUltimateShipTo()
    {
        (self::$document)->setDocumentUltimateShipTo("Kunden AG Mitte", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentUltimateShipToGlobalId
     */
    public function testAddDocumentUltimateShipToGlobalId()
    {
        (self::$document)->addDocumentUltimateShipToGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentUltimateShipToTaxRegistration
     */
    public function testAddDocumentUltimateShipToTaxRegistration()
    {
        (self::$document)->addDocumentUltimateShipToTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentUltimateShipToTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentUltimateShipToAddress
     */
    public function testSetDocumentUltimateShipToAddress()
    {
        (self::$document)->setDocumentUltimateShipToAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentUltimateShipToLegalOrganisation
     */
    public function testSetDocumentUltimateShipToLegalOrganisation()
    {
        (self::$document)->setDocumentUltimateShipToLegalOrganisation("DE12345", "FC", "Kunden Holding");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentUltimateShipToContact
     */
    public function testSetDocumentUltimateShipToContact()
    {
        (self::$document)->setDocumentUltimateShipToContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentShipFrom
     */
    public function testSetDocumentShipFrom()
    {
        (self::$document)->setDocumentShipFrom("Lieferant GmbH", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentShipFromGlobalId
     */
    public function testAddDocumentShipFromGlobalId()
    {
        (self::$document)->addDocumentShipFromGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentShipFromTaxRegistration
     */
    public function testAddDocumentShipFromTaxRegistration()
    {
        (self::$document)->addDocumentShipFromTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentShipFromTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentShipFromAddress
     */
    public function testSetDocumentShipFromAddress()
    {
        (self::$document)->setDocumentShipFromAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentShipFromLegalOrganisation
     */
    public function testSetDocumentShipFromLegalOrganisation()
    {
        (self::$document)->setDocumentShipFromLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentShipFromContact
     */
    public function testSetDocumentShipFromContact()
    {
        (self::$document)->setDocumentShipFromContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ShipFromTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoicer
     */
    public function testSetDocumentInvoicer()
    {
        (self::$document)->setDocumentInvoicer("Lieferant GmbH", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentInvoicerGlobalId
     */
    public function testAddDocumentInvoicerGlobalId()
    {
        (self::$document)->addDocumentInvoicerGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentInvoicerTaxRegistration
     */
    public function testAddDocumentInvoicerTaxRegistration()
    {
        (self::$document)->addDocumentInvoicerTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentInvoicerTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoicerAddress
     */
    public function testSetDocumentInvoicerAddress()
    {
        (self::$document)->setDocumentInvoicerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoicerLegalOrganisation
     */
    public function testSetDocumentInvoicerLegalOrganisation()
    {
        (self::$document)->setDocumentInvoicerLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoicerContact
     */
    public function testSetDocumentInvoicerContact()
    {
        (self::$document)->setDocumentInvoicerContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoicerTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoicee
     */
    public function testSetDocumentInvoicee()
    {
        (self::$document)->setDocumentInvoicee("Lieferant GmbH", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:Name');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentInvoiceeGlobalId
     */
    public function testAddDocumentInvoiceeGlobalId()
    {
        (self::$document)->addDocumentInvoiceeGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:GlobalID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentInvoiceeTaxRegistration
     */
    public function testAddDocumentInvoiceeTaxRegistration()
    {
        (self::$document)->addDocumentInvoiceeTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentInvoiceeTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:SpecifiedTaxRegistration/ram:ID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoiceeAddress
     */
    public function testSetDocumentInvoiceeAddress()
    {
        (self::$document)->setDocumentInvoiceeAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:PostcodeCode');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:LineOne');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:CityName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:CountryID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoiceeLegalOrganisation
     */
    public function testSetDocumentInvoiceeLegalOrganisation()
    {
        (self::$document)->setDocumentInvoiceeLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:SpecifiedLegalOrganization/ram:ID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoiceeContact
     */
    public function testSetDocumentInvoiceeContact()
    {
        (self::$document)->setDocumentInvoiceeContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:PersonName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:DepartmentName');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceeTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPayee
     */
    public function testSetDocumentPayee()
    {
        (self::$document)->setDocumentPayee("Lieferant GmbH", "549910");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:ID', "549910");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:Name', "Lieferant GmbH");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPayeeGlobalId
     */
    public function testAddDocumentPayeeGlobalId()
    {
        (self::$document)->addDocumentPayeeGlobalId("4000001123452", "0088");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:GlobalID', 0, "4000001123452", "schemeID", "0088");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPayeeTaxRegistration
     */
    public function testAddDocumentPayeeTaxRegistration()
    {
        (self::$document)->addDocumentPayeeTaxRegistration("FC", "201/113/40209");
        (self::$document)->addDocumentPayeeTaxRegistration("VA", "DE123456789");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0, "201/113/40209", "schemeID", "FC");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1, "DE123456789", "schemeID", "VA");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPayeeAddress
     */
    public function testSetDocumentPayeeAddress()
    {
        (self::$document)->setDocumentPayeeAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', "80333");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:LineOne', "Lieferantenstraße 20");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:LineTwo');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:LineThree');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:CityName', "München");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:CountryID', "DE");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:PostalTradeAddress/ram:CountrySubDivisionName');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPayeeLegalOrganisation
     */
    public function testSetDocumentPayeeLegalOrganisation()
    {
        (self::$document)->setDocumentPayeeLegalOrganisation("DE12345", "FC", "Lieferant AG");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:SpecifiedLegalOrganization/ram:ID', 0, "DE12345", "schemeID", "FC");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:SpecifiedLegalOrganization/ram:TradingBusinessName', "Lieferant AG");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPayeeContact
     */
    public function testSetDocumentPayeeContact()
    {
        (self::$document)->setDocumentPayeeContact("Hans Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:PersonName', "Hans Müller");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:DepartmentName', "Financials");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', "+49-111-2222222");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:PayeeTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', "info@lieferant.de");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentDeliveryTerms
     */
    public function testSetDocumentDeliveryTerms()
    {
        (self::$document)->setDocumentDeliveryTerms("term");

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ApplicableTradeDeliveryTerms/ram:DeliveryTypeCode');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentSellerOrderReferencedDocument
     */
    public function testSetDocumentSellerOrderReferencedDocument()
    {
        (self::$document)->setDocumentSellerOrderReferencedDocument('B-1010', new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerOrderReferencedDocument/ram:IssuerAssignedID', "B-1010");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerOrderReferencedDocument/ram:FormattedIssueDateTime/ram:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentBuyerOrderReferencedDocument
     */
    public function testSetDocumentBuyerOrderReferencedDocument()
    {
        (self::$document)->setDocumentBuyerOrderReferencedDocument('O-2020', new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerOrderReferencedDocument/ram:IssuerAssignedID', "O-2020");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerOrderReferencedDocument/ram:FormattedIssueDateTime/ram:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentContractReferencedDocument
     */
    public function testSetDocumentContractReferencedDocument()
    {
        (self::$document)->setDocumentContractReferencedDocument("CON-4711", new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ContractReferencedDocument/ram:IssuerAssignedID', "CON-4711");
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:ContractReferencedDocument/ram:FormattedIssueDateTime/ram:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentAdditionalReferencedDocument
     */
    public function testAddDocumentAdditionalReferencedDocument()
    {
        (self::$document)->addDocumentAdditionalReferencedDocument("A-1011", "type", "http://lieferant.de/docs/a1011.pdf", "Leistungsnachweis", "reftype", new \DateTime());
        (self::$document)->addDocumentAdditionalReferencedDocument("B-2233", "type2", "http://lieferant.de/docs/b2233.pdf", "Lieferliste", "reftype2", new \DateTime());

        $this->disableRenderXmlContent();
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
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentInvoiceReferencedDocument
     */
    public function testSetDocumentInvoiceReferencedDocument()
    {
        (self::$document)->setDocumentInvoiceReferencedDocument("INV-1", new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceReferencedDocument/ram:IssuerAssignedID', "INV-1");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:InvoiceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentProcuringProject
     */
    public function testSetDocumentProcuringProject()
    {
        (self::$document)->setDocumentProcuringProject("HB-8378732", "Hausbau");

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SpecifiedProcuringProject/ram:ID', "HB-8378732");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SpecifiedProcuringProject/ram:Name', "Hausbau");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentUltimateCustomerOrderReferencedDocument
     */
    public function testAddDocumentUltimateCustomerOrderReferencedDocument()
    {
        (self::$document)->addDocumentUltimateCustomerOrderReferencedDocument("DOC-11", new \DateTime());
        (self::$document)->addDocumentUltimateCustomerOrderReferencedDocument("DOC-22", new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:UltimateCustomerOrderReferencedDocument/ram:IssuerAssignedID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:UltimateCustomerOrderReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentDespatchAdviceReferencedDocument
     */
    public function testSetDocumentDespatchAdviceReferencedDocument()
    {
        (self::$document)->setDocumentDespatchAdviceReferencedDocument("DADV-001", new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:IssuerAssignedID', "DADV-001");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentReceivingAdviceReferencedDocument
     */
    public function testSetDocumentReceivingAdviceReferencedDocument()
    {
        (self::$document)->setDocumentReceivingAdviceReferencedDocument("RADV-002", new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:IssuerAssignedID', "RADV-002");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentDeliveryNoteReferencedDocument
     */
    public function testSetDocumentDeliveryNoteReferencedDocument()
    {
        (self::$document)->setDocumentDeliveryNoteReferencedDocument("DNOTE-003", new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:IssuerAssignedID');
        $this->assertXPathNotExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPaymentMean
     */
    public function testAddDocumentPaymentMean()
    {
        (self::$document)->addDocumentPaymentMean("42", "Paying information", "cardtype", "cardid", "cardholder", "DE00000000000", "DE11111111111", "Bank", "44444444", "NOLADEQLB21");
        (self::$document)->addDocumentPaymentMean("49", "Paying information 2", "cardtype2", "cardid2", "cardholder2", "DE22222222222", "DE33333333333", "Bank 2", "22222222", "BIC");

        $this->disableRenderXmlContent();

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
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentTax
     */
    public function testAddDocumentTax()
    {
        (self::$document)->addDocumentTax("S", "VAT", 100.0, 19.0, 19, "exreason", "exreasoncode", 100.0, 1.0, new \DateTime(), "duetypecode");
        (self::$document)->addDocumentTax("S", "VAT", 200.0, 14.0, 7, "exreason2", "exreasoncode2", 200.0, 2.0, new \DateTime(), "duetypecode2");

        $this->disableRenderXmlContent();

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
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentTaxSimple
     */
    public function testAddDocumentTaxSimple()
    {
        (self::$document)->addDocumentTaxSimple("S", "VAT", 100.0, 19.0, 19.0);

        $this->disableRenderXmlContent();
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
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentBillingPeriod
     */
    public function testSetDocumentBillingPeriod()
    {
        (self::$document)->setDocumentBillingPeriod(new \DateTime(), new \DateTime(), "Project");

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:BillingSpecifiedPeriod/ram:StartDateTime/udt:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:BillingSpecifiedPeriod/ram:EndDateTime/udt:DateTimeString', (new \DateTime())->format("Ymd"), "format", "102");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentAllowanceCharge
     */
    public function testAddDocumentAllowanceCharge()
    {
        (self::$document)->addDocumentAllowanceCharge(10.0, false, "S", "VAT", 19.0, 1, 10.0, 100.0, 1, "C62", "reasoncode", "reason");
        (self::$document)->addDocumentAllowanceCharge(10.0, false, "S", "VAT", 19.0, 1, 10.0, 100.0, 1, "C62", "reasoncode", "reason");

        $this->disableRenderXmlContent();

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
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentLogisticsServiceCharge
     */
    public function testAddDocumentLogisticsServiceCharge()
    {
        (self::$document)->addDocumentLogisticsServiceCharge("Service", 10.0, ["S"], ["VAT"], [19.0]);

        $this->disableRenderXmlContent();
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:Description', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:AppliedAmount', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:AppliedTradeTax/ram:TypeCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:AppliedTradeTax/ram:CategoryCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedLogisticsServiceCharge/ram:AppliedTradeTax/ram:RateApplicablePercent', 0);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPaymentTerm
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDiscountTermsToPaymentTerms
     */
    public function testAddDocumentPaymentTermAndDiscount()
    {
        (self::$document)->addDocumentPaymentTerm("Payment", new \DateTime(), "mandate");
        (self::$document)->addDiscountTermsToPaymentTerms(10.0, new \DateTime(), 1, "DAY", 20.0, 2.0);

        $this->disableRenderXmlContent();

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
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentReceivableSpecifiedTradeAccountingAccount
     */
    public function testAddDocumentReceivableSpecifiedTradeAccountingAccount()
    {
        (self::$document)->addDocumentReceivableSpecifiedTradeAccountingAccount("accountid", "typecode");
        (self::$document)->addDocumentReceivableSpecifiedTradeAccountingAccount("accountid2", "typecode2");

        $this->disableRenderXmlContent();

        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ReceivableSpecifiedTradeAccountingAccount/ram:ID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ReceivableSpecifiedTradeAccountingAccount/ram:TypeCode', 0);

        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ReceivableSpecifiedTradeAccountingAccount/ram:ID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ReceivableSpecifiedTradeAccountingAccount/ram:TypeCode', 1);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::InitDocumentSummation
     */
    public function testInitDocumentSummation()
    {
        (self::$document)->initDocumentSummation();

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:LineTotalAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:ChargeTotalAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:AllowanceTotalAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxBasisTotalAmount', 0, "0.0");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxTotalAmount', 0, "0.0", "currencyID", "EUR");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:RoundingAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:GrandTotalAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TotalPrepaidAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:DuePayableAmount', 0, "0.0");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::SetDocumentSummation
     */
    public function testSetDocumentSummation()
    {
        (self::$document)->setDocumentSummation(100.0, 0.0, 100.0, 5.0, 4.0, 99.0, 10.0, 0.0, 0.0);

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:LineTotalAmount', 0, "100.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:ChargeTotalAmount', 0, "5.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:AllowanceTotalAmount', 0, "4.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxBasisTotalAmount', 0, "99.0");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxTotalAmount', 0, "10.0", "currencyID", "EUR");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:RoundingAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:GrandTotalAmount', 0, "100.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TotalPrepaidAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:DuePayableAmount', 0, "0.0");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addNewPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionProductDetails
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionBuyerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionContractReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionGrossPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionNetPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionNetPriceTax
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionQuantity
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionShipTo
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionShipToGlobalId
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionShipToTaxRegistration
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionShipToAddress
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionShipToLegalOrganisation
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionShipToContact
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionUltimateShipTo
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionUltimateShipToGlobalId
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionUltimateShipToTaxRegistration
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionUltimateShipToAddress
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionUltimateShipToLegalOrganisation
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionUltimateShipToContact
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionSupplyChainEvent
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionDespatchAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionReceivingAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionDeliveryNoteReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionBillingPeriod
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::setDocumentPositionLineSummation
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionReceivableSpecifiedTradeAccountingAccount
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionAdditionalReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::addDocumentPositionUltimateCustomerOrderReferencedDocument
     */
    public function testPositionMethods()
    {
        (self::$document)->addNewPosition("1", "linestatuscode", "linestatusreasoncode");
        (self::$document)->setDocumentPositionNote("content", "contentcode", "subjectcode");
        (self::$document)->setDocumentPositionProductDetails("Product Name", "Product Description", "SellerID", "BuyerID", "0088", "11111222222");
        (self::$document)->setDocumentPositionBuyerOrderReferencedDocument("B-0001", "1", new \DateTime());
        (self::$document)->setDocumentPositionContractReferencedDocument("C-0002", "2", new \DateTime());
        (self::$document)->setDocumentPositionGrossPrice(105, 1, "C62");
        (self::$document)->addDocumentPositionGrossPriceAllowanceCharge(10, false, 10, 20, "reason", "taxtypecode", "taxcategorycode", 19.9, 1, 1, "C62", "reasoncode");
        (self::$document)->setDocumentPositionNetPrice(20.0, 1, "C62");
        (self::$document)->setDocumentPositionNetPriceTax("S", "VAT", 19.0, 10.0, "reason", "reasoncode");
        (self::$document)->setDocumentPositionQuantity(10.0, "C62", 0.0, "C62", 1.0, "C62");
        (self::$document)->setDocumentPositionShipTo("shiptoname", "shiptoid", "shiptodescription");
        (self::$document)->addDocumentPositionShipToGlobalId("shiptoglobslid", "shiptoglobslidtype");
        (self::$document)->addDocumentPositionShipToTaxRegistration("VA", "123");
        (self::$document)->setDocumentPositionShipToAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");
        (self::$document)->setDocumentPositionShipToLegalOrganisation("DE12345", "FC", "Kunden Holding");
        (self::$document)->setDocumentPositionShipToContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");
        (self::$document)->setDocumentPositionUltimateShipTo("shiptoname", "shiptoid", "shiptodescription");
        (self::$document)->addDocumentPositionUltimateShipToGlobalId("shiptoglobslid", "shiptoglobslidtype");
        (self::$document)->addDocumentPositionUltimateShipToTaxRegistration("VA", "123");
        (self::$document)->setDocumentPositionUltimateShipToAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");
        (self::$document)->setDocumentPositionUltimateShipToLegalOrganisation("DE12345", "FC", "Kunden Holding");
        (self::$document)->setDocumentPositionUltimateShipToContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");
        (self::$document)->setDocumentPositionSupplyChainEvent(new \DateTime());
        (self::$document)->setDocumentPositionDespatchAdviceReferencedDocument("DADV-001", "3", new \DateTime());
        (self::$document)->setDocumentPositionReceivingAdviceReferencedDocument("RADV-002", "4", new \DateTime());
        (self::$document)->setDocumentPositionDeliveryNoteReferencedDocument("DNOTE-003", "4", new \DateTime());
        (self::$document)->addDocumentPositionTax("S", "VAT", 19.0, 10.0, "reason", "reasoncode");
        (self::$document)->setDocumentPositionBillingPeriod(new \DateTime(), new \DateTime());
        (self::$document)->addDocumentPositionAllowanceCharge(10.0, true, 19.0, 10.0, "reasoncode", "reason");
        (self::$document)->setDocumentPositionLineSummation(100, 10);
        (self::$document)->addDocumentPositionReceivableSpecifiedTradeAccountingAccount("accid", "acctypecode");
        (self::$document)->addDocumentPositionAdditionalReferencedDocument("1", "2", "3", "4", "name", "reftypecode", new \DateTime());
        (self::$document)->addDocumentPositionUltimateCustomerOrderReferencedDocument("ORDER-0001", "1.1", new \DateTime());

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:LineID', 0, "1");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:LineStatusCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:LineStatusReasonCode', 0);
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:IncludedNote/ram:Content', 0, "content");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:IncludedNote/ram:SubjectCode', 0, "subjectcode");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:IncludedNote/ram:ContentCode', 0);
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:GlobalID', 0, "11111222222", "schemeID", "0088");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:SellerAssignedID', 0, "SellerID");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:BuyerAssignedID', 0, "BuyerID");
        //$this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:Name', 0, "Product Mame");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:Description', 0, "Product Description");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:BuyerOrderReferencedDocument/ram:IssuerAssignedID', 0, "B-0001");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:BuyerOrderReferencedDocument/ram:LineID', 0, "1");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:BuyerOrderReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 0, (new \DateTime)->format("Ymd"), "format", "102");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:ContractReferencedDocument/ram:IssuerAssignedID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:ContractReferencedDocument/ram:LineID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:ContractReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 0);
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', 0, "105.0");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:BasisQuantity', 0, "1", "unitCode", "C62");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:AppliedTradeAllowanceCharge/ram:CalculationPercent', 0, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:AppliedTradeAllowanceCharge/ram:BasisAmount', 0, "20.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:AppliedTradeAllowanceCharge/ram:ActualAmount', 0, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:AppliedTradeAllowanceCharge/ram:ReasonCode', 0, "reasoncode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:AppliedTradeAllowanceCharge/ram:Reason', 0, "reason");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:AppliedTradeAllowanceCharge/ram:CategoryTradeTax/ram:TypeCode', 0, "taxtypecode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:AppliedTradeAllowanceCharge/ram:CategoryTradeTax/ram:CategoryCode', 0, "taxcategorycode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:AppliedTradeAllowanceCharge/ram:CategoryTradeTax/ram:RateApplicablePercent', 0, "19.9");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', 0, "105.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:ChargeAmount', 0, "20.0");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:BasisQuantity', 0, "1.0", "unitCode", "C62");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:CalculatedAmount', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:TypeCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:ExemptionReason', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:CategoryCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:ExemptionReasonCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:RateApplicablePercent', 0);
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:BilledQuantity', 0, "10.0", "unitCode", "C62");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ChargeFreeQuantity', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:PackageQuantity', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:ID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:Name', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:Description', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:GlobalID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedTaxRegistration', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:LineOne', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CityName', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CountryID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:PersonName', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:DepartmentName', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:ID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:Name', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:Description', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:GlobalID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedTaxRegistration', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:LineOne', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CityName', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CountryID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:PersonName', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:DepartmentName', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ActualDeliverySupplyChainEvent/ram:OccurrenceDateTime/udt:DateTimeString', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:IssuerAssignedID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:LineID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:IssuerAssignedID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:LineID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:IssuerAssignedID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:LineID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 0);
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:CalculatedAmount', 0, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:TypeCode', 0, "VAT");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReason', 0, "reason");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:CategoryCode', 0, "S");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReasonCode', 0, "reasoncode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:RateApplicablePercent', 0, "19.0");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:BillingSpecifiedPeriod/ram:StartDateTime/udt:DateTimeString', 0, (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:BillingSpecifiedPeriod/ram:EndDateTime/udt:DateTimeString', 0, (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ChargeIndicator/udt:Indicator', 0, "true");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CalculationPercent', 0, "19.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:BasisAmount', 0, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ReasonCode', 0, "reasoncode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:Reason', 0, "reason");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ActualAmount', 0, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeSettlementLineMonetarySummation/ram:LineTotalAmount', 0, "100.0");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeSettlementLineMonetarySummation/ram:TotalAllowanceChargeAmount', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ReceivableSpecifiedTradeAccountingAccount/ram:ID', 0);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ReceivableSpecifiedTradeAccountingAccount/ram:TypeCode', 0);
        
        (self::$document)->addNewPosition("2", "linestatuscode", "linestatusreasoncode");
        (self::$document)->setDocumentPositionNote("content2", "contentcode2", "subjectcode2");
        (self::$document)->setDocumentPositionProductDetails("Product Name 2", "Product Description 2", "SellerID 2", "BuyerID 2", "0160", "333");
        (self::$document)->setDocumentPositionGrossPrice(200, 2, "H87");
        (self::$document)->setDocumentPositionNetPrice(30.0, 2, "H87");
        (self::$document)->setDocumentPositionNetPriceTax("S", "VAT", 19.0, 10.0, "reason 2", "reasoncode 2");
        (self::$document)->setDocumentPositionQuantity(20.0, "H87", 0.0, "H87", 1.0, "H87");
        (self::$document)->setDocumentPositionShipTo("shiptoname2", "shiptoid2", "shiptodescription2");
        (self::$document)->addDocumentPositionShipToGlobalId("shiptoglobslid2", "shiptoglobslidtype2");
        (self::$document)->addDocumentPositionShipToTaxRegistration("VA", "123");
        (self::$document)->setDocumentPositionShipToAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");
        (self::$document)->setDocumentPositionShipToLegalOrganisation("DE12345", "FC", "Kunden Holding");
        (self::$document)->setDocumentPositionShipToContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");
        (self::$document)->setDocumentPositionUltimateShipTo("shiptoname", "shiptoid", "shiptodescription");
        (self::$document)->addDocumentPositionUltimateShipToGlobalId("shiptoglobslid", "shiptoglobslidtype");
        (self::$document)->addDocumentPositionUltimateShipToTaxRegistration("VA", "123");
        (self::$document)->setDocumentPositionUltimateShipToAddress("Kundenstrasse 15", "", "", "69876", "Frankfurt", "DE");
        (self::$document)->setDocumentPositionUltimateShipToLegalOrganisation("DE12345", "FC", "Kunden Holding");
        (self::$document)->setDocumentPositionUltimateShipToContact("Otto Müller", "Financials", "+49-111-2222222", "+49-111-3333333", "info@kunde.de");
        (self::$document)->setDocumentPositionSupplyChainEvent(new \DateTime());
        (self::$document)->setDocumentPositionDespatchAdviceReferencedDocument("DADV-001", "3", new \DateTime());
        (self::$document)->setDocumentPositionReceivingAdviceReferencedDocument("RADV-002", "4", new \DateTime());
        (self::$document)->setDocumentPositionDeliveryNoteReferencedDocument("DNOTE-003", "4", new \DateTime());
        (self::$document)->addDocumentPositionTax("S", "VAT", 7.0, 2.0, "reason2", "reasoncode2");
        (self::$document)->setDocumentPositionBillingPeriod(new \DateTime(), new \DateTime());
        (self::$document)->addDocumentPositionAllowanceCharge(10.0, true, 19.0, 10.0, "reasoncode", "reason");
        (self::$document)->setDocumentPositionLineSummation(200, 20);

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:LineID', 1, "2");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:LineStatusCode', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:LineStatusReasonCode', 1);
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:IncludedNote/ram:Content', 1, "content2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:IncludedNote/ram:SubjectCode', 1, "subjectcode2");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:AssociatedDocumentLineDocument/ram:IncludedNote/ram:ContentCode', 1);
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:GlobalID', 1, "333", "schemeID", "0160");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:SellerAssignedID', 1, "SellerID 2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:BuyerAssignedID', 1, "BuyerID 2");
        //$this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:Name', 1, "Product Mame 2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedTradeProduct/ram:Description', 1, "Product Description 2");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:BuyerOrderReferencedDocument/ram:IssuerAssignedID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:BuyerOrderReferencedDocument/ram:LineID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:BuyerOrderReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:ContractReferencedDocument/ram:IssuerAssignedID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:ContractReferencedDocument/ram:LineID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:ContractReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 1);
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', 1, "200.0");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:BasisQuantity', 1, "2", "unitCode", "H87");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:ChargeAmount', 1, "30.0");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:BasisQuantity', 1, "2.0", "unitCode", "H87");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:CalculatedAmount', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:TypeCode', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:ExemptionReason', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:CategoryCode', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:ExemptionReasonCode', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:IncludedTradeTax/ram:RateApplicablePercent', 1);
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:BilledQuantity', 1, "20.0", "unitCode", "H87");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ChargeFreeQuantity', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:PackageQuantity', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:ID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:Name', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:Description', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:GlobalID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedTaxRegistration', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:LineOne', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CityName', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:PostalTradeAddress/ram:CountryID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:PersonName', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:DepartmentName', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ShipToTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:ID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:Name', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:Description', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:GlobalID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedTaxRegistration', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:PostcodeCode', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:LineOne', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CityName', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:PostalTradeAddress/ram:CountryID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:SpecifiedTaxRegistration/ram:ID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:PersonName', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:DepartmentName', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:TelephoneUniversalCommunication/ram:CompleteNumber', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:FaxUniversalCommunication/ram:CompleteNumber', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:UltimateShipToTradeParty/ram:DefinedTradeContact/ram:EmailURIUniversalCommunication/ram:URIID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ActualDeliverySupplyChainEvent/ram:OccurrenceDateTime/udt:DateTimeString', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:IssuerAssignedID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:LineID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DespatchAdviceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:IssuerAssignedID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:LineID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:ReceivingAdviceReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:IssuerAssignedID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:LineID', 1);
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeDelivery/ram:DeliveryNoteReferencedDocument/ram:FormattedIssueDateTime/a:DateTimeString', 1);
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:CalculatedAmount', 1, "2.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:TypeCode', 1, "VAT");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReason', 1, "reason2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:CategoryCode', 1, "S");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:ExemptionReasonCode', 1, "reasoncode2");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:ApplicableTradeTax/ram:RateApplicablePercent', 1, "7.0");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:BillingSpecifiedPeriod/ram:StartDateTime/udt:DateTimeString', 1, (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:BillingSpecifiedPeriod/ram:EndDateTime/udt:DateTimeString', 1, (new \DateTime())->format("Ymd"), "format", "102");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ChargeIndicator/udt:Indicator', 1, "true");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:CalculationPercent', 1, "19.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:BasisAmount', 1, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ReasonCode', 1, "reasoncode");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:Reason', 1, "reason");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeAllowanceCharge/ram:ActualAmount', 1, "10.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeSettlementLineMonetarySummation/ram:LineTotalAmount', 1, "200.0");
        $this->assertXPathNotExistsWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeSettlement/ram:SpecifiedTradeSettlementLineMonetarySummation/ram:TotalAllowanceChargeAmount', 1);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::InitNewDocument
     */
    public function testInitNewDocument()
    {
        (self::$document)->InitNewDocument();

        $this->disableRenderXmlContent();
        $this->assertXPathExists('/rsm:CrossIndustryInvoice');
        $this->assertXPathExists('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext');
        $this->assertXPathExists('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID', "urn:cen.eu:en16931:2017");
        $this->assertXPathExists('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument');
        $this->assertXPathExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement');
        $this->assertXPathExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeDelivery');
        $this->assertXPathExists('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement');
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilder::writeFile
     */
    public function testWriteFile()
    {
        (self::$document)->writeFile(getcwd() . "/myfile.xml");
        $this->assertTrue(file_exists(getcwd() . "/myfile.xml"));
        @unlink(getcwd() . "/myfile.xml");
    }
}
