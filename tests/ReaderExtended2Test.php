<?php

namespace horstoeko\zugferd\tests;

use \horstoeko\zugferd\codelists\ZugferdInvoiceType;
use \PHPUnit\Framework\TestCase;
use \horstoeko\zugferd\ZugferdProfiles;
use \horstoeko\zugferd\ZugferdDocumentReader;

class ReaderExtended2Test extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/data/extended_invoice_2.xml");
    }

    public function testDocumentProfile()
    {
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->profile);
        $this->assertEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->profile);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInformation
     */
    public function testDocumentGenerals()
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('F20200027', $documentno);
        $this->assertEquals(ZugferdInvoiceType::INVOICE, $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20200115'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertEquals("EUR", $invoiceCurrency);
        $this->assertEquals("", $taxCurrency);
        $this->assertEquals("", $documentname);
        $this->assertEquals("", $documentlanguage);
        $this->assertNull($effectiveSpecifiedPeriod);
        $this->assertNotNull(self::$document->getInvoiceObject());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentNotes
     */
    public function testDocumentNotes()
    {
        self::$document->getDocumentNotes($notes);
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
        $this->assertEquals("REG", $notes[0]["subjectcode"]);
        $this->assertEquals("FOURNISSEUR F SARL au capital de 50 000 EUR", $notes[0]["content"]);
        $this->assertEquals("", $notes[1]["contentcode"]);
        $this->assertEquals("ABL", $notes[1]["subjectcode"]);
        $this->assertEquals("RCS MAVILLE 123 456 789", $notes[1]["content"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentGeneralPaymentInformation
     */
    public function testDocumentGeneralPaymentInformation()
    {
        self::$document->getDocumentGeneralPaymentInformation($creditorReferenceID, $paymentReference);
        $this->assertEquals("", $creditorReferenceID);
        $this->assertEquals("F20180023BUYER", $paymentReference);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getIsDocumentCopy
     */
    public function testDocumentIsCopy()
    {
        self::$document->getIsDocumentCopy($iscopy);
        $this->assertFalse($iscopy);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getIsTestDocument
     */
    public function testDocumentIsTestDocument()
    {
        self::$document->getIsTestDocument($istest);
        $this->assertFalse($istest);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSummation
     */
    public function testDocumentSummation()
    {
        self::$document->getDocumentSummation($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);
        $this->assertEquals(110.0, $grandTotalAmount);
        $this->assertEquals(100.0, $duePayableAmount);
        $this->assertEquals(95.0, $lineTotalAmount);
        $this->assertEquals(10.0, $chargeTotalAmount);
        $this->assertEquals(5.0, $allowanceTotalAmount);
        $this->assertEquals(100.0, $taxBasisTotalAmount);
        $this->assertEquals(10.0, $taxTotalAmount);
        $this->assertEquals(0.00, $roundingAmount);
        $this->assertEquals(10.00, $totalPrepaidAmount);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerReference
     */
    public function testGetDocumentBuyerReference()
    {
        self::$document->getDocumentBuyerReference($buyerReference);
        $this->assertEquals("SERVEXEC", $buyerReference);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSeller
     */
    public function testDocumentSellerGeneral()
    {
        self::$document->getDocumentSeller($sellername, $sellerids, $sellerdescription);
        $this->assertEquals("LE FOURNISSEUR", $sellername);
        $this->assertIsArray($sellerids);
        $this->assertArrayNotHasKey(0, $sellerids);
        $this->assertArrayNotHasKey(1, $sellerids);
        $this->assertEquals("", $sellerdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerGlobalId
     */
    public function testDocumentSellerGlobalId()
    {
        self::$document->getDocumentSellerGlobalId($sellerglobalids);
        $this->assertIsArray($sellerglobalids);
        $this->assertArrayHasKey("0088", $sellerglobalids);
        $this->assertEquals("587451236587", $sellerglobalids["0088"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRegistration
     */
    public function testDocumentSellerTaxRegistration()
    {
        self::$document->getDocumentSellerTaxRegistration($sellertaxreg);
        $this->assertIsArray($sellertaxreg);
        $this->assertArrayHasKey("VA", $sellertaxreg);
        $this->assertArrayNotHasKey("FC", $sellertaxreg);
        $this->assertArrayNotHasKey(0, $sellertaxreg);
        $this->assertArrayNotHasKey(1, $sellertaxreg);
        $this->assertArrayNotHasKey("ZZ", $sellertaxreg);
        $this->assertEquals("FR32123456789", $sellertaxreg["VA"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerAddress
     */
    public function testDocumentSellerAddress()
    {
        self::$document->getDocumentSellerAddress($sellerlineone, $sellerlinetwo, $sellerlinethree, $sellerpostcode, $sellercity, $sellercountry, $sellersubdivision);
        $this->assertEquals("35 rue d'ici", $sellerlineone);
        $this->assertEquals("Seller line 2", $sellerlinetwo);
        $this->assertEquals("", $sellerlinethree);
        $this->assertEquals("75018", $sellerpostcode);
        $this->assertEquals("PARIS", $sellercity);
        $this->assertEquals("FR", $sellercountry);
        $this->assertIsArray($sellersubdivision);
        $this->assertEmpty($sellersubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerLegalOrganisation
     */
    public function testDocumentSellerLegalOrganization()
    {
        self::$document->getDocumentSellerLegalOrganisation($sellerlegalorgid, $sellerlegalorgtype, $sellerlegalorgname);
        $this->assertEquals("12345678900014", $sellerlegalorgid);
        $this->assertEquals("0002", $sellerlegalorgtype);
        $this->assertEquals("SELLER TRADE NAME", $sellerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerContact
     */
    public function testDocumentSellerContact()
    {
        self::$document->getDocumentSellerContact($sellercontactpersonname, $sellercontactdepartmentname, $sellercontactphoneno, $sellercontactfaxno, $sellercontactemailaddr);
        $this->assertEquals("", $sellercontactpersonname);
        $this->assertEquals("", $sellercontactdepartmentname);
        $this->assertEquals("", $sellercontactphoneno);
        $this->assertEquals("", $sellercontactfaxno);
        $this->assertEquals("", $sellercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyer
     */
    public function testDocumentBuyerGeneral()
    {
        self::$document->getDocumentBuyer($buyername, $buyerids, $buyerdescription);
        $this->assertEquals("LE CLIENT", $buyername);
        $this->assertIsArray($buyerids);
        $this->assertArrayNotHasKey(0, $buyerids);
        $this->assertArrayNotHasKey(1, $buyerids);
        $this->assertEquals("", $buyerdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerGlobalId
     */
    public function testDocumentBuyerGlobalId()
    {
        self::$document->getDocumentBuyerGlobalId($buyerglobalids);
        $this->assertIsArray($buyerglobalids);
        $this->assertArrayHasKey("0088", $buyerglobalids);
        $this->assertEquals("3654789851", $buyerglobalids["0088"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerTaxRegistration
     */
    public function testDocumentBuyerTaxRegistration()
    {
        self::$document->getDocumentBuyerTaxRegistration($buyertaxreg);
        $this->assertIsArray($buyertaxreg);
        $this->assertArrayHasKey("VA", $buyertaxreg);
        $this->assertArrayNotHasKey("FC", $buyertaxreg);
        $this->assertArrayNotHasKey(0, $buyertaxreg);
        $this->assertArrayNotHasKey(1, $buyertaxreg);
        $this->assertArrayNotHasKey("ZZ", $buyertaxreg);
        $this->assertEquals("FR 05 987 654 321", $buyertaxreg["VA"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerAddress
     */
    public function testDocumentBuyerAddress()
    {
        self::$document->getDocumentBuyerAddress($buyerlineone, $buyerlinetwo, $buyerlinethree, $buyerpostcode, $buyercity, $buyercountry, $buyersubdivision);
        $this->assertEquals("58 rue de la mer", $buyerlineone);
        $this->assertEquals("Buyer line 2", $buyerlinetwo);
        $this->assertEquals("", $buyerlinethree);
        $this->assertEquals("06000", $buyerpostcode);
        $this->assertEquals("NICE", $buyercity);
        $this->assertEquals("FR", $buyercountry);
        $this->assertIsArray($buyersubdivision);
        $this->assertEmpty($buyersubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerLegalOrganisation
     */
    public function testDocumentBuyerLegalOrganization()
    {
        self::$document->getDocumentBuyerLegalOrganisation($buyerlegalorgid, $buyerlegalorgtype, $buyerlegalorgname);
        $this->assertEquals("98765432100029", $buyerlegalorgid);
        $this->assertEquals("0002", $buyerlegalorgtype);
        $this->assertEquals("", $buyerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerContact
     */
    public function testDocumentBuyerContact()
    {
        self::$document->getDocumentBuyerContact($buyercontactpersonname, $buyercontactdepartmentname, $buyercontactphoneno, $buyercontactfaxno, $buyercontactemailaddr);
        $this->assertEquals("", $buyercontactpersonname);
        $this->assertEquals("", $buyercontactdepartmentname);
        $this->assertEquals("", $buyercontactphoneno);
        $this->assertEquals("", $buyercontactfaxno);
        $this->assertEquals("", $buyercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentative
     */
    public function testDocumentSellerTaxRepresentativeGeneral()
    {
        self::$document->getDocumentSellerTaxRepresentative($sellertaxreprname, $sellertaxreprids, $sellertaxreprdescription);
        $this->assertEquals("", $sellertaxreprname);
        $this->assertIsArray($sellertaxreprids);
        $this->assertEmpty($sellertaxreprids);
        $this->assertEquals("", $sellertaxreprdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentativeGlobalId
     */
    public function testDocumentSellerTaxRepresentativeGlobalId()
    {
        self::$document->getDocumentSellerTaxRepresentativeGlobalId($sellertaxreprglobalids);
        $this->assertIsArray($sellertaxreprglobalids);
        $this->assertEmpty($sellertaxreprglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentativeTaxRegistration
     */
    public function testDocumentSellerTaxRepresentativeTaxRegistration()
    {
        self::$document->getDocumentSellerTaxRepresentativeTaxRegistration($sellertaxreprtaxreg);
        $this->assertIsArray($sellertaxreprtaxreg);
        $this->assertEmpty($sellertaxreprtaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentativeAddress
     */
    public function testDocumentSellerTaxRepresentativeAddress()
    {
        self::$document->getDocumentSellerTaxRepresentativeAddress($sellertaxreprlineone, $sellertaxreprlinetwo, $sellertaxreprlinethree, $sellertaxreprpostcode, $sellertaxreprcity, $sellertaxreprcountry, $sellertaxreprsubdivision);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentativeLegalOrganisation
     */
    public function testDocumentSellerTaxRepresentativeLegalOrganization()
    {
        self::$document->getDocumentSellerTaxRepresentativeLegalOrganisation($sellertaxreprlegalorgid, $sellertaxreprlegalorgtype, $sellertaxreprlegalorgname);
        $this->assertEquals("", $sellertaxreprlegalorgid);
        $this->assertEquals("", $sellertaxreprlegalorgtype);
        $this->assertEquals("", $sellertaxreprlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentativeContact
     */
    public function testDocumentSellerTaxRepresentativeContact()
    {
        self::$document->getDocumentSellerTaxRepresentativeContact($sellertaxreprcontactpersonname, $sellertaxreprcontactdepartmentname, $sellertaxreprcontactphoneno, $sellertaxreprcontactfaxno, $sellertaxreprcontactemailaddr);
        $this->assertEquals("", $sellertaxreprcontactpersonname);
        $this->assertEquals("", $sellertaxreprcontactdepartmentname);
        $this->assertEquals("", $sellertaxreprcontactphoneno);
        $this->assertEquals("", $sellertaxreprcontactfaxno);
        $this->assertEquals("", $sellertaxreprcontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipTo
     */
    public function testDocumentShipToGeneral()
    {
        self::$document->getDocumentShipTo($shiptoname, $shiptoids, $shiptodescription);
        $this->assertEquals("DEL Name", $shiptoname);
        $this->assertIsArray($shiptoids);
        $this->assertEmpty($shiptoids);
        $this->assertEquals("", $shiptodescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToGlobalId
     */
    public function testDocumentShipToGlobalId()
    {
        self::$document->getDocumentShipToGlobalId($shiptoglobalids);
        $this->assertIsArray($shiptoglobalids);
        $this->arrayHasKey("0088", $shiptoglobalids);
        $this->assertEquals("3654789851", $shiptoglobalids["0088"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToTaxRegistration
     */
    public function testDocumentShipToTaxRegistration()
    {
        self::$document->getDocumentShipToTaxRegistration($shiptotaxreg);
        $this->assertIsArray($shiptotaxreg);
        $this->assertEmpty($shiptotaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToAddress
     */
    public function testDocumentShipToAddress()
    {
        self::$document->getDocumentShipToAddress($shiptolineone, $shiptolinetwo, $shiptolinethree, $shiptopostcode, $shiptocity, $shiptocountry, $shiptosubdivision);
        $this->assertEquals("DEL 58 rue de la mer", $shiptolineone);
        $this->assertEquals("DEL line 2", $shiptolinetwo);
        $this->assertEquals("", $shiptolinethree);
        $this->assertEquals("06000", $shiptopostcode);
        $this->assertEquals("NICE", $shiptocity);
        $this->assertEquals("FR", $shiptocountry);
        $this->assertIsArray($shiptosubdivision);
        $this->assertEmpty($shiptosubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToLegalOrganisation
     */
    public function testDocumentShipToLegalOrganization()
    {
        self::$document->getDocumentShipToLegalOrganisation($shiptolegalorgid, $shiptolegalorgtype, $shiptolegalorgname);
        $this->assertEquals("", $shiptolegalorgid);
        $this->assertEquals("", $shiptolegalorgtype);
        $this->assertEquals("", $shiptolegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToContact
     */
    public function testDocumentShipToContact()
    {
        self::$document->getDocumentShipToContact($shiptocontactpersonname, $shiptocontactdepartmentname, $shiptocontactphoneno, $shiptocontactfaxno, $shiptocontactemailaddr);
        $this->assertEquals("", $shiptocontactpersonname);
        $this->assertEquals("", $shiptocontactdepartmentname);
        $this->assertEquals("", $shiptocontactphoneno);
        $this->assertEquals("", $shiptocontactfaxno);
        $this->assertEquals("", $shiptocontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipTo
     */
    public function testDocumentUltimateShipToGeneral()
    {
        self::$document->getDocumentUltimateShipTo($ultimateshiptoname, $ultimateshiptoids, $ultimateshiptodescription);
        $this->assertEquals("", $ultimateshiptoname);
        $this->assertIsArray($ultimateshiptoids);
        $this->assertEmpty($ultimateshiptoids);
        $this->assertEquals("", $ultimateshiptodescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipToGlobalId
     */
    public function testDocumentUltimateShipToGlobalId()
    {
        self::$document->getDocumentUltimateShipToGlobalId($ultimateshiptoglobalids);
        $this->assertIsArray($ultimateshiptoglobalids);
        $this->assertEmpty($ultimateshiptoglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipToTaxRegistration
     */
    public function testDocumentUltimateShipToTaxRegistration()
    {
        self::$document->getDocumentUltimateShipToTaxRegistration($ultimateshiptotaxreg);
        $this->assertIsArray($ultimateshiptotaxreg);
        $this->assertEmpty($ultimateshiptotaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipToAddress
     */
    public function testDocumentUltimateShipToAddress()
    {
        self::$document->getDocumentUltimateShipToAddress($ultimateshiptolineone, $ultimateshiptolinetwo, $ultimateshiptolinethree, $ultimateshiptopostcode, $ultimateshiptocity, $ultimateshiptocountry, $ultimateshiptosubdivision);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipToLegalOrganisation
     */
    public function testDocumentUltimateShipToLegalOrganization()
    {
        self::$document->getDocumentUltimateShipToLegalOrganisation($ultimateshiptolegalorgid, $ultimateshiptolegalorgtype, $ultimateshiptolegalorgname);
        $this->assertEquals("", $ultimateshiptolegalorgid);
        $this->assertEquals("", $ultimateshiptolegalorgtype);
        $this->assertEquals("", $ultimateshiptolegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipToContact
     */
    public function testDocumentUltimateShipToContact()
    {
        self::$document->getDocumentUltimateShipToContact($ultimateshiptocontactpersonname, $ultimateshiptocontactdepartmentname, $ultimateshiptocontactphoneno, $ultimateshiptocontactfaxno, $ultimateshiptocontactemailaddr);
        $this->assertEquals("", $ultimateshiptocontactpersonname);
        $this->assertEquals("", $ultimateshiptocontactdepartmentname);
        $this->assertEquals("", $ultimateshiptocontactphoneno);
        $this->assertEquals("", $ultimateshiptocontactfaxno);
        $this->assertEquals("", $ultimateshiptocontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFrom
     */
    public function testDocumentShipFromGeneral()
    {
        self::$document->getDocumentShipFrom($shipfromname, $shipfromids, $shipfromdescription);
        $this->assertEquals("", $shipfromname);
        $this->assertIsArray($shipfromids);
        $this->assertEmpty($shipfromids);
        $this->assertEquals("", $shipfromdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFromGlobalId
     */
    public function testDocumentShipFromGlobalId()
    {
        self::$document->getDocumentShipFromGlobalId($shipfromglobalids);
        $this->assertIsArray($shipfromglobalids);
        $this->assertEmpty($shipfromglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFromTaxRegistration
     */
    public function testDocumentShipFromTaxRegistration()
    {
        self::$document->getDocumentShipFromTaxRegistration($shipfromtaxreg);
        $this->assertIsArray($shipfromtaxreg);
        $this->assertEmpty($shipfromtaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFromAddress
     */
    public function testDocumentShipFromAddress()
    {
        self::$document->getDocumentShipFromAddress($shipfromlineone, $shipfromlinetwo, $shipfromlinethree, $shipfrompostcode, $shipfromcity, $shipfromcountry, $shipfromsubdivision);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFromLegalOrganisation
     */
    public function testDocumentShipFromLegalOrganization()
    {
        self::$document->getDocumentShipFromLegalOrganisation($shipfromlegalorgid, $shipfromlegalorgtype, $shipfromlegalorgname);
        $this->assertEquals("", $shipfromlegalorgid);
        $this->assertEquals("", $shipfromlegalorgtype);
        $this->assertEquals("", $shipfromlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFromContact
     */
    public function testDocumentShipFromContact()
    {
        self::$document->getDocumentShipFromContact($shipfromcontactpersonname, $shipfromcontactdepartmentname, $shipfromcontactphoneno, $shipfromcontactfaxno, $shipfromcontactemailaddr);
        $this->assertEquals("", $shipfromcontactpersonname);
        $this->assertEquals("", $shipfromcontactdepartmentname);
        $this->assertEquals("", $shipfromcontactphoneno);
        $this->assertEquals("", $shipfromcontactfaxno);
        $this->assertEquals("", $shipfromcontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicer
     */
    public function testDocumentInvoicerGeneral()
    {
        self::$document->getDocumentInvoicer($invoicername, $invoicerids, $invoicerdescription);
        $this->assertEquals("", $invoicername);
        $this->assertIsArray($invoicerids);
        $this->assertEmpty($invoicerids);
        $this->assertEquals("", $invoicerdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicerGlobalId
     */
    public function testDocumentInvoicerGlobalId()
    {
        self::$document->getDocumentInvoicerGlobalId($invoicerglobalids);
        $this->assertIsArray($invoicerglobalids);
        $this->assertEmpty($invoicerglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicerTaxRegistration
     */
    public function testDocumentInvoicerTaxRegistration()
    {
        self::$document->getDocumentInvoicerTaxRegistration($invoicertaxreg);
        $this->assertIsArray($invoicertaxreg);
        $this->assertEmpty($invoicertaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicerAddress
     */
    public function testDocumentInvoicerAddress()
    {
        self::$document->getDocumentInvoicerAddress($invoicerlineone, $invoicerlinetwo, $invoicerlinethree, $invoicerpostcode, $invoicercity, $invoicercountry, $invoicersubdivision);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicerLegalOrganisation
     */
    public function testDocumentInvoicerLegalOrganization()
    {
        self::$document->getDocumentInvoicerLegalOrganisation($invoicerlegalorgid, $invoicerlegalorgtype, $invoicerlegalorgname);
        $this->assertEquals("", $invoicerlegalorgid);
        $this->assertEquals("", $invoicerlegalorgtype);
        $this->assertEquals("", $invoicerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicerContact
     */
    public function testDocumentInvoicerContact()
    {
        self::$document->getDocumentInvoicerContact($invoicercontactpersonname, $invoicercontactdepartmentname, $invoicercontactphoneno, $invoicercontactfaxno, $invoicercontactemailaddr);
        $this->assertEquals("", $invoicercontactpersonname);
        $this->assertEquals("", $invoicercontactdepartmentname);
        $this->assertEquals("", $invoicercontactphoneno);
        $this->assertEquals("", $invoicercontactfaxno);
        $this->assertEquals("", $invoicercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicee
     */
    public function testDocumentInvoiceeGeneral()
    {
        self::$document->getDocumentInvoicee($invoiceename, $invoiceeids, $invoiceedescription);
        $this->assertEquals("", $invoiceename);
        $this->assertIsArray($invoiceeids);
        $this->assertEmpty($invoiceeids);
        $this->assertEquals("", $invoiceedescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoiceeGlobalId
     */
    public function testDocumentInvoiceeGlobalId()
    {
        self::$document->getDocumentInvoiceeGlobalId($invoiceeglobalids);
        $this->assertIsArray($invoiceeglobalids);
        $this->assertEmpty($invoiceeglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoiceeTaxRegistration
     */
    public function testDocumentInvoiceeTaxRegistration()
    {
        self::$document->getDocumentInvoiceeTaxRegistration($invoiceetaxreg);
        $this->assertIsArray($invoiceetaxreg);
        $this->assertEmpty($invoiceetaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoiceeAddress
     */
    public function testDocumentInvoiceeAddress()
    {
        self::$document->getDocumentInvoiceeAddress($invoiceelineone, $invoiceelinetwo, $invoiceelinethree, $invoiceepostcode, $invoiceecity, $invoiceecountry, $invoiceesubdivision);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoiceeLegalOrganisation
     */
    public function testDocumentInvoiceeLegalOrganization()
    {
        self::$document->getDocumentInvoiceeLegalOrganisation($invoiceelegalorgid, $invoiceelegalorgtype, $invoiceelegalorgname);
        $this->assertEquals("", $invoiceelegalorgid);
        $this->assertEquals("", $invoiceelegalorgtype);
        $this->assertEquals("", $invoiceelegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoiceeContact
     */
    public function testDocumentInvoiceeContact()
    {
        self::$document->getDocumentInvoiceeContact($invoiceecontactpersonname, $invoiceecontactdepartmentname, $invoiceecontactphoneno, $invoiceecontactfaxno, $invoiceecontactemailaddr);
        $this->assertEquals("", $invoiceecontactpersonname);
        $this->assertEquals("", $invoiceecontactdepartmentname);
        $this->assertEquals("", $invoiceecontactphoneno);
        $this->assertEquals("", $invoiceecontactfaxno);
        $this->assertEquals("", $invoiceecontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayee
     */
    public function testDocumentPayeeGeneral()
    {
        self::$document->getDocumentPayee($payeename, $payeeids, $payeedescription);
        $this->assertEquals("", $payeename);
        $this->assertIsArray($payeeids);
        $this->assertEmpty($payeeids);
        $this->assertEquals("", $payeedescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayeeGlobalId
     */
    public function testDocumentPayeeGlobalId()
    {
        self::$document->getDocumentPayeeGlobalId($payeeglobalids);
        $this->assertIsArray($payeeglobalids);
        $this->assertEmpty($payeeglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayeeTaxRegistration
     */
    public function testDocumentPayeeTaxRegistration()
    {
        self::$document->getDocumentPayeeTaxRegistration($payeetaxreg);
        $this->assertIsArray($payeetaxreg);
        $this->assertEmpty($payeetaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayeeAddress
     */
    public function testDocumentPayeeAddress()
    {
        self::$document->getDocumentPayeeAddress($payeelineone, $payeelinetwo, $payeelinethree, $payeepostcode, $payeecity, $payeecountry, $payeesubdivision);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayeeLegalOrganisation
     */
    public function testDocumentPayeeLegalOrganization()
    {
        self::$document->getDocumentPayeeLegalOrganisation($payeelegalorgid, $payeelegalorgtype, $payeelegalorgname);
        $this->assertEquals("", $payeelegalorgid);
        $this->assertEquals("", $payeelegalorgtype);
        $this->assertEquals("", $payeelegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayeeContact
     */
    public function testDocumentPayeeContact()
    {
        self::$document->getDocumentPayeeContact($payeecontactpersonname, $payeecontactdepartmentname, $payeecontactphoneno, $payeecontactfaxno, $payeecontactemailaddr);
        $this->assertEquals("", $payeecontactpersonname);
        $this->assertEquals("", $payeecontactdepartmentname);
        $this->assertEquals("", $payeecontactphoneno);
        $this->assertEquals("", $payeecontactfaxno);
        $this->assertEquals("", $payeecontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUser
     */
    public function testDocumentProductEndUserGeneral()
    {
        self::$document->getDocumentProductEndUser($producendusername, $producenduserids, $producenduserdescription);
        $this->assertEquals("", $producendusername);
        $this->assertIsArray($producenduserids);
        $this->assertArrayNotHasKey(0, $producenduserids);
        $this->assertArrayNotHasKey(1, $producenduserids);
        $this->assertEquals("", $producenduserdescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUserGlobalId
     */
    public function testDocumentProductEndUserGlobalId()
    {
        self::$document->getDocumentProductEndUserGlobalId($producenduserglobalids);
        $this->assertIsArray($producenduserglobalids);
        $this->assertArrayNotHasKey("0088", $producenduserglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUserTaxRegistration
     */
    public function testDocumentProductEndUserTaxRegistration()
    {
        self::$document->getDocumentProductEndUserTaxRegistration($producendusertaxreg);
        $this->assertIsArray($producendusertaxreg);
        $this->assertArrayNotHasKey("VA", $producendusertaxreg);
        $this->assertArrayNotHasKey("FC", $producendusertaxreg);
        $this->assertArrayNotHasKey(0, $producendusertaxreg);
        $this->assertArrayNotHasKey(1, $producendusertaxreg);
        $this->assertArrayNotHasKey("ZZ", $producendusertaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUserAddress
     */
    public function testDocumentProductEndUserAddress()
    {
        self::$document->getDocumentProductEndUserAddress($producenduserlineone, $producenduserlinetwo, $producenduserlinethree, $producenduserpostcode, $producendusercity, $producendusercountry, $producendusersubdivision);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUserLegalOrganisation
     */
    public function testDocumentProductEndUserLegalOrganization()
    {
        self::$document->getDocumentProductEndUserLegalOrganisation($producenduserlegalorgid, $producenduserlegalorgtype, $producenduserlegalorgname);
        $this->assertEquals("", $producenduserlegalorgid);
        $this->assertEquals("", $producenduserlegalorgtype);
        $this->assertEquals("", $producenduserlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUserContact
     */
    public function testDocumentProductEndUserContact()
    {
        self::$document->getDocumentProductEndUserContact($producendusercontactpersonname, $producendusercontactdepartmentname, $producendusercontactphoneno, $producendusercontactfaxno, $producendusercontactemailaddr);
        $this->assertEquals("", $producendusercontactpersonname);
        $this->assertEquals("", $producendusercontactdepartmentname);
        $this->assertEquals("", $producendusercontactphoneno);
        $this->assertEquals("", $producendusercontactfaxno);
        $this->assertEquals("", $producendusercontactemailaddr);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerOrderReferencedDocument
     */
    public function testDocumentSellerOrderReferencedDocument()
    {
        self::$document->getDocumentSellerOrderReferencedDocument($sellerorderrefdocid, $sellerorderrefdocdate);
        $this->assertEquals("SALES REF 2547", $sellerorderrefdocid);
        $this->assertNull($sellerorderrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerOrderReferencedDocument
     */
    public function testDocumentBuyerOrderReferencedDocument()
    {
        self::$document->getDocumentBuyerOrderReferencedDocument($buyerorderrefdocid, $buyerorderrefdocdate);
        $this->assertEquals("PO201925478", $buyerorderrefdocid);
        $this->assertNull($buyerorderrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentContractReferencedDocument
     */
    public function testDocumentContractReferencedDocument()
    {
        self::$document->getDocumentContractReferencedDocument($contractrefdocid, $contractrefdocdate);
        $this->assertEquals("CT2018120802", $contractrefdocid);
        $this->assertNull($contractrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentAdditionalReferencedDocuments
     */
    public function testDocumentAdditionalReferencedDocuments()
    {
        self::$document->getDocumentAdditionalReferencedDocuments($additionalrefdocs);
        $this->assertIsArray($additionalrefdocs);
        $this->assertNotEmpty($additionalrefdocs);
        $this->assertArrayHasKey(0, $additionalrefdocs);
        $this->assertIsArray($additionalrefdocs[0]);
        $this->assertArrayHasKey("IssuerAssignedID", $additionalrefdocs[0]);
        $this->assertArrayHasKey("TypeCode", $additionalrefdocs[0]);
        $this->assertEquals("SUPPort doc", $additionalrefdocs[0]["IssuerAssignedID"]);
        $this->assertEquals("916", $additionalrefdocs[0]["TypeCode"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProcuringProject
     */
    public function testDocumentProcuringProject()
    {
        self::$document->getDocumentProcuringProject($projectid, $projectname);
        $this->assertEquals("PROJET2547", $projectid);
        $this->assertEquals("Project reference", $projectname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSupplyChainEvent
     */
    public function testDocumentSupplyChainEvent()
    {
        self::$document->getDocumentSupplyChainEvent($supplychainevent);
        $this->assertNotNull($supplychainevent);
        $this->assertInstanceOf("DateTime", $supplychainevent);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20200115'))->format('Ymd'), $supplychainevent->format('Ymd'));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentDespatchAdviceReferencedDocument
     */
    public function testDocumentDespatchAdviceReferencedDocument()
    {
        self::$document->getDocumentDespatchAdviceReferencedDocument($despatchdocid, $despatchdocdate);
        $this->assertEquals("DESPADV002", $despatchdocid);
        $this->assertNull($despatchdocdate);
        $this->assertNotInstanceOf("DateTime", $despatchdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentReceivingAdviceReferencedDocument
     */
    public function testDocumentReceivingAdviceReferencedDocument()
    {
        self::$document->getDocumentReceivingAdviceReferencedDocument($recadvid, $recadvdate);
        $this->assertEquals("RECEIV-ADV002", $recadvid);
        $this->assertNull($recadvdate);
        $this->assertNotInstanceOf("DateTime", $recadvdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentDeliveryNoteReferencedDocument
     */
    public function testDocumentDeliveryNoteReferencedDocument()
    {
        self::$document->getDocumentDeliveryNoteReferencedDocument($deliverynoterefdocid, $deliverynoterefdocdate);
        $this->assertEquals("", $deliverynoterefdocid);
        $this->assertNull($deliverynoterefdocdate);
        $this->assertNotInstanceOf("DateTime", $deliverynoterefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBillingPeriod
     */
    public function testDocumentBillingPeriod()
    {
        self::$document->getDocumentBillingPeriod($docbillingperiodstart, $docbillingperiodend);
        $this->assertInstanceOf("DateTime", $docbillingperiodstart);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20191201'))->format('Ymd'), $docbillingperiodstart->format('Ymd'));
        $this->assertInstanceOf("DateTime", $docbillingperiodend);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20191231'))->format('Ymd'), $docbillingperiodend->format('Ymd'));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentAllowanceCharges
     */
    public function testDocumentAllowanceCharges()
    {
        self::$document->getDocumentAllowanceCharges($docallowancecharge);
        $this->assertIsArray($docallowancecharge);
        $this->assertNotEmpty($docallowancecharge);
        $this->assertEquals(2, count($docallowancecharge));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPaymentTerms
     */
    public function testDocumentPaymentTerms()
    {
        self::$document->getDocumentPaymentTerms($docpaymentterms);
        $this->assertIsArray($docpaymentterms);
        $this->assertNotEmpty($docpaymentterms);
        $this->assertArrayHasKey(0, $docpaymentterms);
        $this->assertIsArray($docpaymentterms[0]);
        $this->assertArrayHasKey("description", $docpaymentterms[0]);
        $this->assertArrayHasKey("duedate", $docpaymentterms[0]);
        $this->assertArrayHasKey("directdebitmandateid", $docpaymentterms[0]);
        $this->assertArrayHasKey("partialpaymentamount", $docpaymentterms[0]);
        $this->assertEquals("", $docpaymentterms[0]["description"]);
        $this->assertInstanceOf("DateTime", $docpaymentterms[0]["duedate"]);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20200215'))->format('Ymd'), $docpaymentterms[0]["duedate"]->format('Ymd'));
        $this->assertEquals("", $docpaymentterms[0]["directdebitmandateid"]);
        $this->assertEquals(0.0, $docpaymentterms[0]["partialpaymentamount"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentDeliveryTerms
     */
    public function testDocumentDeliveryTerms()
    {
        self::$document->getDocumentDeliveryTerms($devtermcode);
        $this->assertEquals("", $devtermcode);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentAdditionalReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentAdditionalReferencedDocument
     */
    public function testDocumentAdditionalReferencedDocumentLoop()
    {
        $this->assertTrue(self::$document->firstDocumentAdditionalReferencedDocument());
        $this->assertTrue(self::$document->nextDocumentAdditionalReferencedDocument());
        $this->assertTrue(self::$document->nextDocumentAdditionalReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentAdditionalReferencedDocument());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentAdditionalReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentAdditionalReferencedDocument
     */
    public function testGetDocumentAdditionalReferencedDocument()
    {
        $this->assertTrue(self::$document->firstDocumentAdditionalReferencedDocument());
        self::$document->getDocumentAdditionalReferencedDocument($issuerassignedid, $typecode, $uriid, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->assertEquals("SUPPort doc", $issuerassignedid);
        $this->assertEquals("916", $typecode);
        $this->assertEquals("url:gffter", $uriid);
        $this->assertIsArray($name);
        $this->assertNotEmpty($name);
        $this->assertArrayHasKey(0, $name);
        $this->assertEquals("", $reftypecode);
        $this->assertNull($issueddate);
        $this->assertEquals("", $binarydatafilename);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentUltimateCustomerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentUltimateCustomerOrderReferencedDocument
     */
    public function testDocumentUltimateCustomerOrderReferencedDocumentLoop()
    {
        $this->assertFalse(self::$document->firstDocumentUltimateCustomerOrderReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentUltimateCustomerOrderReferencedDocument());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstGetDocumentPaymentMeans
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextGetDocumentPaymentMeans
     */
    public function testDocumentPaymentMeansLoop()
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        $this->assertFalse(self::$document->nextGetDocumentPaymentMeans());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstGetDocumentPaymentMeans
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPaymentMeans
     */
    public function testGetDocumentPaymentMeans()
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        self::$document->getDocumentPaymentMeans($typeCode, $information, $cardType, $cardId, $cardHolderName, $buyerIban, $payeeIban, $payeeAccountName, $payeePropId, $payeeBic);
        $this->assertEquals("30", $typeCode);
        $this->assertEquals("", $information);
        $this->assertEquals("", $cardType);
        $this->assertEquals("", $cardId);
        $this->assertEquals("", $cardHolderName);
        $this->assertEquals("", $buyerIban);
        $this->assertEquals("FR76 1254 2547 2569 8542 5874 698", $payeeIban);
        $this->assertEquals("", $payeeAccountName);
        $this->assertEquals("", $payeePropId);
        $this->assertEquals("", $payeeBic);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentTax
     */
    public function testDocumentTaxLoop()
    {
        $this->assertTrue(self::$document->firstDocumentTax());
        $this->assertFalse(self::$document->nextDocumentTax());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentTax
     */
    public function testDocumentTax()
    {
        $this->assertTrue(self::$document->firstDocumentTax());
        self::$document->getDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(100.0, $basisAmount);
        $this->assertEquals(10.0, $calculatedAmount);
        $this->assertEquals(10.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $allowanceChargeBasisAmount);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentAllowanceCharge
     */
    public function testtDocumentAllowanceChargeLoop()
    {
        $this->assertTrue(self::$document->firstDocumentAllowanceCharge());
        $this->assertTrue(self::$document->nextDocumentAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentAllowanceCharge());
    }


    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentAllowanceCharge
     */
    public function testtDocumentAllowanceCharge()
    {
        $this->assertTrue(self::$document->firstDocumentAllowanceCharge());
        self::$document->getDocumentAllowanceCharge($actualAmount, $isCharge, $taxCategoryCode, $taxTypeCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->assertEquals(5.0, $actualAmount);
        $this->assertFalse($isCharge);
        $this->assertEquals("S", $taxCategoryCode);
        $this->assertEquals("VAT", $taxTypeCode);
        $this->assertEquals(10.00, $rateApplicablePercent);
        $this->assertEquals(0, $sequence);
        $this->assertEquals(0, $calculationPercent);
        $this->assertEquals(0, $basisAmount);
        $this->assertEquals(0, $basisQuantity);
        $this->assertEquals("", $basisQuantityUnitCode);
        $this->assertEquals("", $reasonCode);
        $this->assertEquals("REMISE COMMERCIALE", $reason);

        $this->assertTrue(self::$document->nextDocumentAllowanceCharge());
        self::$document->getDocumentAllowanceCharge($actualAmount, $isCharge, $taxCategoryCode, $taxTypeCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->assertEquals(10.0, $actualAmount);
        $this->assertTrue($isCharge);
        $this->assertEquals("S", $taxCategoryCode);
        $this->assertEquals("VAT", $taxTypeCode);
        $this->assertEquals(10.00, $rateApplicablePercent);
        $this->assertEquals(0, $sequence);
        $this->assertEquals(0, $calculationPercent);
        $this->assertEquals(0, $basisAmount);
        $this->assertEquals(0, $basisQuantity);
        $this->assertEquals("", $basisQuantityUnitCode);
        $this->assertEquals("", $reasonCode);
        $this->assertEquals("FRAIS DEPLACEMENT", $reason);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentLogisticsServiceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentLogisticsServiceCharge
     */
    public function testtDocumentLogisticsServiceChargeLoop()
    {
        $this->assertFalse(self::$document->firstDocumentLogisticsServiceCharge());
        $this->assertFalse(self::$document->nextDocumentLogisticsServiceCharge());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPaymentTerms
     */
    public function testtDocumentPaymentTermsLoop()
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPaymentTerm
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDiscountTermsFromPaymentTerm
     */
    public function testtDocumentPaymentTerms()
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        self::$document->getDocumentPaymentTerm($termdescription, $termduedate, $termmandate);
        self::$document->getDiscountTermsFromPaymentTerm($dispercent, $discbasedatetime, $discmeasureval, $discmeasureunit, $discbaseamount, $discamount);

        $this->assertEquals("", $termdescription);
        $this->assertInstanceOf("DateTime", $termduedate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20200215'))->format('Ymd'), $termduedate->format('Ymd'));
        $this->assertEquals("", $termmandate);
        $this->assertEquals(0.0, $dispercent);
        $this->assertNull($discbasedatetime);
        $this->assertEquals(0, $discmeasureval);
        $this->assertEquals("", $discmeasureunit);
        $this->assertEquals(0, $discbaseamount);
        $this->assertEquals(0, $discamount);

        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPosition
     */
    public function testDocumentPositionLoop()
    {
        $this->assertTrue(self::$document->firstDocumentPosition());
        $this->assertTrue(self::$document->nextDocumentPosition());
        $this->assertTrue(self::$document->nextDocumentPosition());
        $this->assertFalse(self::$document->nextDocumentPosition());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionGenerals
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionProductDetails
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionBuyerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionContractReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionGrossPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionNetPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionNetPriceTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionQuantity
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionDespatchAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionReceivingAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionDeliveryNoteReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionBillingPeriod
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionLineSummation
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionSupplyChainEvent
     */
    public function testDocumentPositionFirst()
    {
        $this->assertTrue(self::$document->firstDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("1", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("PRESTATION SUPPORT", $prodname);
        $this->assertEquals("Description", $proddesc);
        $this->assertEquals("", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("598785412598745", $prodglobalid);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("1", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(60.0, $netpriceamount);
        $this->assertEquals(1.0, $netpricebasisquantity);
        $this->assertEquals("C62", $netpricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPriceTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("", $categoryCode);
        $this->assertEquals("", $typeCode);
        $this->assertEquals(0.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionQuantity($billedquantity, $billedquantityunitcode, $chargeFreeQuantity, $chargeFreeQuantityunitcode, $packageQuantity, $packageQuantityunitcode);
        $this->assertEquals(1.0, $billedquantity);
        $this->assertEquals("C62", $billedquantityunitcode);
        $this->assertEquals(0.0, $chargeFreeQuantity);
        $this->assertEquals("", $chargeFreeQuantityunitcode);
        $this->assertEquals(0.0, $packageQuantity);
        $this->assertEquals("", $packageQuantityunitcode);

        self::$document->getDocumentPositionDespatchAdviceReferencedDocument($docposdespadvid, $docposdespadvlineid, $docposdespadvdatetime);
        $this->assertEquals("", $docposdespadvid);
        $this->assertEquals("", $docposdespadvlineid);
        $this->assertNull($docposdespadvdatetime);

        self::$document->getDocumentPositionReceivingAdviceReferencedDocument($docposrecadvid, $docposrecadvlineid, $docposrecadvdatetime);
        $this->assertEquals("", $docposrecadvid);
        $this->assertEquals("", $docposrecadvlineid);
        $this->assertNull($docposrecadvdatetime);

        self::$document->getDocumentPositionDeliveryNoteReferencedDocument($docposdelnoteid, $docposdelnotelineid, $docposdelnotedatetime);
        $this->assertEquals("", $docposdelnoteid);
        $this->assertEquals("", $docposdelnotelineid);
        $this->assertNull($docposdelnotedatetime);

        self::$document->getDocumentPositionBillingPeriod($docposstartdate, $docpostenddate);
        $this->assertInstanceOf("DateTime", $docposstartdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20191201'))->format('Ymd'), $docposstartdate->format('Ymd'));
        $this->assertInstanceOf("DateTime", $docpostenddate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20191231'))->format('Ymd'), $docpostenddate->format('Ymd'));

        $this->assertFalse(self::$document->firstDocumentPositionNote());
        $this->assertFalse(self::$document->nextDocumentPositionNote());

        $this->assertFalse(self::$document->firstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentPositionGrossPriceAllowanceCharge());

        $this->assertTrue(self::$document->firstDocumentPositionTax());
        $this->assertFalse(self::$document->nextDocumentPositionTax());

        self::$document->firstDocumentPositionTax();
        self::$document->getDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(10.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummation($lineTotalAmount, $totalAllowanceChargeAmount);
        $this->assertEquals(60.00, $lineTotalAmount);
        $this->assertEquals(0.0, $totalAllowanceChargeAmount);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionGenerals
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionProductDetails
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionBuyerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionContractReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionGrossPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionNetPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionNetPriceTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionQuantity
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionDespatchAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionReceivingAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionDeliveryNoteReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionBillingPeriod
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionLineSummation
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionSupplyChainEvent
     */
    public function testDocumentPositionSecond()
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("2", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("FOURNITURES DIVERSES", $prodname);
        $this->assertEquals("Description", $proddesc);
        $this->assertEquals("", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("", $prodglobalidtype);
        $this->assertEquals("", $prodglobalid);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("3", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(10.0, $netpriceamount);
        $this->assertEquals(0.0, $netpricebasisquantity);
        $this->assertEquals("", $netpricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPriceTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("", $categoryCode);
        $this->assertEquals("", $typeCode);
        $this->assertEquals(0.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionQuantity($billedquantity, $billedquantityunitcode, $chargeFreeQuantity, $chargeFreeQuantityunitcode, $packageQuantity, $packageQuantityunitcode);
        $this->assertEquals(3, $billedquantity);
        $this->assertEquals("C62", $billedquantityunitcode);
        $this->assertEquals(0.0, $chargeFreeQuantity);
        $this->assertEquals("", $chargeFreeQuantityunitcode);
        $this->assertEquals(0.0, $packageQuantity);
        $this->assertEquals("", $packageQuantityunitcode);

        self::$document->getDocumentPositionDespatchAdviceReferencedDocument($docposdespadvid, $docposdespadvlineid, $docposdespadvdatetime);
        $this->assertEquals("", $docposdespadvid);
        $this->assertEquals("", $docposdespadvlineid);
        $this->assertNull($docposdespadvdatetime);

        self::$document->getDocumentPositionReceivingAdviceReferencedDocument($docposrecadvid, $docposrecadvlineid, $docposrecadvdatetime);
        $this->assertEquals("", $docposrecadvid);
        $this->assertEquals("", $docposrecadvlineid);
        $this->assertNull($docposrecadvdatetime);

        self::$document->getDocumentPositionDeliveryNoteReferencedDocument($docposdelnoteid, $docposdelnotelineid, $docposdelnotedatetime);
        $this->assertEquals("", $docposdelnoteid);
        $this->assertEquals("", $docposdelnotelineid);
        $this->assertNull($docposdelnotedatetime);

        self::$document->getDocumentPositionBillingPeriod($docposstartdate, $docpostenddate);
        $this->assertInstanceOf("DateTime", $docposstartdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20191201'))->format('Ymd'), $docposstartdate->format('Ymd'));
        $this->assertNull($docpostenddate);

        $this->assertFalse(self::$document->firstDocumentPositionNote());
        $this->assertFalse(self::$document->nextDocumentPositionNote());

        $this->assertFalse(self::$document->firstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentPositionGrossPriceAllowanceCharge());

        $this->assertTrue(self::$document->firstDocumentPositionTax());
        $this->assertFalse(self::$document->nextDocumentPositionTax());

        self::$document->firstDocumentPositionTax();
        self::$document->getDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(10.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummation($lineTotalAmount, $totalAllowanceChargeAmount);
        $this->assertEquals(30.0, $lineTotalAmount);
        $this->assertEquals(0.0, $totalAllowanceChargeAmount);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionGenerals
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionProductDetails
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionBuyerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionContractReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionGrossPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionNetPrice
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionNetPriceTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionQuantity
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionDespatchAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionReceivingAdviceReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionDeliveryNoteReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionBillingPeriod
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionNote
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionGrossPriceAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionLineSummation
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPositionSupplyChainEvent
     */
    public function testDocumentPositionThird()
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("3", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("APPEL", $prodname);
        $this->assertEquals("Description", $proddesc);
        $this->assertEquals("", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("", $prodglobalidtype);
        $this->assertEquals("", $prodglobalid);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0000, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(5.0, $netpriceamount);
        $this->assertEquals(0.0, $netpricebasisquantity);
        $this->assertEquals("", $netpricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPriceTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("", $categoryCode);
        $this->assertEquals("", $typeCode);
        $this->assertEquals(0.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionQuantity($billedquantity, $billedquantityunitcode, $chargeFreeQuantity, $chargeFreeQuantityunitcode, $packageQuantity, $packageQuantityunitcode);
        $this->assertEquals(1.0, $billedquantity);
        $this->assertEquals("C62", $billedquantityunitcode);
        $this->assertEquals(0.0, $chargeFreeQuantity);
        $this->assertEquals("", $chargeFreeQuantityunitcode);
        $this->assertEquals(0.0, $packageQuantity);
        $this->assertEquals("", $packageQuantityunitcode);

        self::$document->getDocumentPositionDespatchAdviceReferencedDocument($docposdespadvid, $docposdespadvlineid, $docposdespadvdatetime);
        $this->assertEquals("", $docposdespadvid);
        $this->assertEquals("", $docposdespadvlineid);
        $this->assertNull($docposdespadvdatetime);

        self::$document->getDocumentPositionReceivingAdviceReferencedDocument($docposrecadvid, $docposrecadvlineid, $docposrecadvdatetime);
        $this->assertEquals("", $docposrecadvid);
        $this->assertEquals("", $docposrecadvlineid);
        $this->assertNull($docposrecadvdatetime);

        self::$document->getDocumentPositionDeliveryNoteReferencedDocument($docposdelnoteid, $docposdelnotelineid, $docposdelnotedatetime);
        $this->assertEquals("", $docposdelnoteid);
        $this->assertEquals("", $docposdelnotelineid);
        $this->assertNull($docposdelnotedatetime);

        self::$document->getDocumentPositionBillingPeriod($docposstartdate, $docpostenddate);
        $this->assertNull($docposstartdate);
        $this->assertInstanceOf("DateTime", $docpostenddate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20191231'))->format('Ymd'), $docpostenddate->format('Ymd'));

        $this->assertFalse(self::$document->firstDocumentPositionNote());
        $this->assertFalse(self::$document->nextDocumentPositionNote());

        $this->assertFalse(self::$document->firstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentPositionGrossPriceAllowanceCharge());

        $this->assertTrue(self::$document->firstDocumentPositionTax());
        $this->assertFalse(self::$document->nextDocumentPositionTax());

        self::$document->firstDocumentPositionTax();
        self::$document->getDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(10.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummation($lineTotalAmount, $totalAllowanceChargeAmount);
        $this->assertEquals(5.0, $lineTotalAmount);
        $this->assertEquals(0.0, $totalAllowanceChargeAmount);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPositionAdditionalReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPositionAdditionalReferencedDocument
     */
    public function testDocumentPositionAdditionalReferencedDocument()
    {
        $this->assertFalse(self::$document->firstDocumentPositionAdditionalReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentPositionAdditionalReferencedDocument());
    }
}