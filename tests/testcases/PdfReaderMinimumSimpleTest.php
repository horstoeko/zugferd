<?php

namespace horstoeko\zugferd\tests\testcases;

use \horstoeko\zugferd\tests\TestCase;
use \horstoeko\zugferd\ZugferdDocumentPdfReader;
use \horstoeko\zugferd\codelists\ZugferdInvoiceType;
use \horstoeko\zugferd\ZugferdDocumentReader;
use \horstoeko\zugferd\ZugferdProfiles;

class PdfReaderMinimumSimpleTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentPdfReader::readAndGuessFromFile
     */
    public function testCanReadPdf(): void
    {
        self::$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/../assets/Facture_F20220027_MINIMUM.pdf");
        $this->assertNotNull(self::$document);
    }

    public function testDocumentProfile(): void
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_MINIMUM, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_XRECHNUNG, self::$document->getProfileId());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInformation
     */
    public function testDocumentGenerals(): void
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('F20220027', $documentno);
        $this->assertEquals(ZugferdInvoiceType::INVOICE, $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20220131'))->format('Ymd'), $documentdate->format('Ymd'));
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
    public function testDocumentNotes(): void
    {
        self::$document->getDocumentNotes($notes);
        $this->assertIsArray($notes);
        $this->assertEmpty($notes);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentGeneralPaymentInformation
     */
    public function testDocumentGeneralPaymentInformation(): void
    {
        self::$document->getDocumentGeneralPaymentInformation($creditorReferenceID, $paymentReference);
        $this->assertEquals("", $creditorReferenceID);
        $this->assertEquals("", $paymentReference);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getIsDocumentCopy
     */
    public function testDocumentIsCopy(): void
    {
        self::$document->getIsDocumentCopy($iscopy);
        $this->assertFalse($iscopy);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getIsTestDocument
     */
    public function testDocumentIsTestDocument(): void
    {
        self::$document->getIsTestDocument($istest);
        $this->assertFalse($istest);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSummation
     */
    public function testDocumentSummation(): void
    {
        self::$document->getDocumentSummation($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);
        $this->assertEquals(110.00, $grandTotalAmount);
        $this->assertEquals(100.00, $duePayableAmount);
        $this->assertEquals(0.0, $lineTotalAmount);
        $this->assertEquals(0.00, $chargeTotalAmount);
        $this->assertEquals(0.00, $allowanceTotalAmount);
        $this->assertEquals(100.00, $taxBasisTotalAmount);
        $this->assertEquals(10.00, $taxTotalAmount);
        $this->assertEquals(0.00, $roundingAmount);
        $this->assertEquals(0.00, $totalPrepaidAmount);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerReference
     */
    public function testGetDocumentBuyerReference(): void
    {
        self::$document->getDocumentBuyerReference($buyerReference);
        $this->assertEquals("SERVEXEC", $buyerReference);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSeller
     */
    public function testDocumentSellerGeneral(): void
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
    public function testDocumentSellerGlobalId(): void
    {
        self::$document->getDocumentSellerGlobalId($sellerglobalids);
        $this->assertIsArray($sellerglobalids);
        $this->assertEmpty($sellerglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRegistration
     */
    public function testDocumentSellerTaxRegistration(): void
    {
        self::$document->getDocumentSellerTaxRegistration($sellertaxreg);
        $this->assertIsArray($sellertaxreg);
        $this->assertArrayHasKey("VA", $sellertaxreg);
        $this->assertArrayNotHasKey("FC", $sellertaxreg);
        $this->assertArrayNotHasKey(0, $sellertaxreg);
        $this->assertArrayNotHasKey(1, $sellertaxreg);
        $this->assertArrayNotHasKey("ZZ", $sellertaxreg);
        $this->assertEquals("FR11123456782", $sellertaxreg["VA"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerAddress
     */
    public function testDocumentSellerAddress(): void
    {
        self::$document->getDocumentSellerAddress($sellerlineone, $sellerlinetwo, $sellerlinethree, $sellerpostcode, $sellercity, $sellercountry, $sellersubdivision);
        $this->assertEquals("", $sellerlineone);
        $this->assertEquals("", $sellerlinetwo);
        $this->assertEquals("", $sellerlinethree);
        $this->assertEquals("", $sellerpostcode);
        $this->assertEquals("", $sellercity);
        $this->assertEquals("FR", $sellercountry);
        $this->assertIsArray($sellersubdivision);
        $this->assertEmpty($sellersubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerLegalOrganisation
     */
    public function testDocumentSellerLegalOrganization(): void
    {
        self::$document->getDocumentSellerLegalOrganisation($sellerlegalorgid, $sellerlegalorgtype, $sellerlegalorgname);
        $this->assertEquals("123456782", $sellerlegalorgid);
        $this->assertEquals("0002", $sellerlegalorgtype);
        $this->assertEquals("", $sellerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentSellerContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentSellerContact
     */
    public function testDocumentSellerContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentSellerContact());
        $this->assertFalse(self::$document->nextDocumentSellerContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentSellerContact($sellercontactpersonname, $sellercontactdepartmentname, $sellercontactphoneno, $sellercontactfaxno, $sellercontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyer
     */
    public function testDocumentBuyerGeneral(): void
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
    public function testDocumentBuyerGlobalId(): void
    {
        self::$document->getDocumentBuyerGlobalId($buyerglobalids);
        $this->assertIsArray($buyerglobalids);
        $this->assertEmpty($buyerglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerTaxRegistration
     */
    public function testDocumentBuyerTaxRegistration(): void
    {
        self::$document->getDocumentBuyerTaxRegistration($buyertaxreg);
        $this->assertIsArray($buyertaxreg);
        $this->assertEmpty($buyertaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerAddress
     */
    public function testDocumentBuyerAddress(): void
    {
        self::$document->getDocumentBuyerAddress($buyerlineone, $buyerlinetwo, $buyerlinethree, $buyerpostcode, $buyercity, $buyercountry, $buyersubdivision);
        $this->assertEquals("", $buyerlineone);
        $this->assertEquals("", $buyerlinetwo);
        $this->assertEquals("", $buyerlinethree);
        $this->assertEquals("", $buyerpostcode);
        $this->assertEquals("", $buyercity);
        $this->assertEquals("", $buyercountry);
        $this->assertIsArray($buyersubdivision);
        $this->assertEmpty($buyersubdivision);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerLegalOrganisation
     */
    public function testDocumentBuyerLegalOrganization(): void
    {
        self::$document->getDocumentBuyerLegalOrganisation($buyerlegalorgid, $buyerlegalorgtype, $buyerlegalorgname);
        $this->assertEquals("987654321", $buyerlegalorgid);
        $this->assertEquals("0002", $buyerlegalorgtype);
        $this->assertEquals("", $buyerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentBuyerContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentBuyerContact
     */
    public function testDocumentBuyerContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentBuyerContact());
        $this->assertFalse(self::$document->nextDocumentBuyerContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentBuyerContact($buyercontactpersonname, $buyercontactdepartmentname, $buyercontactphoneno, $buyercontactfaxno, $buyercontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentative
     */
    public function testDocumentSellerTaxRepresentativeGeneral(): void
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
    public function testDocumentSellerTaxRepresentativeGlobalId(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeGlobalId($sellertaxreprglobalids);
        $this->assertIsArray($sellertaxreprglobalids);
        $this->assertEmpty($sellertaxreprglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentativeTaxRegistration
     */
    public function testDocumentSellerTaxRepresentativeTaxRegistration(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeTaxRegistration($sellertaxreprtaxreg);
        $this->assertIsArray($sellertaxreprtaxreg);
        $this->assertEmpty($sellertaxreprtaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentativeAddress
     */
    public function testDocumentSellerTaxRepresentativeAddress(): void
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
    public function testDocumentSellerTaxRepresentativeLegalOrganization(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeLegalOrganisation($sellertaxreprlegalorgid, $sellertaxreprlegalorgtype, $sellertaxreprlegalorgname);
        $this->assertEquals("", $sellertaxreprlegalorgid);
        $this->assertEquals("", $sellertaxreprlegalorgtype);
        $this->assertEquals("", $sellertaxreprlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerTaxRepresentativeContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentSellerTaxRepresentativeContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentSellerTaxRepresentativeContact
     */
    public function testDocumentSellerTaxRepresentativeContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentSellerTaxRepresentativeContact());
        $this->assertFalse(self::$document->nextDocumentSellerTaxRepresentativeContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentSellerTaxRepresentativeContact($sellertaxreprcontactpersonname, $sellertaxreprcontactdepartmentname, $sellertaxreprcontactphoneno, $sellertaxreprcontactfaxno, $sellertaxreprcontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipTo
     */
    public function testDocumentShipToGeneral(): void
    {
        self::$document->getDocumentShipTo($shiptoname, $shiptoids, $shiptodescription);
        $this->assertEquals("", $shiptoname);
        $this->assertIsArray($shiptoids);
        $this->assertEmpty($shiptoids);
        $this->assertEquals("", $shiptodescription);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToGlobalId
     */
    public function testDocumentShipToGlobalId(): void
    {
        self::$document->getDocumentShipToGlobalId($shiptoglobalids);
        $this->assertIsArray($shiptoglobalids);
        $this->assertEmpty($shiptoglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToTaxRegistration
     */
    public function testDocumentShipToTaxRegistration(): void
    {
        self::$document->getDocumentShipToTaxRegistration($shiptotaxreg);
        $this->assertIsArray($shiptotaxreg);
        $this->assertEmpty($shiptotaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToAddress
     */
    public function testDocumentShipToAddress(): void
    {
        self::$document->getDocumentShipToAddress($shiptolineone, $shiptolinetwo, $shiptolinethree, $shiptopostcode, $shiptocity, $shiptocountry, $shiptosubdivision);
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
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToLegalOrganisation
     */
    public function testDocumentShipToLegalOrganization(): void
    {
        self::$document->getDocumentShipToLegalOrganisation($shiptolegalorgid, $shiptolegalorgtype, $shiptolegalorgname);
        $this->assertEquals("", $shiptolegalorgid);
        $this->assertEquals("", $shiptolegalorgtype);
        $this->assertEquals("", $shiptolegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipToContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentShipToContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentShipToContact
     */
    public function testDocumentShipToContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentShipToContact());
        $this->assertFalse(self::$document->nextDocumentShipToContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentShipToContact($shiptocontactpersonname, $shiptocontactdepartmentname, $shiptocontactphoneno, $shiptocontactfaxno, $shiptocontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipTo
     */
    public function testDocumentUltimateShipToGeneral(): void
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
    public function testDocumentUltimateShipToGlobalId(): void
    {
        self::$document->getDocumentUltimateShipToGlobalId($ultimateshiptoglobalids);
        $this->assertIsArray($ultimateshiptoglobalids);
        $this->assertEmpty($ultimateshiptoglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipToTaxRegistration
     */
    public function testDocumentUltimateShipToTaxRegistration(): void
    {
        self::$document->getDocumentUltimateShipToTaxRegistration($ultimateshiptotaxreg);
        $this->assertIsArray($ultimateshiptotaxreg);
        $this->assertEmpty($ultimateshiptotaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipToAddress
     */
    public function testDocumentUltimateShipToAddress(): void
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
    public function testDocumentUltimateShipToLegalOrganization(): void
    {
        self::$document->getDocumentUltimateShipToLegalOrganisation($ultimateshiptolegalorgid, $ultimateshiptolegalorgtype, $ultimateshiptolegalorgname);
        $this->assertEquals("", $ultimateshiptolegalorgid);
        $this->assertEquals("", $ultimateshiptolegalorgtype);
        $this->assertEquals("", $ultimateshiptolegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentUltimateShipToContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentUltimateShipToContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentUltimateShipToContact
     */
    public function testDocumentUltimateShipToContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentUltimateShipToContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentUltimateShipToContact($ultimateshiptocontactpersonname, $ultimateshiptocontactdepartmentname, $ultimateshiptocontactphoneno, $ultimateshiptocontactfaxno, $ultimateshiptocontactemailaddr);
            }
        );
        $this->assertFalse(self::$document->nextDocumentUltimateShipToContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentUltimateShipToContact($ultimateshiptocontactpersonname, $ultimateshiptocontactdepartmentname, $ultimateshiptocontactphoneno, $ultimateshiptocontactfaxno, $ultimateshiptocontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFrom
     */
    public function testDocumentShipFromGeneral(): void
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
    public function testDocumentShipFromGlobalId(): void
    {
        self::$document->getDocumentShipFromGlobalId($shipfromglobalids);
        $this->assertIsArray($shipfromglobalids);
        $this->assertEmpty($shipfromglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFromTaxRegistration
     */
    public function testDocumentShipFromTaxRegistration(): void
    {
        self::$document->getDocumentShipFromTaxRegistration($shipfromtaxreg);
        $this->assertIsArray($shipfromtaxreg);
        $this->assertEmpty($shipfromtaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFromAddress
     */
    public function testDocumentShipFromAddress(): void
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
    public function testDocumentShipFromLegalOrganization(): void
    {
        self::$document->getDocumentShipFromLegalOrganisation($shipfromlegalorgid, $shipfromlegalorgtype, $shipfromlegalorgname);
        $this->assertEquals("", $shipfromlegalorgid);
        $this->assertEquals("", $shipfromlegalorgtype);
        $this->assertEquals("", $shipfromlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentShipFromContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentShipFromContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentShipFromContact
     */
    public function testDocumentShipFromContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentShipFromContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentShipFromContact($shipfromcontactpersonname, $shipfromcontactdepartmentname, $shipfromcontactphoneno, $shipfromcontactfaxno, $shipfromcontactemailaddr);
            }
        );
        $this->assertFalse(self::$document->nextDocumentShipFromContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentShipFromContact($shipfromcontactpersonname, $shipfromcontactdepartmentname, $shipfromcontactphoneno, $shipfromcontactfaxno, $shipfromcontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicer
     */
    public function testDocumentInvoicerGeneral(): void
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
    public function testDocumentInvoicerGlobalId(): void
    {
        self::$document->getDocumentInvoicerGlobalId($invoicerglobalids);
        $this->assertIsArray($invoicerglobalids);
        $this->assertEmpty($invoicerglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicerTaxRegistration
     */
    public function testDocumentInvoicerTaxRegistration(): void
    {
        self::$document->getDocumentInvoicerTaxRegistration($invoicertaxreg);
        $this->assertIsArray($invoicertaxreg);
        $this->assertEmpty($invoicertaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicerAddress
     */
    public function testDocumentInvoicerAddress(): void
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
    public function testDocumentInvoicerLegalOrganization(): void
    {
        self::$document->getDocumentInvoicerLegalOrganisation($invoicerlegalorgid, $invoicerlegalorgtype, $invoicerlegalorgname);
        $this->assertEquals("", $invoicerlegalorgid);
        $this->assertEquals("", $invoicerlegalorgtype);
        $this->assertEquals("", $invoicerlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicerContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentInvoicerContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentInvoicerContact
     */
    public function testDocumentInvoicerContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentInvoicerContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentInvoicerContact($invoicercontactpersonname, $invoicercontactdepartmentname, $invoicercontactphoneno, $invoicercontactfaxno, $invoicercontactemailaddr);
            }
        );
        $this->assertFalse(self::$document->nextDocumentInvoicerContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentInvoicerContact($invoicercontactpersonname, $invoicercontactdepartmentname, $invoicercontactphoneno, $invoicercontactfaxno, $invoicercontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoicee
     */
    public function testDocumentInvoiceeGeneral(): void
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
    public function testDocumentInvoiceeGlobalId(): void
    {
        self::$document->getDocumentInvoiceeGlobalId($invoiceeglobalids);
        $this->assertIsArray($invoiceeglobalids);
        $this->assertEmpty($invoiceeglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoiceeTaxRegistration
     */
    public function testDocumentInvoiceeTaxRegistration(): void
    {
        self::$document->getDocumentInvoiceeTaxRegistration($invoiceetaxreg);
        $this->assertIsArray($invoiceetaxreg);
        $this->assertEmpty($invoiceetaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoiceeAddress
     */
    public function testDocumentInvoiceeAddress(): void
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
    public function testDocumentInvoiceeLegalOrganization(): void
    {
        self::$document->getDocumentInvoiceeLegalOrganisation($invoiceelegalorgid, $invoiceelegalorgtype, $invoiceelegalorgname);
        $this->assertEquals("", $invoiceelegalorgid);
        $this->assertEquals("", $invoiceelegalorgtype);
        $this->assertEquals("", $invoiceelegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInvoiceeContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentInvoiceeContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentInvoiceeContact
     */
    public function testDocumentInvoiceeContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentInvoiceeContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentInvoiceeContact($invoiceecontactpersonname, $invoiceecontactdepartmentname, $invoiceecontactphoneno, $invoiceecontactfaxno, $invoiceecontactemailaddr);
            }
        );
        $this->assertFalse(self::$document->nextDocumentInvoiceeContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentInvoiceeContact($invoiceecontactpersonname, $invoiceecontactdepartmentname, $invoiceecontactphoneno, $invoiceecontactfaxno, $invoiceecontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayee
     */
    public function testDocumentPayeeGeneral(): void
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
    public function testDocumentPayeeGlobalId(): void
    {
        self::$document->getDocumentPayeeGlobalId($payeeglobalids);
        $this->assertIsArray($payeeglobalids);
        $this->assertEmpty($payeeglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayeeTaxRegistration
     */
    public function testDocumentPayeeTaxRegistration(): void
    {
        self::$document->getDocumentPayeeTaxRegistration($payeetaxreg);
        $this->assertIsArray($payeetaxreg);
        $this->assertEmpty($payeetaxreg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayeeAddress
     */
    public function testDocumentPayeeAddress(): void
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
    public function testDocumentPayeeLegalOrganization(): void
    {
        self::$document->getDocumentPayeeLegalOrganisation($payeelegalorgid, $payeelegalorgtype, $payeelegalorgname);
        $this->assertEquals("", $payeelegalorgid);
        $this->assertEquals("", $payeelegalorgtype);
        $this->assertEquals("", $payeelegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPayeeContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPayeeContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPayeeContact
     */
    public function testDocumentPayeeContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentPayeeContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentPayeeContact($payeecontactpersonname, $payeecontactdepartmentname, $payeecontactphoneno, $payeecontactfaxno, $payeecontactemailaddr);
            }
        );
        $this->assertFalse(self::$document->nextDocumentPayeeContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentPayeeContact($payeecontactpersonname, $payeecontactdepartmentname, $payeecontactphoneno, $payeecontactfaxno, $payeecontactemailaddr);
            }
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUser
     */
    public function testDocumentProductEndUserGeneral(): void
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
    public function testDocumentProductEndUserGlobalId(): void
    {
        self::$document->getDocumentProductEndUserGlobalId($producenduserglobalids);
        $this->assertIsArray($producenduserglobalids);
        $this->assertArrayNotHasKey("0088", $producenduserglobalids);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUserTaxRegistration
     */
    public function testDocumentProductEndUserTaxRegistration(): void
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
    public function testDocumentProductEndUserAddress(): void
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
    public function testDocumentProductEndUserLegalOrganization(): void
    {
        self::$document->getDocumentProductEndUserLegalOrganisation($producenduserlegalorgid, $producenduserlegalorgtype, $producenduserlegalorgname);
        $this->assertEquals("", $producenduserlegalorgid);
        $this->assertEquals("", $producenduserlegalorgtype);
        $this->assertEquals("", $producenduserlegalorgname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProductEndUserContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentProductEndUserContactContact
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentProductEndUserContactContact
     */
    public function testDocumentProductEndUserContact(): void
    {
        $this->assertFalse(self::$document->firstDocumentProductEndUserContactContact());
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getDocumentProductEndUserContact($producendusercontactpersonname, $producendusercontactdepartmentname, $producendusercontactphoneno, $producendusercontactfaxno, $producendusercontactemailaddr);
            }
        );
        $this->assertFalse(self::$document->nextDocumentProductEndUserContactContact());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSellerOrderReferencedDocument
     */
    public function testDocumentSellerOrderReferencedDocument(): void
    {
        self::$document->getDocumentSellerOrderReferencedDocument($sellerorderrefdocid, $sellerorderrefdocdate);
        $this->assertEquals("", $sellerorderrefdocid);
        $this->assertNull($sellerorderrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBuyerOrderReferencedDocument
     */
    public function testDocumentBuyerOrderReferencedDocument(): void
    {
        self::$document->getDocumentBuyerOrderReferencedDocument($buyerorderrefdocid, $buyerorderrefdocdate);
        $this->assertEquals("PO201925478", $buyerorderrefdocid);
        $this->assertNull($buyerorderrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentContractReferencedDocument
     */
    public function testDocumentContractReferencedDocument(): void
    {
        self::$document->getDocumentContractReferencedDocument($contractrefdocid, $contractrefdocdate);
        $this->assertEquals("", $contractrefdocid);
        $this->assertNull($contractrefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentAdditionalReferencedDocuments
     */
    public function testDocumentAdditionalReferencedDocuments(): void
    {
        self::$document->getDocumentAdditionalReferencedDocuments($additionalrefdocs);
        $this->assertIsArray($additionalrefdocs);
        $this->assertEmpty($additionalrefdocs);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentProcuringProject
     */
    public function testDocumentProcuringProject(): void
    {
        self::$document->getDocumentProcuringProject($projectid, $projectname);
        $this->assertEquals("", $projectid);
        $this->assertEquals("", $projectname);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentSupplyChainEvent
     */
    public function testDocumentSupplyChainEvent(): void
    {
        self::$document->getDocumentSupplyChainEvent($supplychainevent);
        $this->assertNull($supplychainevent);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentDespatchAdviceReferencedDocument
     */
    public function testDocumentDespatchAdviceReferencedDocument(): void
    {
        self::$document->getDocumentDespatchAdviceReferencedDocument($despatchdocid, $despatchdocdate);
        $this->assertEquals("", $despatchdocid);
        $this->assertNull($despatchdocdate);
        $this->assertNotInstanceOf("DateTime", $despatchdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentReceivingAdviceReferencedDocument
     */
    public function testDocumentReceivingAdviceReferencedDocument(): void
    {
        self::$document->getDocumentReceivingAdviceReferencedDocument($recadvid, $recadvdate);
        $this->assertEquals("", $recadvid);
        $this->assertNull($recadvdate);
        $this->assertNotInstanceOf("DateTime", $recadvdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentDeliveryNoteReferencedDocument
     */
    public function testDocumentDeliveryNoteReferencedDocument(): void
    {
        self::$document->getDocumentDeliveryNoteReferencedDocument($deliverynoterefdocid, $deliverynoterefdocdate);
        $this->assertEquals("", $deliverynoterefdocid);
        $this->assertNull($deliverynoterefdocdate);
        $this->assertNotInstanceOf("DateTime", $deliverynoterefdocdate);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentBillingPeriod
     */
    public function testDocumentBillingPeriod(): void
    {
        self::$document->getDocumentBillingPeriod($docbillingperiodstart, $docbillingperiodend);
        $this->assertNull($docbillingperiodstart);
        $this->assertNotInstanceOf("DateTime", $docbillingperiodstart);
        $this->assertNull($docbillingperiodend);
        $this->assertNotInstanceOf("DateTime", $docbillingperiodend);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentAllowanceCharges
     */
    public function testDocumentAllowanceCharges(): void
    {
        self::$document->getDocumentAllowanceCharges($docallowancecharge);
        $this->assertIsArray($docallowancecharge);
        $this->assertEmpty($docallowancecharge);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPaymentTerms
     */
    public function testDocumentPaymentTerms(): void
    {
        self::$document->getDocumentPaymentTerms($docpaymentterms);
        $this->assertIsArray($docpaymentterms);
        $this->assertEmpty($docpaymentterms);
        $this->assertArrayNotHasKey(0, $docpaymentterms);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentDeliveryTerms
     */
    public function testDocumentDeliveryTerms(): void
    {
        self::$document->getDocumentDeliveryTerms($devtermcode);
        $this->assertEquals("", $devtermcode);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentAdditionalReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentAdditionalReferencedDocument
     */
    public function testDocumentAdditionalReferencedDocumentLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentAdditionalReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentAdditionalReferencedDocument());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentUltimateCustomerOrderReferencedDocument
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentUltimateCustomerOrderReferencedDocument
     */
    public function testDocumentUltimateCustomerOrderReferencedDocumentLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentUltimateCustomerOrderReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentUltimateCustomerOrderReferencedDocument());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstGetDocumentPaymentMeans
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextGetDocumentPaymentMeans
     */
    public function testDocumentPaymentMeansLoop(): void
    {
        $this->assertFalse(self::$document->firstGetDocumentPaymentMeans());
        $this->assertFalse(self::$document->nextGetDocumentPaymentMeans());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentTax
     */
    public function testDocumentTaxLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentTax());
        $this->assertFalse(self::$document->nextDocumentTax());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentTax
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentTax
     */
    public function testDocumentTax(): void
    {
        $this->assertFalse(self::$document->firstDocumentTax());
        $this->assertFalse(self::$document->nextDocumentTax());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentAllowanceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentAllowanceCharge
     */
    public function testtDocumentAllowanceChargeLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentAllowanceCharge());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentLogisticsServiceCharge
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentLogisticsServiceCharge
     */
    public function testtDocumentLogisticsServiceChargeLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentLogisticsServiceCharge());
        $this->assertFalse(self::$document->nextDocumentLogisticsServiceCharge());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPaymentTerms
     */
    public function testtDocumentPaymentTermsLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentPaymentTerms());
        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPaymentTerms
     */
    public function testtDocumentPaymentTerms(): void
    {
        $this->assertFalse(self::$document->firstDocumentPaymentTerms());
        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPosition
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPosition
     */
    public function testDocumentPositionLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentPosition(), "has a first position");
        $this->assertFalse(self::$document->nextDocumentPosition(), "has a second position");
        $this->assertFalse(self::$document->nextDocumentPosition(), "has no third position");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPosition
     */
    public function testDocumentPositionFirst(): void
    {
        $this->assertfalse(self::$document->firstDocumentPosition());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPosition
     */
    public function testDocumentPositionSecond(): void
    {
        $this->assertFalse(self::$document->nextDocumentPosition());
    }
}
