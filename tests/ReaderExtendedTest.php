<?php

namespace horstoeko\zugferd\tests;

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentReader;

class ReaderExtendedTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::ReadAndGuessFromFile(dirname(__FILE__) . "/data/extended_invoice.xml");
    }

    public function testDocumentProfile()
    {
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->profile);
        $this->assertEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->profile);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInformation
     */
    public function testDocumentGenerals()
    {
        self::$document->GetDocumentInformation($documentno, $documenttypecode, $documentdate, $duedate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('KR87654321012', $documentno);
        $this->assertEquals('380', $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20181006'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertNull($duedate);
        $this->assertEquals("EUR", $invoiceCurrency);
        $this->assertEquals("", $taxCurrency);
        $this->assertEquals("KOSTENRECHNUNG", $documentname);
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
        $this->assertEquals(3, count($notes));
        $this->assertArrayHasKey(0, $notes);
        $this->assertArrayHasKey(1, $notes);
        $this->assertArrayHasKey(2, $notes);
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
        $this->assertIsArray($notes[2]);
        $this->assertNotEmpty($notes[2]);
        $this->assertArrayHasKey("content", $notes[2]);
        $this->assertArrayHasKey("subjectcode", $notes[2]);
        $this->assertArrayHasKey("contentcode", $notes[2]);
        $this->assertEquals("ST3", $notes[0]["contentcode"]);
        $this->assertEquals("AAK", $notes[0]["subjectcode"]);
        $this->assertEquals("Es bestehen Rabatt- oder Bonusvereinbarungen.", $notes[0]["content"]);
        $this->assertEquals("EEV", $notes[1]["contentcode"]);
        $this->assertEquals("AAJ", $notes[1]["subjectcode"]);
        $this->assertEquals("Der Verkäufer bleibt Eigentümer der Waren bis zur vollständigen Erfüllung der Kaufpreisforderung.", $notes[1]["content"]);
        $this->assertEquals("", $notes[2]["contentcode"]);
        $this->assertEquals("REG", $notes[2]["subjectcode"]);
        $this->assertStringContainsString("MUSTERLIEFERANT GMBH", $notes[2]["content"]);
        $this->assertStringContainsString("BAHNHOFSTRASSE 99", $notes[2]["content"]);
        $this->assertStringContainsString("99199 MUSTERHAUSEN", $notes[2]["content"]);
        $this->assertStringContainsString("Geschäftsführung:", $notes[2]["content"]);
        $this->assertStringContainsString("Max Mustermann", $notes[2]["content"]);
        $this->assertStringContainsString("USt-IdNr: DE123456789", $notes[2]["content"]);
        $this->assertStringContainsString("Telefon: +49 932 431 0", $notes[2]["content"]);
        $this->assertStringContainsString("www.musterlieferant.de", $notes[2]["content"]);
        $this->assertStringContainsString("HRB Nr. 372876", $notes[2]["content"]);
        $this->assertStringContainsString("Amtsgericht Musterstadt", $notes[2]["content"]);
        $this->assertStringContainsString("GLN 4304171000002", $notes[2]["content"]);
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
        $this->assertTrue($istest);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSummation
     */
    public function testDocumentSummation()
    {
        self::$document->GetDocumentSummation($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);
        $this->assertEquals(480.22, $grandTotalAmount);
        $this->assertEquals(480.22, $duePayableAmount);
        $this->assertEquals(410.10, $lineTotalAmount);
        $this->assertEquals(15.00, $chargeTotalAmount);
        $this->assertEquals(21.55, $allowanceTotalAmount);
        $this->assertEquals(403.55, $taxBasisTotalAmount);
        $this->assertEquals(76.67, $taxTotalAmount);
        $this->assertEquals(0.00, $roundingAmount);
        $this->assertEquals(0.00, $totalPrepaidAmount);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSeller
     */
    public function testDocumentSellerGeneral()
    {
        self::$document->GetDocumentSeller($sellername, $sellerids, $sellerdescription);
        $this->assertEquals("MUSTERLIEFERANT GMBH", $sellername);
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
        $this->assertEquals("4333741000005", $sellerglobalids["0088"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerTaxRegistration
     */
    public function testDocumentSellerTaxRegistration()
    {
        self::$document->GetDocumentSellerTaxRegistration($sellertaxreg);
        $this->assertIsArray($sellertaxreg);
        $this->assertArrayNotHasKey("VA", $sellertaxreg);
        $this->assertArrayHasKey("FC", $sellertaxreg);
        $this->assertArrayNotHasKey(0, $sellertaxreg);
        $this->assertArrayNotHasKey(1, $sellertaxreg);
        $this->assertArrayNotHasKey("ZZ", $sellertaxreg);
        $this->assertEquals("201/113/40209", $sellertaxreg["FC"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentSellerAddress
     */
    public function testDocumentSellerAddress()
    {
        self::$document->GetDocumentSellerAddress($sellerlineone, $sellerlinetwo, $sellerlinethree, $sellerpostcode, $sellercity, $sellercountry, $sellersubdivision);
        $this->assertEquals("BAHNHOFSTRASSE 99", $sellerlineone);
        $this->assertEquals("", $sellerlinetwo);
        $this->assertEquals("", $sellerlinethree);
        $this->assertEquals("99199", $sellerpostcode);
        $this->assertEquals("MUSTERHAUSEN", $sellercity);
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
        $this->assertEquals("+49 932 431 500", $sellercontactphoneno);
        $this->assertEquals("", $sellercontactfaxno);
        $this->assertEquals("max.mustermann@musterlieferant.de", $sellercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyer
     */
    public function testDocumentBuyerGeneral()
    {
        self::$document->GetDocumentBuyer($buyername, $buyerids, $buyerdescription);
        $this->assertEquals("MUSTER-KUNDE GMBH", $buyername);
        $this->assertIsArray($buyerids);
        $this->assertArrayHasKey(0, $buyerids);
        $this->assertArrayNotHasKey(1, $buyerids);
        $this->assertEquals("339420", $buyerids[0]);
        $this->assertEquals("", $buyerdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentBuyerGlobalId
     */
    public function testDocumentBuyerGlobalId()
    {
        self::$document->GetDocumentBuyerGlobalId($buyerglobalids);
        $this->assertIsArray($buyerglobalids);
        $this->assertArrayHasKey("0088", $buyerglobalids);
        $this->assertEquals("4304171000002", $buyerglobalids["0088"]);
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
        $this->assertEquals("KUNDENWEG 88", $buyerlineone);
        $this->assertEquals("", $buyerlinetwo);
        $this->assertEquals("", $buyerlinethree);
        $this->assertEquals("40235", $buyerpostcode);
        $this->assertEquals("DUESSELDORF", $buyercity);
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
        $this->assertEquals("MUSTER-MARKT", $shiptoname);
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
        $this->arrayHasKey("0088", $shiptoglobalids);
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
        $this->assertEquals("HAUPTSTRASSE 44", $shiptolineone);
        $this->assertEquals("", $shiptolinetwo);
        $this->assertEquals("", $shiptolinethree);
        $this->assertEquals("31157", $shiptopostcode);
        $this->assertEquals("SARSTEDT", $shiptocity);
        $this->assertEquals("DE", $shiptocountry);
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
        $this->assertEquals("7322", $shiptocontactdepartmentname);
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
        $this->assertEquals("MUSTER-KUNDE GMBH", $invoiceename);
        $this->assertIsArray($invoiceeids);
        $this->assertNotEmpty($invoiceeids);
        $this->assertArrayHasKey(0, $invoiceeids);
        $this->assertEquals("", $invoiceedescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentInvoiceeGlobalId
     */
    public function testDocumentInvoiceeGlobalId()
    {
        self::$document->GetDocumentInvoiceeGlobalId($invoiceeglobalids);
        $this->assertIsArray($invoiceeglobalids);
        $this->assertNotEmpty($invoiceeglobalids);
        $this->assertArrayHasKey("0088", $invoiceeglobalids);
        $this->assertEquals("4304171000002", $invoiceeglobalids["0088"]);
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
        $this->assertEquals("KUNDENWEG 88", $invoiceelineone);
        $this->assertEquals("", $invoiceelinetwo);
        $this->assertEquals("", $invoiceelinethree);
        $this->assertEquals("40235", $invoiceepostcode);
        $this->assertEquals("DUESSELDORF", $invoiceecity);
        $this->assertEquals("DE", $invoiceecountry);
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
        $this->assertNotEmpty($additionalrefdocs);
        $this->assertArrayHasKey(0, $additionalrefdocs);
        $this->assertIsArray($additionalrefdocs[0]);
        $this->assertArrayHasKey("IssuerAssignedID", $additionalrefdocs[0]);
        $this->assertArrayHasKey("TypeCode", $additionalrefdocs[0]);
        $this->assertEquals("A777123", $additionalrefdocs[0]["IssuerAssignedID"]);
        $this->assertEquals("130", $additionalrefdocs[0]["TypeCode"]);
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
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180930'))->format('Ymd'), $supplychainevent->format('Ymd'));
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
        $this->assertEquals("L87654321012", $deliverynoterefdocid);
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
        $this->assertNotEmpty($docallowancecharge);
        $this->assertEquals(1, count($docallowancecharge));
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
        $this->assertEquals("Skontovereinbarung: 2% bei Zahlung innerhalb 10 Tagen nach Rechnungsdatum", $docpaymentterms[0]["description"]);
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
        $this->assertTrue(self::$document->FirstDocumentAdditionalReferencedDocument());
        $this->assertFalse(self::$document->NextDocumentAdditionalReferencedDocument());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentAdditionalReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentAdditionalReferencedDocument
     */
    public function testGetDocumentAdditionalReferencedDocument()
    {
        $this->assertTrue(self::$document->FirstDocumentAdditionalReferencedDocument());
        self::$document->GetDocumentAdditionalReferencedDocument($issuerassignedid, $typecode, $uriid, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->assertEquals("A777123", $issuerassignedid);
        $this->assertEquals("130", $typecode);
        $this->assertEquals("", $uriid);
        $this->assertIsArray($name);
        $this->assertEmpty($name);
        $this->assertEquals("", $reftypecode);
        $this->assertNull($issueddate);
        $this->assertEquals("", $binarydatafilename);
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
    public function testDocumentDocumentPaymentMeansLoop()
    {
        $this->assertFalse(self::$document->FirstGetDocumentPaymentMeans());
        $this->assertFalse(self::$document->NextGetDocumentPaymentMeans());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentTax
     */
    public function testDocumentTaxLoop()
    {
        $this->assertTrue(self::$document->FirstDocumentTax());
        $this->assertFalse(self::$document->NextDocumentTax());
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
        $this->assertEquals(403.55, $basisAmount);
        $this->assertEquals(76.67, $calculatedAmount);
        $this->assertEquals(19.0, $rateApplicablePercent);
        $this->assertEquals(-6.55, $allowanceChargeBasisAmount);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentAllowanceCharge
     */
    public function testtDocumentAllowanceChargeLoop()
    {
        $this->assertTrue(self::$document->FirstDocumentAllowanceCharge());
        $this->assertFalse(self::$document->NextDocumentAllowanceCharge());
    }


    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentAllowanceCharge
     */
    public function testtDocumentAllowanceCharge()
    {
        $this->assertTrue(self::$document->FirstDocumentAllowanceCharge());
        self::$document->GetDocumentAllowanceCharge($actualAmount, $isCharge, $taxCategoryCode, $taxTypeCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->assertEquals(21.55, $actualAmount);
        $this->assertFalse($isCharge);
        $this->assertEquals("S", $taxCategoryCode);
        $this->assertEquals("VAT", $taxTypeCode);
        $this->assertEquals(19.00, $rateApplicablePercent);
        $this->assertEquals(0, $sequence);
        $this->assertEquals(0, $calculationPercent);
        $this->assertEquals(410.10, $basisAmount);
        $this->assertEquals(0, $basisQuantity);
        $this->assertEquals("", $basisQuantityUnitCode);
        $this->assertEquals("", $reasonCode);
        $this->assertEquals("Sonderrabatt", $reason);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentLogisticsServiceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentLogisticsServiceCharge
     */
    public function testtDocumentLogisticsServiceChargeLoop()
    {
        $this->assertTrue(self::$document->FirstDocumentLogisticsServiceCharge());
        $this->assertFalse(self::$document->NextDocumentLogisticsServiceCharge());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentLogisticsServiceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentLogisticsServiceCharge
     */
    public function testGetDocumentLogisticsServiceCharge()
    {
        $this->assertTrue(self::$document->FirstDocumentLogisticsServiceCharge());
        self::$document->GetDocumentLogisticsServiceCharge($description, $appliedAmount, $taxTypeCodes, $taxCategpryCodes, $rateApplicablePercents);
        $this->assertEquals("Transportkosten: Frachbetrag", $description);
        $this->assertEquals(15.00, $appliedAmount);
        $this->assertIsArray($taxTypeCodes);
        $this->assertEquals(1, count($taxTypeCodes));
        $this->assertArrayHasKey(0, $taxTypeCodes);
        $this->assertEquals("VAT", $taxTypeCodes[0]);
        $this->assertIsArray($taxCategpryCodes);
        $this->assertEquals(1, count($taxCategpryCodes));
        $this->assertArrayHasKey(0, $taxCategpryCodes);
        $this->assertEquals("S", $taxCategpryCodes[0]);
        $this->assertIsArray($rateApplicablePercents);
        $this->assertEquals(1, count($rateApplicablePercents));
        $this->assertArrayHasKey(0, $rateApplicablePercents);
        $this->assertEquals(19.0, $rateApplicablePercents[0]);
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

        $this->assertEquals("Skontovereinbarung: 2% bei Zahlung innerhalb 10 Tagen nach Rechnungsdatum", $termdescription);
        $this->assertNull($termduedate);
        $this->assertEquals("", $termmandate);
        $this->assertEquals(2.0, $dispercent);
        $this->assertNull($discbasedatetime);
        $this->assertEquals(10, $discmeasureval);
        $this->assertEquals("DAY", $discmeasureunit);
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
        $this->assertTrue(self::$document->FirstDocumentPosition());
        $this->assertTrue(self::$document->NextDocumentPosition());
        $this->assertTrue(self::$document->NextDocumentPosition());
        $this->assertTrue(self::$document->NextDocumentPosition());
        $this->assertTrue(self::$document->NextDocumentPosition());
        $this->assertFalse(self::$document->NextDocumentPosition());
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
        $this->assertEquals("Wirkarbeit HT", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("WA997", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4123456000014", $prodglobalid);

        self::$document->GetDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->GetDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->GetDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0520, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(0.0520, $netpriceamount);
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
        $this->assertEquals(10000.0, $billedquantity);
        $this->assertEquals("KWH", $billedquantityunitcode);
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
        $this->assertEquals(52.00, $lineTotalAmount);
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
        $this->assertEquals("Ökosteuer Lieferant", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("ÖST250", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4123456000021", $prodglobalid);

        self::$document->GetDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->GetDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->GetDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0205, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(0.0205, $netpriceamount);
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
        $this->assertEquals(10000, $billedquantity);
        $this->assertEquals("KWH", $billedquantityunitcode);
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
        $this->assertEquals(20.50, $lineTotalAmount);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::FirstDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::NextDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionLineSummation
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::GetDocumentPositionSupplyChainEvent
     */
    public function testDocumentPositionThird()
    {
        $this->assertTrue(self::$document->NextDocumentPosition());

        self::$document->GetDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("3", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->GetDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("Kommissionierer 1250032 D. Muster", $prodname);
        $this->assertEquals("Besteller: Hr. Mayer, Personalnr. 4488", $proddesc);
        $this->assertEquals("", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4260331811362", $prodglobalid);

        self::$document->GetDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->GetDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->GetDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(15.0000, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(10.5000, $netpriceamount);
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
        $this->assertEquals(27.5000, $billedquantity);
        $this->assertEquals("HUR", $billedquantityunitcode);
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

        $this->assertTrue(self::$document->FirstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->NextDocumentPositionGrossPriceAllowanceCharge());
        
        self::$document->FirstDocumentPositionGrossPriceAllowanceCharge();
        self::$document->GetDocumentPositionGrossPriceAllowanceCharge($docPosAllowanceChargeactualAmount, $docPosAllowanceChargeisCharge, $docPosAllowanceChargecalculationPercent, $docPosAllowanceChargebasisAmount, $docPosAllowanceChargereason, $docPosAllowanceChargeTaxTypeCode, $docPosAllowanceChargeTaxCategoryCode, $docPosAllowanceChargerateApplicablePercent, $docPosAllowanceChargesequence, $docPosAllowanceChargebasisQuantity, $docPosAllowanceChargebasisQuantityUnitCode, $docPosAllowanceChargereasonCode);
        $this->assertEquals(4.5000, $docPosAllowanceChargeactualAmount);
        $this->assertFalse($docPosAllowanceChargeisCharge);
        $this->assertEquals(0, $docPosAllowanceChargecalculationPercent);
        $this->assertEquals(0, $docPosAllowanceChargebasisAmount);
        $this->assertEquals("Artikelrabatt 1", $docPosAllowanceChargereason);
        $this->assertEquals("", $docPosAllowanceChargeTaxTypeCode);
        $this->assertEquals("", $docPosAllowanceChargeTaxCategoryCode);
        $this->assertEquals(0, $docPosAllowanceChargerateApplicablePercent);
        $this->assertEquals(0, $docPosAllowanceChargesequence);
        $this->assertEquals(0, $docPosAllowanceChargebasisQuantity);
        $this->assertEquals("", $docPosAllowanceChargebasisQuantityUnitCode);
        $this->assertEquals("", $docPosAllowanceChargereasonCode);

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
        $this->assertEquals(288.75, $lineTotalAmount);
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
    public function testDocumentPositionFourth()
    {
        $this->assertTrue(self::$document->NextDocumentPosition());

        self::$document->GetDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("4", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->GetDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("FALTENBEUTEL 16x6x28 CM", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("FB05", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("2001015001325", $prodglobalid);

        self::$document->GetDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->GetDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->GetDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0105, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(0.0105, $netpriceamount);
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
        $this->assertEquals(3500.0, $billedquantity);
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
        $this->assertEquals(36.75, $lineTotalAmount);
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
    public function testDocumentPositionFifth()
    {
        $this->assertTrue(self::$document->NextDocumentPosition());

        self::$document->GetDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("5", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->GetDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("Kopierpapier A4", $prodname);
        $this->assertEquals("Zählerstand von-bis: 543210 - 544420", $proddesc);
        $this->assertEquals("KOP05", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4123456000038", $prodglobalid);

        self::$document->GetDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->GetDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->GetDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0100, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->GetDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(0.0100, $netpriceamount);
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
        $this->assertEquals(1210.0, $billedquantity);
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
        $this->assertEquals(12.10, $lineTotalAmount);
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
