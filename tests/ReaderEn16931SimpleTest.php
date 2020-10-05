<?php

namespace horstoeko\zugferd\tests;

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;

class ReaderEn16931SimpleTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::ReadAndGuessFromFile(dirname(__FILE__) . "/data/en16931_simple.xml");
    }

    public function testDocumentProfile()
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->profile);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInformation
     */
    public function testDocumentGenerals()
    {
        self::$document->GetDocumentInformation($documentno, $documenttypecode, $documentdate, $duedate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('471102', $documentno);
        $this->assertEquals(ZugferdInvoiceType::Invoice, $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180305'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertNull($duedate);
        $this->assertEquals("EUR", $invoiceCurrency);
        $this->assertEquals("", $taxCurrency);
        $this->assertEquals("", $documentname);
        $this->assertEquals("", $documentlanguage);
        $this->assertNull($effectiveSpecifiedPeriod);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentNotes
     */
    public function testDocumentNotes()
    {
        self::$document->GetDocumentNotes($notes);
        $this->assertIsArray($notes);
        $this->assertNotEmpty($notes);
        $this->assertEquals(2, count($notes));
        $this->assertArrayHasKey(0, $notes);
        $this->assertArrayHasKey(1, $notes);
        $this->assertIsArray($notes[0]);
        $this->assertNotEmpty($notes[0]);
        $this->assertArrayHasKey("content", $notes[0]);
        $this->assertArrayHasKey("subjectcode", $notes[0]);
        $this->assertArrayHasKey("contentcode", $notes[0]);
        $this->assertIsArray($notes[1]);
        $this->assertNotEmpty($notes[1]);
        $this->assertArrayHasKey("content", $notes[1]);
        $this->assertArrayHasKey("subjectcode", $notes[1]);
        $this->assertArrayHasKey("contentcode", $notes[1]);
        $this->assertEquals("", $notes[0]["contentcode"]);
        $this->assertEquals("", $notes[0]["subjectcode"]);
        $this->assertEquals("Rechnung gemäß Bestellung vom 01.03.2018.", $notes[0]["content"]);
        $this->assertEquals("", $notes[1]["contentcode"]);
        $this->assertEquals("REG", $notes[1]["subjectcode"]);
        $this->assertStringContainsString("Lieferant GmbH", $notes[1]["content"]);
        $this->assertStringContainsString("Lieferantenstraße 20", $notes[1]["content"]);
        $this->assertStringContainsString("80333 München", $notes[1]["content"]);
        $this->assertStringContainsString("Deutschland", $notes[1]["content"]);
        $this->assertStringContainsString("Geschäftsführer: Hans Muster", $notes[1]["content"]);
        $this->assertStringContainsString("Handelsregisternummer: H A 123", $notes[1]["content"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentGeneralPaymentInformation
     */
    public function testDocumentGeneralPaymentInformation()
    {
        self::$document->GetDocumentGeneralPaymentInformation($creditorReferenceID, $paymentReference);
        $this->assertEquals("", $creditorReferenceID);
        $this->assertEquals("", $paymentReference);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetIsDocumentCopy
     */
    public function testDocumentIsCopy()
    {
        self::$document->GetIsDocumentCopy($iscopy);
        $this->assertFalse($iscopy);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetIsTestDocument
     */
    public function testDocumentIsTestDocument()
    {
        self::$document->GetIsTestDocument($istest);
        $this->assertFalse($istest);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSummation
     */
    public function testDocumentSummation()
    {
        self::$document->GetDocumentSummation($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);
        $this->assertEquals(529.87, $grandTotalAmount);
        $this->assertEquals(529.87, $duePayableAmount);
        $this->assertEquals(473.00, $lineTotalAmount);
        $this->assertEquals(0.00, $chargeTotalAmount);
        $this->assertEquals(0.00, $allowanceTotalAmount);
        $this->assertEquals(473.00, $taxBasisTotalAmount);
        $this->assertEquals(56.87, $taxTotalAmount);
        $this->assertEquals(0.00, $roundingAmount);
        $this->assertEquals(0.00, $totalPrepaidAmount);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSeller
     */
    public function testDocumentSellerGeneral()
    {
        self::$document->GetDocumentSeller($sellername, $sellerids, $sellerdescription);
        $this->assertEquals("Lieferant GmbH", $sellername);
        $this->assertIsArray($sellerids);
        $this->assertArrayHasKey(0, $sellerids);
        $this->assertArrayNotHasKey(1, $sellerids);
        $this->assertEquals("549910", $sellerids[0]);
        $this->assertEquals("", $sellerdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerGlobalId
     */
    public function testDocumentSellerGlobalId()
    {
        self::$document->GetDocumentSellerGlobalId($sellerglobalids);
        $this->assertIsArray($sellerglobalids);
        $this->assertArrayHasKey("0088", $sellerglobalids);
        $this->assertEquals("4000001123452", $sellerglobalids["0088"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerTaxRegistration
     */
    public function testDocumentSellerTaxRegistration()
    {
        self::$document->GetDocumentSellerTaxRegistration($sellertaxreg);
        $this->assertIsArray($sellertaxreg);
        $this->assertArrayHasKey("VA", $sellertaxreg);
        $this->assertArrayHasKey("FC", $sellertaxreg);
        $this->assertArrayNotHasKey(0, $sellertaxreg);
        $this->assertArrayNotHasKey(1, $sellertaxreg);
        $this->assertArrayNotHasKey("ZZ", $sellertaxreg);
        $this->assertEquals("201/113/40209", $sellertaxreg["FC"]);
        $this->assertEquals("DE123456789", $sellertaxreg["VA"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerAddress
     */
    public function testDocumentSellerAddress()
    {
        self::$document->GetDocumentSellerAddress($sellerlineone, $sellerlinetwo, $sellerlinethree, $sellerpostcode, $sellercity, $sellercountry, $sellersubdivision);
        $this->assertEquals("Lieferantenstraße 20", $sellerlineone);
        $this->assertEquals("", $sellerlinetwo);
        $this->assertEquals("", $sellerlinethree);
        $this->assertEquals("80333", $sellerpostcode);
        $this->assertEquals("München", $sellercity);
        $this->assertEquals("DE", $sellercountry);
        $this->assertIsArray($sellersubdivision);
        $this->assertEmpty($sellersubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerLegalOrganisation
     */
    public function testDocumentSellerLegalOrganization()
    {
        self::$document->GetDocumentSellerLegalOrganisation($sellerlegalorgid, $sellerlegalorgtype, $sellerlegalorgname);
        $this->assertEquals("", $sellerlegalorgid);
        $this->assertEquals("", $sellerlegalorgtype);
        $this->assertEquals("", $sellerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerContact
     */
    public function testDocumentSellerContact()
    {
        self::$document->GetDocumentSellerContact($sellercontactpersonname, $sellercontactdepartmentname, $sellercontactphoneno, $sellercontactfaxno, $sellercontactemailaddr);
        $this->assertEquals("", $sellercontactpersonname);
        $this->assertEquals("", $sellercontactdepartmentname);
        $this->assertEquals("", $sellercontactphoneno);
        $this->assertEquals("", $sellercontactfaxno);
        $this->assertEquals("", $sellercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyer
     */
    public function testDocumentBuyerGeneral()
    {
        self::$document->GetDocumentBuyer($buyername, $buyerids, $buyerdescription);
        $this->assertEquals("Kunden AG Mitte", $buyername);
        $this->assertIsArray($buyerids);
        $this->assertArrayHasKey(0, $buyerids);
        $this->assertArrayNotHasKey(1, $buyerids);
        $this->assertEquals("GE2020211", $buyerids[0]);
        $this->assertEquals("", $buyerdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyerGlobalId
     */
    public function testDocumentBuyerGlobalId()
    {
        self::$document->GetDocumentBuyerGlobalId($buyerglobalids);
        $this->assertIsArray($buyerglobalids);
        $this->assertEmpty($buyerglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyerTaxRegistration
     */
    public function testDocumentBuyerTaxRegistration()
    {
        self::$document->GetDocumentBuyerTaxRegistration($buyertaxreg);
        $this->assertIsArray($buyertaxreg);
        $this->assertEmpty($buyertaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyerAddress
     */
    public function testDocumentBuyerAddress()
    {
        self::$document->GetDocumentBuyerAddress($buyerlineone, $buyerlinetwo, $buyerlinethree, $buyerpostcode, $buyercity, $buyercountry, $buyersubdivision);
        $this->assertEquals("Kundenstraße 15", $buyerlineone);
        $this->assertEquals("", $buyerlinetwo);
        $this->assertEquals("", $buyerlinethree);
        $this->assertEquals("69876", $buyerpostcode);
        $this->assertEquals("Frankfurt", $buyercity);
        $this->assertEquals("DE", $buyercountry);
        $this->assertIsArray($buyersubdivision);
        $this->assertEmpty($buyersubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyerLegalOrganisation
     */
    public function testDocumentBuyerLegalOrganization()
    {
        self::$document->GetDocumentBuyerLegalOrganisation($buyerlegalorgid, $buyerlegalorgtype, $buyerlegalorgname);
        $this->assertEquals("", $buyerlegalorgid);
        $this->assertEquals("", $buyerlegalorgtype);
        $this->assertEquals("", $buyerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyerContact
     */
    public function testDocumentBuyerContact()
    {
        self::$document->GetDocumentBuyerContact($buyercontactpersonname, $buyercontactdepartmentname, $buyercontactphoneno, $buyercontactfaxno, $buyercontactemailaddr);
        $this->assertEquals("", $buyercontactpersonname);
        $this->assertEquals("", $buyercontactdepartmentname);
        $this->assertEquals("", $buyercontactphoneno);
        $this->assertEquals("", $buyercontactfaxno);
        $this->assertEquals("", $buyercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerTaxRepresentative
     */
    public function testDocumentSellerTaxRepresentativeGeneral()
    {
        self::$document->GetDocumentSellerTaxRepresentative($sellertaxreprname, $sellertaxreprids, $sellertaxreprdescription);
        $this->assertEquals("", $sellertaxreprname);
        $this->assertIsArray($sellertaxreprids);
        $this->assertEmpty($sellertaxreprids);
        $this->assertEquals("", $sellertaxreprdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerTaxRepresentativeGlobalId
     */
    public function testDocumentSellerTaxRepresentativeGlobalId()
    {
        self::$document->GetDocumentSellerTaxRepresentativeGlobalId($sellertaxreprglobalids);
        $this->assertIsArray($sellertaxreprglobalids);
        $this->assertEmpty($sellertaxreprglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerTaxRepresentativeTaxRegistration
     */
    public function testDocumentSellerTaxRepresentativeTaxRegistration()
    {
        self::$document->GetDocumentSellerTaxRepresentativeTaxRegistration($sellertaxreprtaxreg);
        $this->assertIsArray($sellertaxreprtaxreg);
        $this->assertEmpty($sellertaxreprtaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerTaxRepresentativeAddress
     */
    public function testDocumentSellerTaxRepresentativeAddress()
    {
        self::$document->GetDocumentSellerTaxRepresentativeAddress($sellertaxreprlineone, $sellertaxreprlinetwo, $sellertaxreprlinethree, $sellertaxreprpostcode, $sellertaxreprcity, $sellertaxreprcountry, $sellertaxreprsubdivision);
        $this->assertEquals("", $sellertaxreprlineone);
        $this->assertEquals("", $sellertaxreprlinetwo);
        $this->assertEquals("", $sellertaxreprlinethree);
        $this->assertEquals("", $sellertaxreprpostcode);
        $this->assertEquals("", $sellertaxreprcity);
        $this->assertEquals("", $sellertaxreprcountry);
        $this->assertIsArray($sellertaxreprsubdivision);
        $this->assertEmpty($sellertaxreprsubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerTaxRepresentativeLegalOrganisation
     */
    public function testDocumentSellerTaxRepresentativeLegalOrganization()
    {
        self::$document->GetDocumentSellerTaxRepresentativeLegalOrganisation($sellertaxreprlegalorgid, $sellertaxreprlegalorgtype, $sellertaxreprlegalorgname);
        $this->assertEquals("", $sellertaxreprlegalorgid);
        $this->assertEquals("", $sellertaxreprlegalorgtype);
        $this->assertEquals("", $sellertaxreprlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerTaxRepresentativeContact
     */
    public function testDocumentSellerTaxRepresentativeContact()
    {
        self::$document->GetDocumentSellerTaxRepresentativeContact($sellertaxreprcontactpersonname, $sellertaxreprcontactdepartmentname, $sellertaxreprcontactphoneno, $sellertaxreprcontactfaxno, $sellertaxreprcontactemailaddr);
        $this->assertEquals("", $sellertaxreprcontactpersonname);
        $this->assertEquals("", $sellertaxreprcontactdepartmentname);
        $this->assertEquals("", $sellertaxreprcontactphoneno);
        $this->assertEquals("", $sellertaxreprcontactfaxno);
        $this->assertEquals("", $sellertaxreprcontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipTo
     */
    public function testDocumentShipToGeneral()
    {
        self::$document->GetDocumentShipTo($shiptoname, $shiptoids, $shiptodescription);
        $this->assertEquals("", $shiptoname);
        $this->assertIsArray($shiptoids);
        $this->assertEmpty($shiptoids);
        $this->assertEquals("", $shiptodescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipToGlobalId
     */
    public function testDocumentShipToGlobalId()
    {
        self::$document->GetDocumentShipToGlobalId($shiptoglobalids);
        $this->assertIsArray($shiptoglobalids);
        $this->assertEmpty($shiptoglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipToTaxRegistration
     */
    public function testDocumentShipToTaxRegistration()
    {
        self::$document->GetDocumentShipToTaxRegistration($shiptotaxreg);
        $this->assertIsArray($shiptotaxreg);
        $this->assertEmpty($shiptotaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipToAddress
     */
    public function testDocumentShipToAddress()
    {
        self::$document->GetDocumentShipToAddress($shiptolineone, $shiptolinetwo, $shiptolinethree, $shiptopostcode, $shiptocity, $shiptocountry, $shiptosubdivision);
        $this->assertEquals("", $shiptolineone);
        $this->assertEquals("", $shiptolinetwo);
        $this->assertEquals("", $shiptolinethree);
        $this->assertEquals("", $shiptopostcode);
        $this->assertEquals("", $shiptocity);
        $this->assertEquals("", $shiptocountry);
        $this->assertIsArray($shiptosubdivision);
        $this->assertEmpty($shiptosubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipToLegalOrganisation
     */
    public function testDocumentShipToLegalOrganization()
    {
        self::$document->GetDocumentShipToLegalOrganisation($shiptolegalorgid, $shiptolegalorgtype, $shiptolegalorgname);
        $this->assertEquals("", $shiptolegalorgid);
        $this->assertEquals("", $shiptolegalorgtype);
        $this->assertEquals("", $shiptolegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipToContact
     */
    public function testDocumentShipToContact()
    {
        self::$document->GetDocumentShipToContact($shiptocontactpersonname, $shiptocontactdepartmentname, $shiptocontactphoneno, $shiptocontactfaxno, $shiptocontactemailaddr);
        $this->assertEquals("", $shiptocontactpersonname);
        $this->assertEquals("", $shiptocontactdepartmentname);
        $this->assertEquals("", $shiptocontactphoneno);
        $this->assertEquals("", $shiptocontactfaxno);
        $this->assertEquals("", $shiptocontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentUltimateShipTo
     */
    public function testDocumentUltimateShipToGeneral()
    {
        self::$document->GetDocumentUltimateShipTo($ultimateshiptoname, $ultimateshiptoids, $ultimateshiptodescription);
        $this->assertEquals("", $ultimateshiptoname);
        $this->assertIsArray($ultimateshiptoids);
        $this->assertEmpty($ultimateshiptoids);
        $this->assertEquals("", $ultimateshiptodescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentUltimateShipToGlobalId
     */
    public function testDocumentUltimateShipToGlobalId()
    {
        self::$document->GetDocumentUltimateShipToGlobalId($ultimateshiptoglobalids);
        $this->assertIsArray($ultimateshiptoglobalids);
        $this->assertEmpty($ultimateshiptoglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentUltimateShipToTaxRegistration
     */
    public function testDocumentUltimateShipToTaxRegistration()
    {
        self::$document->GetDocumentUltimateShipToTaxRegistration($ultimateshiptotaxreg);
        $this->assertIsArray($ultimateshiptotaxreg);
        $this->assertEmpty($ultimateshiptotaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentUltimateShipToAddress
     */
    public function testDocumentUltimateShipToAddress()
    {
        self::$document->GetDocumentUltimateShipToAddress($ultimateshiptolineone, $ultimateshiptolinetwo, $ultimateshiptolinethree, $ultimateshiptopostcode, $ultimateshiptocity, $ultimateshiptocountry, $ultimateshiptosubdivision);
        $this->assertEquals("", $ultimateshiptolineone);
        $this->assertEquals("", $ultimateshiptolinetwo);
        $this->assertEquals("", $ultimateshiptolinethree);
        $this->assertEquals("", $ultimateshiptopostcode);
        $this->assertEquals("", $ultimateshiptocity);
        $this->assertEquals("", $ultimateshiptocountry);
        $this->assertIsArray($ultimateshiptosubdivision);
        $this->assertEmpty($ultimateshiptosubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentUltimateShipToLegalOrganisation
     */
    public function testDocumentUltimateShipToLegalOrganization()
    {
        self::$document->GetDocumentUltimateShipToLegalOrganisation($ultimateshiptolegalorgid, $ultimateshiptolegalorgtype, $ultimateshiptolegalorgname);
        $this->assertEquals("", $ultimateshiptolegalorgid);
        $this->assertEquals("", $ultimateshiptolegalorgtype);
        $this->assertEquals("", $ultimateshiptolegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentUltimateShipToContact
     */
    public function testDocumentUltimateShipToContact()
    {
        self::$document->GetDocumentUltimateShipToContact($ultimateshiptocontactpersonname, $ultimateshiptocontactdepartmentname, $ultimateshiptocontactphoneno, $ultimateshiptocontactfaxno, $ultimateshiptocontactemailaddr);
        $this->assertEquals("", $ultimateshiptocontactpersonname);
        $this->assertEquals("", $ultimateshiptocontactdepartmentname);
        $this->assertEquals("", $ultimateshiptocontactphoneno);
        $this->assertEquals("", $ultimateshiptocontactfaxno);
        $this->assertEquals("", $ultimateshiptocontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipFrom
     */
    public function testDocumentShipFromGeneral()
    {
        self::$document->GetDocumentShipFrom($shipfromname, $shipfromids, $shipfromdescription);
        $this->assertEquals("", $shipfromname);
        $this->assertIsArray($shipfromids);
        $this->assertEmpty($shipfromids);
        $this->assertEquals("", $shipfromdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipFromGlobalId
     */
    public function testDocumentShipFromGlobalId()
    {
        self::$document->GetDocumentShipFromGlobalId($shipfromglobalids);
        $this->assertIsArray($shipfromglobalids);
        $this->assertEmpty($shipfromglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipFromTaxRegistration
     */
    public function testDocumentShipFromTaxRegistration()
    {
        self::$document->GetDocumentShipFromTaxRegistration($shipfromtaxreg);
        $this->assertIsArray($shipfromtaxreg);
        $this->assertEmpty($shipfromtaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipFromAddress
     */
    public function testDocumentShipFromAddress()
    {
        self::$document->GetDocumentShipFromAddress($shipfromlineone, $shipfromlinetwo, $shipfromlinethree, $shipfrompostcode, $shipfromcity, $shipfromcountry, $shipfromsubdivision);
        $this->assertEquals("", $shipfromlineone);
        $this->assertEquals("", $shipfromlinetwo);
        $this->assertEquals("", $shipfromlinethree);
        $this->assertEquals("", $shipfrompostcode);
        $this->assertEquals("", $shipfromcity);
        $this->assertEquals("", $shipfromcountry);
        $this->assertIsArray($shipfromsubdivision);
        $this->assertEmpty($shipfromsubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipFromLegalOrganisation
     */
    public function testDocumentShipFromLegalOrganization()
    {
        self::$document->GetDocumentShipFromLegalOrganisation($shipfromlegalorgid, $shipfromlegalorgtype, $shipfromlegalorgname);
        $this->assertEquals("", $shipfromlegalorgid);
        $this->assertEquals("", $shipfromlegalorgtype);
        $this->assertEquals("", $shipfromlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentShipFromContact
     */
    public function testDocumentShipFromContact()
    {
        self::$document->GetDocumentShipFromContact($shipfromcontactpersonname, $shipfromcontactdepartmentname, $shipfromcontactphoneno, $shipfromcontactfaxno, $shipfromcontactemailaddr);
        $this->assertEquals("", $shipfromcontactpersonname);
        $this->assertEquals("", $shipfromcontactdepartmentname);
        $this->assertEquals("", $shipfromcontactphoneno);
        $this->assertEquals("", $shipfromcontactfaxno);
        $this->assertEquals("", $shipfromcontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoicer
     */
    public function testDocumentInvoicerGeneral()
    {
        self::$document->GetDocumentInvoicer($invoicername, $invoicerids, $invoicerdescription);
        $this->assertEquals("", $invoicername);
        $this->assertIsArray($invoicerids);
        $this->assertEmpty($invoicerids);
        $this->assertEquals("", $invoicerdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoicerGlobalId
     */
    public function testDocumentInvoicerGlobalId()
    {
        self::$document->GetDocumentInvoicerGlobalId($invoicerglobalids);
        $this->assertIsArray($invoicerglobalids);
        $this->assertEmpty($invoicerglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoicerTaxRegistration
     */
    public function testDocumentInvoicerTaxRegistration()
    {
        self::$document->GetDocumentInvoicerTaxRegistration($invoicertaxreg);
        $this->assertIsArray($invoicertaxreg);
        $this->assertEmpty($invoicertaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoicerAddress
     */
    public function testDocumentInvoicerAddress()
    {
        self::$document->GetDocumentInvoicerAddress($invoicerlineone, $invoicerlinetwo, $invoicerlinethree, $invoicerpostcode, $invoicercity, $invoicercountry, $invoicersubdivision);
        $this->assertEquals("", $invoicerlineone);
        $this->assertEquals("", $invoicerlinetwo);
        $this->assertEquals("", $invoicerlinethree);
        $this->assertEquals("", $invoicerpostcode);
        $this->assertEquals("", $invoicercity);
        $this->assertEquals("", $invoicercountry);
        $this->assertIsArray($invoicersubdivision);
        $this->assertEmpty($invoicersubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoicerLegalOrganisation
     */
    public function testDocumentInvoicerLegalOrganization()
    {
        self::$document->GetDocumentInvoicerLegalOrganisation($invoicerlegalorgid, $invoicerlegalorgtype, $invoicerlegalorgname);
        $this->assertEquals("", $invoicerlegalorgid);
        $this->assertEquals("", $invoicerlegalorgtype);
        $this->assertEquals("", $invoicerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoicerContact
     */
    public function testDocumentInvoicerContact()
    {
        self::$document->GetDocumentInvoicerContact($invoicercontactpersonname, $invoicercontactdepartmentname, $invoicercontactphoneno, $invoicercontactfaxno, $invoicercontactemailaddr);
        $this->assertEquals("", $invoicercontactpersonname);
        $this->assertEquals("", $invoicercontactdepartmentname);
        $this->assertEquals("", $invoicercontactphoneno);
        $this->assertEquals("", $invoicercontactfaxno);
        $this->assertEquals("", $invoicercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoicee
     */
    public function testDocumentInvoiceeGeneral()
    {
        self::$document->GetDocumentInvoicee($invoiceename, $invoiceeids, $invoiceedescription);
        $this->assertEquals("", $invoiceename);
        $this->assertIsArray($invoiceeids);
        $this->assertEmpty($invoiceeids);
        $this->assertEquals("", $invoiceedescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoiceeGlobalId
     */
    public function testDocumentInvoiceeGlobalId()
    {
        self::$document->GetDocumentInvoiceeGlobalId($invoiceeglobalids);
        $this->assertIsArray($invoiceeglobalids);
        $this->assertEmpty($invoiceeglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoiceeTaxRegistration
     */
    public function testDocumentInvoiceeTaxRegistration()
    {
        self::$document->GetDocumentInvoiceeTaxRegistration($invoiceetaxreg);
        $this->assertIsArray($invoiceetaxreg);
        $this->assertEmpty($invoiceetaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoiceeAddress
     */
    public function testDocumentInvoiceeAddress()
    {
        self::$document->GetDocumentInvoiceeAddress($invoiceelineone, $invoiceelinetwo, $invoiceelinethree, $invoiceepostcode, $invoiceecity, $invoiceecountry, $invoiceesubdivision);
        $this->assertEquals("", $invoiceelineone);
        $this->assertEquals("", $invoiceelinetwo);
        $this->assertEquals("", $invoiceelinethree);
        $this->assertEquals("", $invoiceepostcode);
        $this->assertEquals("", $invoiceecity);
        $this->assertEquals("", $invoiceecountry);
        $this->assertIsArray($invoiceesubdivision);
        $this->assertEmpty($invoiceesubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoiceeLegalOrganisation
     */
    public function testDocumentInvoiceeLegalOrganization()
    {
        self::$document->GetDocumentInvoiceeLegalOrganisation($invoiceelegalorgid, $invoiceelegalorgtype, $invoiceelegalorgname);
        $this->assertEquals("", $invoiceelegalorgid);
        $this->assertEquals("", $invoiceelegalorgtype);
        $this->assertEquals("", $invoiceelegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoiceeContact
     */
    public function testDocumentInvoiceeContact()
    {
        self::$document->GetDocumentInvoiceeContact($invoiceecontactpersonname, $invoiceecontactdepartmentname, $invoiceecontactphoneno, $invoiceecontactfaxno, $invoiceecontactemailaddr);
        $this->assertEquals("", $invoiceecontactpersonname);
        $this->assertEquals("", $invoiceecontactdepartmentname);
        $this->assertEquals("", $invoiceecontactphoneno);
        $this->assertEquals("", $invoiceecontactfaxno);
        $this->assertEquals("", $invoiceecontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPayee
     */
    public function testDocumentPayeeGeneral()
    {
        self::$document->GetDocumentPayee($payeename, $payeeids, $payeedescription);
        $this->assertEquals("", $payeename);
        $this->assertIsArray($payeeids);
        $this->assertEmpty($payeeids);
        $this->assertEquals("", $payeedescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPayeeGlobalId
     */
    public function testDocumentPayeeGlobalId()
    {
        self::$document->GetDocumentPayeeGlobalId($payeeglobalids);
        $this->assertIsArray($payeeglobalids);
        $this->assertEmpty($payeeglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPayeeTaxRegistration
     */
    public function testDocumentPayeeTaxRegistration()
    {
        self::$document->GetDocumentPayeeTaxRegistration($payeetaxreg);
        $this->assertIsArray($payeetaxreg);
        $this->assertEmpty($payeetaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPayeeAddress
     */
    public function testDocumentPayeeAddress()
    {
        self::$document->GetDocumentPayeeAddress($payeelineone, $payeelinetwo, $payeelinethree, $payeepostcode, $payeecity, $payeecountry, $payeesubdivision);
        $this->assertEquals("", $payeelineone);
        $this->assertEquals("", $payeelinetwo);
        $this->assertEquals("", $payeelinethree);
        $this->assertEquals("", $payeepostcode);
        $this->assertEquals("", $payeecity);
        $this->assertEquals("", $payeecountry);
        $this->assertIsArray($payeesubdivision);
        $this->assertEmpty($payeesubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPayeeLegalOrganisation
     */
    public function testDocumentPayeeLegalOrganization()
    {
        self::$document->GetDocumentPayeeLegalOrganisation($payeelegalorgid, $payeelegalorgtype, $payeelegalorgname);
        $this->assertEquals("", $payeelegalorgid);
        $this->assertEquals("", $payeelegalorgtype);
        $this->assertEquals("", $payeelegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPayeeContact
     */
    public function testDocumentPayeeContact()
    {
        self::$document->GetDocumentPayeeContact($payeecontactpersonname, $payeecontactdepartmentname, $payeecontactphoneno, $payeecontactfaxno, $payeecontactemailaddr);
        $this->assertEquals("", $payeecontactpersonname);
        $this->assertEquals("", $payeecontactdepartmentname);
        $this->assertEquals("", $payeecontactphoneno);
        $this->assertEquals("", $payeecontactfaxno);
        $this->assertEquals("", $payeecontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentProductEndUser
     */
    public function testDocumentProductEndUserGeneral()
    {
        self::$document->GetDocumentProductEndUser($producendusername, $producenduserids, $producenduserdescription);
        $this->assertEquals("", $producendusername);
        $this->assertIsArray($producenduserids);
        $this->assertArrayNotHasKey(0, $producenduserids);
        $this->assertArrayNotHasKey(1, $producenduserids);
        $this->assertEquals("", $producenduserdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentProductEndUserGlobalId
     */
    public function testDocumentProductEndUserGlobalId()
    {
        self::$document->GetDocumentProductEndUserGlobalId($producenduserglobalids);
        $this->assertIsArray($producenduserglobalids);
        $this->assertArrayNotHasKey("0088", $producenduserglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentProductEndUserTaxRegistration
     */
    public function testDocumentProductEndUserTaxRegistration()
    {
        self::$document->GetDocumentProductEndUserTaxRegistration($producendusertaxreg);
        $this->assertIsArray($producendusertaxreg);
        $this->assertArrayNotHasKey("VA", $producendusertaxreg);
        $this->assertArrayNotHasKey("FC", $producendusertaxreg);
        $this->assertArrayNotHasKey(0, $producendusertaxreg);
        $this->assertArrayNotHasKey(1, $producendusertaxreg);
        $this->assertArrayNotHasKey("ZZ", $producendusertaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentProductEndUserAddress
     */
    public function testDocumentProductEndUserAddress()
    {
        self::$document->GetDocumentProductEndUserAddress($producenduserlineone, $producenduserlinetwo, $producenduserlinethree, $producenduserpostcode, $producendusercity, $producendusercountry, $producendusersubdivision);
        $this->assertEquals("", $producenduserlineone);
        $this->assertEquals("", $producenduserlinetwo);
        $this->assertEquals("", $producenduserlinethree);
        $this->assertEquals("", $producenduserpostcode);
        $this->assertEquals("", $producendusercity);
        $this->assertEquals("", $producendusercountry);
        $this->assertIsArray($producendusersubdivision);
        $this->assertEmpty($producendusersubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentProductEndUserLegalOrganisation
     */
    public function testDocumentProductEndUserLegalOrganization()
    {
        self::$document->GetDocumentProductEndUserLegalOrganisation($producenduserlegalorgid, $producenduserlegalorgtype, $producenduserlegalorgname);
        $this->assertEquals("", $producenduserlegalorgid);
        $this->assertEquals("", $producenduserlegalorgtype);
        $this->assertEquals("", $producenduserlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentProductEndUserContact
     */
    public function testDocumentProductEndUserContact()
    {
        self::$document->GetDocumentProductEndUserContact($producendusercontactpersonname, $producendusercontactdepartmentname, $producendusercontactphoneno, $producendusercontactfaxno, $producendusercontactemailaddr);
        $this->assertEquals("", $producendusercontactpersonname);
        $this->assertEquals("", $producendusercontactdepartmentname);
        $this->assertEquals("", $producendusercontactphoneno);
        $this->assertEquals("", $producendusercontactfaxno);
        $this->assertEquals("", $producendusercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerOrderReferencedDocument
     */
    public function testDocumentSellerOrderReferencedDocument()
    {
        self::$document->GetDocumentSellerOrderReferencedDocument($sellerorderrefdocid, $sellerorderrefdocdate);
        $this->assertEquals("", $sellerorderrefdocid);
        $this->assertNull($sellerorderrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyerOrderReferencedDocument
     */
    public function testDocumentBuyerOrderReferencedDocument()
    {
        self::$document->GetDocumentBuyerOrderReferencedDocument($buyerorderrefdocid, $buyerorderrefdocdate);
        $this->assertEquals("", $buyerorderrefdocid);
        $this->assertNull($buyerorderrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentContractReferencedDocument
     */
    public function testDocumentContractReferencedDocument()
    {
        self::$document->GetDocumentContractReferencedDocument($contractrefdocid, $contractrefdocdate);
        $this->assertEquals("", $contractrefdocid);
        $this->assertNull($contractrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentAdditionalReferencedDocuments
     */
    public function testDocumentAdditionalReferencedDocuments()
    {
        self::$document->GetDocumentAdditionalReferencedDocuments($additionalrefdocs);
        $this->assertIsArray($additionalrefdocs);
        $this->assertEmpty($additionalrefdocs);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentProcuringProject
     */
    public function testDocumentProcuringProject()
    {
        self::$document->GetDocumentProcuringProject($projectid, $projectname);
        $this->assertEquals("", $projectid);
        $this->assertEquals("", $projectname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSupplyChainEvent
     */
    public function testDocumentSupplyChainEvent()
    {
        self::$document->GetDocumentSupplyChainEvent($supplychainevent);
        $this->assertNotNull($supplychainevent);
        $this->assertInstanceOf("DateTime", $supplychainevent);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180305'))->format('Ymd'), $supplychainevent->format('Ymd'));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentDespatchAdviceReferencedDocument
     */
    public function testDocumentDespatchAdviceReferencedDocument()
    {
        self::$document->GetDocumentDespatchAdviceReferencedDocument($despatchdocid, $despatchdoclineid, $despatchdocdate);
        $this->assertEquals("", $despatchdocid);
        $this->assertEquals("", $despatchdoclineid);
        $this->assertNull($despatchdocdate);
        $this->assertNotInstanceOf("DateTime", $despatchdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentReceivingAdviceReferencedDocument
     */
    public function testDocumentReceivingAdviceReferencedDocument()
    {
        self::$document->GetDocumentReceivingAdviceReferencedDocument($recadvid, $recadvlineid, $recadvdate);
        $this->assertEquals("", $recadvid);
        $this->assertEquals("", $recadvlineid);
        $this->assertNull($recadvdate);
        $this->assertNotInstanceOf("DateTime", $recadvdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentDeliveryNoteReferencedDocument
     */
    public function testDocumentDeliveryNoteReferencedDocument()
    {
        self::$document->GetDocumentDeliveryNoteReferencedDocument($deliverynoterefdocid, $deliverynoterefdocdate);
        $this->assertEquals("", $deliverynoterefdocid);
        $this->assertNull($deliverynoterefdocdate);
        $this->assertNotInstanceOf("DateTime", $deliverynoterefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBillingPeriod
     */
    public function testDocumentBillingPeriod()
    {
        self::$document->GetDocumentBillingPeriod($docbillingperiodstart, $docbillingperiodend, $docbillingperioddescription);
        $this->assertNull($docbillingperiodstart);
        $this->assertNotInstanceOf("DateTime", $docbillingperiodstart);
        $this->assertNull($docbillingperiodend);
        $this->assertNotInstanceOf("DateTime", $docbillingperiodend);
        $this->assertEquals("", $docbillingperioddescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentAllowanceCharges
     */
    public function testDocumentAllowanceCharges()
    {
        self::$document->GetDocumentAllowanceCharges($docallowancecharge);
        $this->assertIsArray($docallowancecharge);
        $this->assertEmpty($docallowancecharge);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPaymentTerms
     */
    public function testDocumentPaymentTerms()
    {
        self::$document->GetDocumentPaymentTerms($docpaymentterms);
        $this->assertIsArray($docpaymentterms);
        $this->assertNotEmpty($docpaymentterms);
        $this->assertArrayHasKey(0, $docpaymentterms);
        $this->assertIsArray($docpaymentterms[0]);
        $this->assertArrayHasKey("description", $docpaymentterms[0]);
        $this->assertArrayHasKey("duedate", $docpaymentterms[0]);
        $this->assertArrayHasKey("directdebitmandateid", $docpaymentterms[0]);
        $this->assertArrayHasKey("partialpaymentamount", $docpaymentterms[0]);
        $this->assertEquals("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018", $docpaymentterms[0]["description"]);
        $this->assertNull($docpaymentterms[0]["duedate"]);
        $this->assertNotInstanceOf("DateTime", $docpaymentterms[0]["duedate"]);
        $this->assertEquals("", $docpaymentterms[0]["directdebitmandateid"]);
        $this->assertEquals(0.0, $docpaymentterms[0]["partialpaymentamount"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentDeliveryTerms
     */
    public function testDocumentDeliveryTerms()
    {
        self::$document->GetDocumentDeliveryTerms($devtermcode);
        $this->assertEquals("", $devtermcode);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentAdditionalReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentAdditionalReferencedDocument
     */
    public function testDocumentAdditionalReferencedDocumentLoop()
    {
        $this->assertFalse(self::$document->FirstDocumentAdditionalReferencedDocument());
        $this->assertFalse(self::$document->NextDocumentAdditionalReferencedDocument());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentUltimateCustomerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentUltimateCustomerOrderReferencedDocument
     */
    public function testDocumentUltimateCustomerOrderReferencedDocumentLoop()
    {
        $this->assertFalse(self::$document->FirstDocumentUltimateCustomerOrderReferencedDocument());
        $this->assertFalse(self::$document->NextDocumentUltimateCustomerOrderReferencedDocument());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstGetDocumentPaymentMeans
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextGetDocumentPaymentMeans
     */
    public function testDocumentPaymentMeansLoop()
    {
        $this->assertTrue(self::$document->FirstGetDocumentPaymentMeans());
        $this->assertFalse(self::$document->NextGetDocumentPaymentMeans());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstGetDocumentPaymentMeans
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPaymentMeans
     */
    public function testGetDocumentPaymentMeans()
    {
        $this->assertTrue(self::$document->FirstGetDocumentPaymentMeans());
        self::$document->GetDocumentPaymentMeans($typeCode, $information, $cardType, $cardId, $cardHolderName, $buyerIban, $payeeIban, $payeeAccountName, $payeePropId, $payeeBic);
        $this->assertEquals("58", $typeCode);
        $this->assertEquals("", $information);
        $this->assertEquals("", $cardType);
        $this->assertEquals("", $cardId);
        $this->assertEquals("", $cardHolderName);
        $this->assertEquals("", $buyerIban);
        $this->assertEquals("DE5467894567876500", $payeeIban);
        $this->assertEquals("", $payeeAccountName);
        $this->assertEquals("", $payeePropId);
        $this->assertEquals("", $payeeBic);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentTax
     */
    public function testDocumentTaxLoop()
    {
        $this->assertTrue(self::$document->FirstDocumentTax());
        $this->assertTrue(self::$document->NextDocumentTax());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentTax
     */
    public function testDocumentTax()
    {
        $this->assertTrue(self::$document->FirstDocumentTax());
        self::$document->GetDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(275.0, $basisAmount);
        $this->assertEquals(19.25, $calculatedAmount);
        $this->assertEquals(7.0, $rateApplicablePercent);

        $this->assertTrue(self::$document->NextDocumentTax());
        self::$document->GetDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(198.0, $basisAmount);
        $this->assertEquals(37.62, $calculatedAmount);
        $this->assertEquals(19.0, $rateApplicablePercent);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentAllowanceCharge
     */
    public function testtDocumentAllowanceChargeLoop()
    {
        $this->assertFalse(self::$document->FirstDocumentAllowanceCharge());
        $this->assertFalse(self::$document->NextDocumentAllowanceCharge());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentLogisticsServiceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentLogisticsServiceCharge
     */
    public function testtDocumentLogisticsServiceChargeLoop()
    {
        $this->assertFalse(self::$document->FirstDocumentLogisticsServiceCharge());
        $this->assertFalse(self::$document->NextDocumentLogisticsServiceCharge());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPaymentTerms
     */
    public function testtDocumentPaymentTermsLoop()
    {
        $this->assertTrue(self::$document->FirstDocumentPaymentTerms());
        $this->assertFalse(self::$document->NextDocumentPaymentTerms());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPaymentTerm
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDiscountTermsFromPaymentTerm
     */
    public function testtDocumentPaymentTerms()
    {
        $this->assertTrue(self::$document->FirstDocumentPaymentTerms());
        self::$document->GetDocumentPaymentTerm($termdescription, $termduedate, $termmandate);
        self::$document->GetDiscountTermsFromPaymentTerm($dispercent, $discbasedatetime, $discmeasureval, $discmeasureunit, $discbaseamount, $discamount);

        $this->assertEquals("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018", $termdescription);
        $this->assertNull($termduedate);
        $this->assertEquals("", $termmandate);
        $this->assertEquals(0, $dispercent);
        $this->assertNull($discbasedatetime);
        $this->assertEquals(0, $discmeasureval);
        $this->assertEquals("", $discmeasureunit);
        $this->assertEquals(0, $discbaseamount);
        $this->assertEquals(0, $discamount);

        $this->assertFalse(self::$document->NextDocumentPaymentTerms());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPosition
     */
    public function testDocumentPositionLoop()
    {
        $this->assertTrue(self::$document->FirstDocumentPosition(), "has a first position");
        $this->assertTrue(self::$document->NextDocumentPosition(), "has a second position");
        $this->assertFalse(self::$document->NextDocumentPosition(), "has no third position");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionGenerals
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionProductDetails
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionBuyerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionContractReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionGrossPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionNetPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionNetPriceTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionQuantity
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionDespatchAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionReceivingAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionDeliveryNoteReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionBillingPeriod
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionLineSummation
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionSupplyChainEvent
     */
    public function testDocumentPositionFirst()
    {
        $this->assertTrue(self::$document->FirstDocumentPosition());

        self::$document->GetDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("1", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->GetDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("Trennblätter A4", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("TB100A4", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0160", $prodglobalidtype);
        $this->assertEquals("4012345001235", $prodglobalid);

        self::$document->GetDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->GetDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->GetDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(9.90, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(9.90, $netpriceamount);
        $this->assertEquals(0.0, $netpricebasisquantity);
        $this->assertEquals("", $netpricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPriceTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("", $categoryCode);
        $this->assertEquals("", $typeCode);
        $this->assertEquals(0.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->GetDocumentPositionQuantity($billedquantity, $billedquantityunitcode, $chargeFreeQuantity, $chargeFreeQuantityunitcode, $packageQuantity, $packageQuantityunitcode);
        $this->assertEquals(20.0, $billedquantity);
        $this->assertEquals("H87", $billedquantityunitcode);
        $this->assertEquals(0.0, $chargeFreeQuantity);
        $this->assertEquals("", $chargeFreeQuantityunitcode);
        $this->assertEquals(0.0, $packageQuantity);
        $this->assertEquals("", $packageQuantityunitcode);

        self::$document->GetDocumentPositionDespatchAdviceReferencedDocument($docposdespadvid, $docposdespadvlineid, $docposdespadvdatetime);
        $this->assertEquals("", $docposdespadvid);
        $this->assertEquals("", $docposdespadvlineid);
        $this->assertNull($docposdespadvdatetime);

        self::$document->GetDocumentPositionReceivingAdviceReferencedDocument($docposrecadvid, $docposrecadvlineid, $docposrecadvdatetime);
        $this->assertEquals("", $docposrecadvid);
        $this->assertEquals("", $docposrecadvlineid);
        $this->assertNull($docposrecadvdatetime);

        self::$document->GetDocumentPositionDeliveryNoteReferencedDocument($docposdelnoteid, $docposdelnotelineid, $docposdelnotedatetime);
        $this->assertEquals("", $docposdelnoteid);
        $this->assertEquals("", $docposdelnotelineid);
        $this->assertNull($docposdelnotedatetime);

        self::$document->GetDocumentPositionBillingPeriod($docposstartdate, $docpostenddate);
        $this->assertNull($docposstartdate);
        $this->assertNull($docpostenddate);

        $this->assertFalse(self::$document->FirstDocumentPositionNote());
        $this->assertFalse(self::$document->NextDocumentPositionNote());

        $this->assertFalse(self::$document->FirstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->NextDocumentPositionGrossPriceAllowanceCharge());

        $this->assertTrue(self::$document->FirstDocumentPositionTax());
        $this->assertFalse(self::$document->NextDocumentPositionTax());

        self::$document->FirstDocumentPositionTax();
        self::$document->GetDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(19.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->GetDocumentPositionLineSummation($lineTotalAmount, $totalAllowanceChargeAmount);
        $this->assertEquals(198.0, $lineTotalAmount);
        $this->assertEquals(0.0, $totalAllowanceChargeAmount);

        self::$document->GetDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionGenerals
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionProductDetails
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionBuyerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionContractReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionGrossPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionNetPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionNetPriceTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionQuantity
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionDespatchAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionReceivingAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionDeliveryNoteReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionBillingPeriod
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionLineSummation
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionSupplyChainEvent
     */
    public function testDocumentPositionSecond()
    {
        $this->assertTrue(self::$document->NextDocumentPosition());

        self::$document->GetDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("2", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->GetDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("Joghurt Banane", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("ARNR2", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0160", $prodglobalidtype);
        $this->assertEquals("4000050986428", $prodglobalid);

        self::$document->GetDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->GetDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->GetDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(5.50, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(5.50, $netpriceamount);
        $this->assertEquals(0.0, $netpricebasisquantity);
        $this->assertEquals("", $netpricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPriceTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("", $categoryCode);
        $this->assertEquals("", $typeCode);
        $this->assertEquals(0.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->GetDocumentPositionQuantity($billedquantity, $billedquantityunitcode, $chargeFreeQuantity, $chargeFreeQuantityunitcode, $packageQuantity, $packageQuantityunitcode);
        $this->assertEquals(50.0, $billedquantity);
        $this->assertEquals("H87", $billedquantityunitcode);
        $this->assertEquals(0.0, $chargeFreeQuantity);
        $this->assertEquals("", $chargeFreeQuantityunitcode);
        $this->assertEquals(0.0, $packageQuantity);
        $this->assertEquals("", $packageQuantityunitcode);

        self::$document->GetDocumentPositionDespatchAdviceReferencedDocument($docposdespadvid, $docposdespadvlineid, $docposdespadvdatetime);
        $this->assertEquals("", $docposdespadvid);
        $this->assertEquals("", $docposdespadvlineid);
        $this->assertNull($docposdespadvdatetime);

        self::$document->GetDocumentPositionReceivingAdviceReferencedDocument($docposrecadvid, $docposrecadvlineid, $docposrecadvdatetime);
        $this->assertEquals("", $docposrecadvid);
        $this->assertEquals("", $docposrecadvlineid);
        $this->assertNull($docposrecadvdatetime);

        self::$document->GetDocumentPositionDeliveryNoteReferencedDocument($docposdelnoteid, $docposdelnotelineid, $docposdelnotedatetime);
        $this->assertEquals("", $docposdelnoteid);
        $this->assertEquals("", $docposdelnotelineid);
        $this->assertNull($docposdelnotedatetime);

        self::$document->GetDocumentPositionBillingPeriod($docposstartdate, $docpostenddate);
        $this->assertNull($docposstartdate);
        $this->assertNull($docpostenddate);

        $this->assertFalse(self::$document->FirstDocumentPositionNote());
        $this->assertFalse(self::$document->NextDocumentPositionNote());

        $this->assertFalse(self::$document->FirstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->NextDocumentPositionGrossPriceAllowanceCharge());

        $this->assertTrue(self::$document->FirstDocumentPositionTax());
        $this->assertFalse(self::$document->NextDocumentPositionTax());

        self::$document->FirstDocumentPositionTax();
        self::$document->GetDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(7.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->GetDocumentPositionLineSummation($lineTotalAmount, $totalAllowanceChargeAmount);
        $this->assertEquals(275.0, $lineTotalAmount);
        $this->assertEquals(0.0, $totalAllowanceChargeAmount);

        self::$document->GetDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPositionAdditionalReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPositionAdditionalReferencedDocument
     */
    public function testDocumentPositionAdditionalReferencedDocument()
    {
        $this->assertFalse(self::$document->FirstDocumentPositionAdditionalReferencedDocument());
        $this->assertFalse(self::$document->NextDocumentPositionAdditionalReferencedDocument());
    }
}
