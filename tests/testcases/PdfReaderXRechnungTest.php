<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentPdfReader;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

class PdfReaderXRechnungTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public function testCanReadPdf(): void
    {
        self::$document = ZugferdDocumentPdfReader::readAndGuessFromFile(__DIR__ . "/../assets/pdf_zf_xrechnung_1.pdf");
        $this->assertNotNull(self::$document);
    }

    public function testDocumentProfile(): void
    {
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
        $this->assertEquals(ZugferdProfiles::PROFILE_XRECHNUNG, self::$document->getProfileId());
    }

    public function testDocumentGenerals(): void
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertSame('471102', $documentno);
        $this->assertSame(ZugferdInvoiceType::INVOICE, $documenttypecode);
        $this->assertInstanceOf(\DateTime::class, $documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180305'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertSame("EUR", $invoiceCurrency);
        $this->assertSame("", $taxCurrency);
        $this->assertSame("", $documentname);
        $this->assertSame("", $documentlanguage);
        $this->assertNotInstanceOf(\DateTime::class, $effectiveSpecifiedPeriod);
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
        $this->assertInstanceOf('horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice', $this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
    }

    public function testDocumentNotes(): void
    {
        self::$document->getDocumentNotes($notes);
        $this->assertIsArray($notes);
        $this->assertNotEmpty($notes);
        $this->assertCount(2, $notes);
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

    public function testDocumentGeneralPaymentInformation(): void
    {
        self::$document->getDocumentGeneralPaymentInformation($creditorReferenceID, $paymentReference);
        $this->assertSame("", $creditorReferenceID);
        $this->assertSame("", $paymentReference);
    }

    public function testDocumentIsCopy(): void
    {
        self::$document->getIsDocumentCopy($iscopy);
        $this->assertFalse($iscopy);
    }

    public function testDocumentIsTestDocument(): void
    {
        self::$document->getIsTestDocument($istest);
        $this->assertFalse($istest);
    }

    public function testDocumentSummation(): void
    {
        self::$document->getDocumentSummation($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);
        $this->assertEqualsWithDelta(529.87, $grandTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(529.87, $duePayableAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(473.00, $lineTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.00, $chargeTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.00, $allowanceTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(473.00, $taxBasisTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(56.87, $taxTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.00, $roundingAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.00, $totalPrepaidAmount, PHP_FLOAT_EPSILON);
    }

    public function testGetDocumentBuyerReference(): void
    {
        self::$document->getDocumentBuyerReference($buyerReference);
        $this->assertSame("04011000-12345-34", $buyerReference);
    }

    public function testDocumentSellerGeneral(): void
    {
        self::$document->getDocumentSeller($sellername, $sellerids, $sellerdescription);
        $this->assertSame("Lieferant GmbH", $sellername);
        $this->assertIsArray($sellerids);
        $this->assertArrayNotHasKey(0, $sellerids);
        $this->assertArrayNotHasKey(1, $sellerids);
        $this->assertSame("", $sellerdescription);
    }

    public function testDocumentSellerGlobalId(): void
    {
        self::$document->getDocumentSellerGlobalId($sellerglobalids);
        $this->assertIsArray($sellerglobalids);
        $this->assertArrayHasKey("0088", $sellerglobalids);
        $this->assertEquals("4000001123452", $sellerglobalids["0088"]);
    }

    public function testDocumentSellerTaxRegistration(): void
    {
        self::$document->getDocumentSellerTaxRegistration($sellertaxreg);
        $this->assertIsArray($sellertaxreg);
        $this->assertArrayHasKey("VA", $sellertaxreg);
        $this->assertArrayHasKey("FC", $sellertaxreg);
        $this->assertArrayNotHasKey(0, $sellertaxreg);
        $this->assertArrayNotHasKey(1, $sellertaxreg);
        $this->assertArrayNotHasKey("ZZ", $sellertaxreg);
        $this->assertEquals("201/113/40209", $sellertaxreg["FC"]);
        $this->assertEquals("DE123456789", $sellertaxreg["VA"]);
    }

    public function testDocumentSellerAddress(): void
    {
        self::$document->getDocumentSellerAddress($sellerlineone, $sellerlinetwo, $sellerlinethree, $sellerpostcode, $sellercity, $sellercountry, $sellersubdivision);
        $this->assertSame("Lieferantenstraße 20", $sellerlineone);
        $this->assertSame("", $sellerlinetwo);
        $this->assertSame("", $sellerlinethree);
        $this->assertSame("80333", $sellerpostcode);
        $this->assertSame("München", $sellercity);
        $this->assertSame("DE", $sellercountry);
        $this->assertIsArray($sellersubdivision);
        $this->assertEmpty($sellersubdivision);
    }

    public function testDocumentSellerLegalOrganization(): void
    {
        self::$document->getDocumentSellerLegalOrganisation($sellerlegalorgid, $sellerlegalorgtype, $sellerlegalorgname);
        $this->assertSame("", $sellerlegalorgid);
        $this->assertSame("", $sellerlegalorgtype);
        $this->assertSame("", $sellerlegalorgname);
    }

    public function testDocumentSellerContact(): void
    {
        $this->assertTrue(self::$document->firstDocumentSellerContact());
        self::$document->getDocumentSellerContact($sellercontactpersonname, $sellercontactdepartmentname, $sellercontactphoneno, $sellercontactfaxno, $sellercontactemailaddr);
        $this->assertSame("Max Mustermann", $sellercontactpersonname);
        $this->assertSame("Muster-Einkauf", $sellercontactdepartmentname);
        $this->assertSame("+49891234567", $sellercontactphoneno);
        $this->assertSame("", $sellercontactfaxno);
        $this->assertSame("Max@Mustermann.de", $sellercontactemailaddr);
        $this->assertFalse(self::$document->nextDocumentSellerContact());
    }

    public function testGetDocumentSellerCommunication(): void
    {
        self::$document->getDocumentSellerCommunication($uriScheme, $uri);
        $this->assertSame("", $uriScheme);
        $this->assertSame("", $uri);
    }

    public function testDocumentBuyerGeneral(): void
    {
        self::$document->getDocumentBuyer($buyername, $buyerids, $buyerdescription);
        $this->assertSame("Kunden AG Mitte", $buyername);
        $this->assertIsArray($buyerids);
        $this->assertArrayHasKey(0, $buyerids);
        $this->assertArrayNotHasKey(1, $buyerids);
        $this->assertEquals("GE2020211", $buyerids[0]);
        $this->assertSame("", $buyerdescription);
    }

    public function testDocumentBuyerGlobalId(): void
    {
        self::$document->getDocumentBuyerGlobalId($buyerglobalids);
        $this->assertIsArray($buyerglobalids);
        $this->assertEmpty($buyerglobalids);
    }

    public function testDocumentBuyerTaxRegistration(): void
    {
        self::$document->getDocumentBuyerTaxRegistration($buyertaxreg);
        $this->assertIsArray($buyertaxreg);
        $this->assertEmpty($buyertaxreg);
    }

    public function testDocumentBuyerAddress(): void
    {
        self::$document->getDocumentBuyerAddress($buyerlineone, $buyerlinetwo, $buyerlinethree, $buyerpostcode, $buyercity, $buyercountry, $buyersubdivision);
        $this->assertSame("Kundenstraße 15", $buyerlineone);
        $this->assertSame("", $buyerlinetwo);
        $this->assertSame("", $buyerlinethree);
        $this->assertSame("69876", $buyerpostcode);
        $this->assertSame("Frankfurt", $buyercity);
        $this->assertSame("DE", $buyercountry);
        $this->assertIsArray($buyersubdivision);
        $this->assertEmpty($buyersubdivision);
    }

    public function testDocumentBuyerLegalOrganization(): void
    {
        self::$document->getDocumentBuyerLegalOrganisation($buyerlegalorgid, $buyerlegalorgtype, $buyerlegalorgname);
        $this->assertSame("", $buyerlegalorgid);
        $this->assertSame("", $buyerlegalorgtype);
        $this->assertSame("", $buyerlegalorgname);
    }

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

    public function testGetDocumentBuyerCommunication(): void
    {
        self::$document->getDocumentBuyerCommunication($uriScheme, $uri);
        $this->assertSame("", $uriScheme);
        $this->assertSame("", $uri);
    }

    public function testDocumentSellerTaxRepresentativeGeneral(): void
    {
        self::$document->getDocumentSellerTaxRepresentative($sellertaxreprname, $sellertaxreprids, $sellertaxreprdescription);
        $this->assertSame("", $sellertaxreprname);
        $this->assertIsArray($sellertaxreprids);
        $this->assertEmpty($sellertaxreprids);
        $this->assertSame("", $sellertaxreprdescription);
    }

    public function testDocumentSellerTaxRepresentativeGlobalId(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeGlobalId($sellertaxreprglobalids);
        $this->assertIsArray($sellertaxreprglobalids);
        $this->assertEmpty($sellertaxreprglobalids);
    }

    public function testDocumentSellerTaxRepresentativeTaxRegistration(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeTaxRegistration($sellertaxreprtaxreg);
        $this->assertIsArray($sellertaxreprtaxreg);
        $this->assertEmpty($sellertaxreprtaxreg);
    }

    public function testDocumentSellerTaxRepresentativeAddress(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeAddress($sellertaxreprlineone, $sellertaxreprlinetwo, $sellertaxreprlinethree, $sellertaxreprpostcode, $sellertaxreprcity, $sellertaxreprcountry, $sellertaxreprsubdivision);
        $this->assertSame("", $sellertaxreprlineone);
        $this->assertSame("", $sellertaxreprlinetwo);
        $this->assertSame("", $sellertaxreprlinethree);
        $this->assertSame("", $sellertaxreprpostcode);
        $this->assertSame("", $sellertaxreprcity);
        $this->assertSame("", $sellertaxreprcountry);
        $this->assertIsArray($sellertaxreprsubdivision);
        $this->assertEmpty($sellertaxreprsubdivision);
    }

    public function testDocumentSellerTaxRepresentativeLegalOrganization(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeLegalOrganisation($sellertaxreprlegalorgid, $sellertaxreprlegalorgtype, $sellertaxreprlegalorgname);
        $this->assertSame("", $sellertaxreprlegalorgid);
        $this->assertSame("", $sellertaxreprlegalorgtype);
        $this->assertSame("", $sellertaxreprlegalorgname);
    }

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

    public function testDocumentShipToGeneral(): void
    {
        self::$document->getDocumentShipTo($shiptoname, $shiptoids, $shiptodescription);
        $this->assertNotNull($shiptoname);
        $this->assertSame("", $shiptoname);
        $this->assertIsArray($shiptoids);
        $this->assertEmpty($shiptoids);
        $this->assertNotNull($shiptodescription);
        $this->assertSame("", $shiptodescription);
    }

    public function testDocumentShipToGlobalId(): void
    {
        self::$document->getDocumentShipToGlobalId($shiptoglobalids);
        $this->assertIsArray($shiptoglobalids);
        $this->assertEmpty($shiptoglobalids);
    }

    public function testDocumentShipToTaxRegistration(): void
    {
        self::$document->getDocumentShipToTaxRegistration($shiptotaxreg);
        $this->assertIsArray($shiptotaxreg);
        $this->assertEmpty($shiptotaxreg);
    }

    public function testDocumentShipToAddress(): void
    {
        self::$document->getDocumentShipToAddress($shiptolineone, $shiptolinetwo, $shiptolinethree, $shiptopostcode, $shiptocity, $shiptocountry, $shiptosubdivision);
        $this->assertSame("", $shiptolineone);
        $this->assertSame("", $shiptolinetwo);
        $this->assertSame("", $shiptolinethree);
        $this->assertSame("", $shiptopostcode);
        $this->assertSame("", $shiptocity);
        $this->assertSame("", $shiptocountry);
        $this->assertIsArray($shiptosubdivision);
        $this->assertEmpty($shiptosubdivision);
    }

    public function testDocumentShipToLegalOrganization(): void
    {
        self::$document->getDocumentShipToLegalOrganisation($shiptolegalorgid, $shiptolegalorgtype, $shiptolegalorgname);
        $this->assertSame("", $shiptolegalorgid);
        $this->assertSame("", $shiptolegalorgtype);
        $this->assertSame("", $shiptolegalorgname);
    }

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

    public function testDocumentUltimateShipToGeneral(): void
    {
        self::$document->getDocumentUltimateShipTo($ultimateshiptoname, $ultimateshiptoids, $ultimateshiptodescription);
        $this->assertSame("", $ultimateshiptoname);
        $this->assertIsArray($ultimateshiptoids);
        $this->assertEmpty($ultimateshiptoids);
        $this->assertSame("", $ultimateshiptodescription);
    }

    public function testDocumentUltimateShipToGlobalId(): void
    {
        self::$document->getDocumentUltimateShipToGlobalId($ultimateshiptoglobalids);
        $this->assertIsArray($ultimateshiptoglobalids);
        $this->assertEmpty($ultimateshiptoglobalids);
    }

    public function testDocumentUltimateShipToTaxRegistration(): void
    {
        self::$document->getDocumentUltimateShipToTaxRegistration($ultimateshiptotaxreg);
        $this->assertIsArray($ultimateshiptotaxreg);
        $this->assertEmpty($ultimateshiptotaxreg);
    }

    public function testDocumentUltimateShipToAddress(): void
    {
        self::$document->getDocumentUltimateShipToAddress($ultimateshiptolineone, $ultimateshiptolinetwo, $ultimateshiptolinethree, $ultimateshiptopostcode, $ultimateshiptocity, $ultimateshiptocountry, $ultimateshiptosubdivision);
        $this->assertSame("", $ultimateshiptolineone);
        $this->assertSame("", $ultimateshiptolinetwo);
        $this->assertSame("", $ultimateshiptolinethree);
        $this->assertSame("", $ultimateshiptopostcode);
        $this->assertSame("", $ultimateshiptocity);
        $this->assertSame("", $ultimateshiptocountry);
        $this->assertIsArray($ultimateshiptosubdivision);
        $this->assertEmpty($ultimateshiptosubdivision);
    }

    public function testDocumentUltimateShipToLegalOrganization(): void
    {
        self::$document->getDocumentUltimateShipToLegalOrganisation($ultimateshiptolegalorgid, $ultimateshiptolegalorgtype, $ultimateshiptolegalorgname);
        $this->assertSame("", $ultimateshiptolegalorgid);
        $this->assertSame("", $ultimateshiptolegalorgtype);
        $this->assertSame("", $ultimateshiptolegalorgname);
    }

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

    public function testDocumentShipFromGeneral(): void
    {
        self::$document->getDocumentShipFrom($shipfromname, $shipfromids, $shipfromdescription);
        $this->assertSame("", $shipfromname);
        $this->assertIsArray($shipfromids);
        $this->assertEmpty($shipfromids);
        $this->assertSame("", $shipfromdescription);
    }

    public function testDocumentShipFromGlobalId(): void
    {
        self::$document->getDocumentShipFromGlobalId($shipfromglobalids);
        $this->assertIsArray($shipfromglobalids);
        $this->assertEmpty($shipfromglobalids);
    }

    public function testDocumentShipFromTaxRegistration(): void
    {
        self::$document->getDocumentShipFromTaxRegistration($shipfromtaxreg);
        $this->assertIsArray($shipfromtaxreg);
        $this->assertEmpty($shipfromtaxreg);
    }

    public function testDocumentShipFromAddress(): void
    {
        self::$document->getDocumentShipFromAddress($shipfromlineone, $shipfromlinetwo, $shipfromlinethree, $shipfrompostcode, $shipfromcity, $shipfromcountry, $shipfromsubdivision);
        $this->assertSame("", $shipfromlineone);
        $this->assertSame("", $shipfromlinetwo);
        $this->assertSame("", $shipfromlinethree);
        $this->assertSame("", $shipfrompostcode);
        $this->assertSame("", $shipfromcity);
        $this->assertSame("", $shipfromcountry);
        $this->assertIsArray($shipfromsubdivision);
        $this->assertEmpty($shipfromsubdivision);
    }

    public function testDocumentShipFromLegalOrganization(): void
    {
        self::$document->getDocumentShipFromLegalOrganisation($shipfromlegalorgid, $shipfromlegalorgtype, $shipfromlegalorgname);
        $this->assertSame("", $shipfromlegalorgid);
        $this->assertSame("", $shipfromlegalorgtype);
        $this->assertSame("", $shipfromlegalorgname);
    }

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

    public function testDocumentInvoicerGeneral(): void
    {
        self::$document->getDocumentInvoicer($invoicername, $invoicerids, $invoicerdescription);
        $this->assertSame("", $invoicername);
        $this->assertIsArray($invoicerids);
        $this->assertEmpty($invoicerids);
        $this->assertSame("", $invoicerdescription);
    }

    public function testDocumentInvoicerGlobalId(): void
    {
        self::$document->getDocumentInvoicerGlobalId($invoicerglobalids);
        $this->assertIsArray($invoicerglobalids);
        $this->assertEmpty($invoicerglobalids);
    }

    public function testDocumentInvoicerTaxRegistration(): void
    {
        self::$document->getDocumentInvoicerTaxRegistration($invoicertaxreg);
        $this->assertIsArray($invoicertaxreg);
        $this->assertEmpty($invoicertaxreg);
    }

    public function testDocumentInvoicerAddress(): void
    {
        self::$document->getDocumentInvoicerAddress($invoicerlineone, $invoicerlinetwo, $invoicerlinethree, $invoicerpostcode, $invoicercity, $invoicercountry, $invoicersubdivision);
        $this->assertSame("", $invoicerlineone);
        $this->assertSame("", $invoicerlinetwo);
        $this->assertSame("", $invoicerlinethree);
        $this->assertSame("", $invoicerpostcode);
        $this->assertSame("", $invoicercity);
        $this->assertSame("", $invoicercountry);
        $this->assertIsArray($invoicersubdivision);
        $this->assertEmpty($invoicersubdivision);
    }

    public function testDocumentInvoicerLegalOrganization(): void
    {
        self::$document->getDocumentInvoicerLegalOrganisation($invoicerlegalorgid, $invoicerlegalorgtype, $invoicerlegalorgname);
        $this->assertSame("", $invoicerlegalorgid);
        $this->assertSame("", $invoicerlegalorgtype);
        $this->assertSame("", $invoicerlegalorgname);
    }

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

    public function testDocumentInvoiceeGeneral(): void
    {
        self::$document->getDocumentInvoicee($invoiceename, $invoiceeids, $invoiceedescription);
        $this->assertSame("", $invoiceename);
        $this->assertIsArray($invoiceeids);
        $this->assertEmpty($invoiceeids);
        $this->assertSame("", $invoiceedescription);
    }

    public function testDocumentInvoiceeGlobalId(): void
    {
        self::$document->getDocumentInvoiceeGlobalId($invoiceeglobalids);
        $this->assertIsArray($invoiceeglobalids);
        $this->assertEmpty($invoiceeglobalids);
    }

    public function testDocumentInvoiceeTaxRegistration(): void
    {
        self::$document->getDocumentInvoiceeTaxRegistration($invoiceetaxreg);
        $this->assertIsArray($invoiceetaxreg);
        $this->assertEmpty($invoiceetaxreg);
    }

    public function testDocumentInvoiceeAddress(): void
    {
        self::$document->getDocumentInvoiceeAddress($invoiceelineone, $invoiceelinetwo, $invoiceelinethree, $invoiceepostcode, $invoiceecity, $invoiceecountry, $invoiceesubdivision);
        $this->assertSame("", $invoiceelineone);
        $this->assertSame("", $invoiceelinetwo);
        $this->assertSame("", $invoiceelinethree);
        $this->assertSame("", $invoiceepostcode);
        $this->assertSame("", $invoiceecity);
        $this->assertSame("", $invoiceecountry);
        $this->assertIsArray($invoiceesubdivision);
        $this->assertEmpty($invoiceesubdivision);
    }

    public function testDocumentInvoiceeLegalOrganization(): void
    {
        self::$document->getDocumentInvoiceeLegalOrganisation($invoiceelegalorgid, $invoiceelegalorgtype, $invoiceelegalorgname);
        $this->assertSame("", $invoiceelegalorgid);
        $this->assertSame("", $invoiceelegalorgtype);
        $this->assertSame("", $invoiceelegalorgname);
    }

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

    public function testDocumentPayeeGeneral(): void
    {
        self::$document->getDocumentPayee($payeename, $payeeids, $payeedescription);
        $this->assertSame("", $payeename);
        $this->assertIsArray($payeeids);
        $this->assertEmpty($payeeids);
        $this->assertSame("", $payeedescription);
    }

    public function testDocumentPayeeGlobalId(): void
    {
        self::$document->getDocumentPayeeGlobalId($payeeglobalids);
        $this->assertIsArray($payeeglobalids);
        $this->assertEmpty($payeeglobalids);
    }

    public function testDocumentPayeeTaxRegistration(): void
    {
        self::$document->getDocumentPayeeTaxRegistration($payeetaxreg);
        $this->assertIsArray($payeetaxreg);
        $this->assertEmpty($payeetaxreg);
    }

    public function testDocumentPayeeAddress(): void
    {
        self::$document->getDocumentPayeeAddress($payeelineone, $payeelinetwo, $payeelinethree, $payeepostcode, $payeecity, $payeecountry, $payeesubdivision);
        $this->assertSame("", $payeelineone);
        $this->assertSame("", $payeelinetwo);
        $this->assertSame("", $payeelinethree);
        $this->assertSame("", $payeepostcode);
        $this->assertSame("", $payeecity);
        $this->assertSame("", $payeecountry);
        $this->assertIsArray($payeesubdivision);
        $this->assertEmpty($payeesubdivision);
    }

    public function testDocumentPayeeLegalOrganization(): void
    {
        self::$document->getDocumentPayeeLegalOrganisation($payeelegalorgid, $payeelegalorgtype, $payeelegalorgname);
        $this->assertSame("", $payeelegalorgid);
        $this->assertSame("", $payeelegalorgtype);
        $this->assertSame("", $payeelegalorgname);
    }

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

    public function testDocumentProductEndUserGeneral(): void
    {
        self::$document->getDocumentProductEndUser($producendusername, $producenduserids, $producenduserdescription);
        $this->assertSame("", $producendusername);
        $this->assertIsArray($producenduserids);
        $this->assertArrayNotHasKey(0, $producenduserids);
        $this->assertArrayNotHasKey(1, $producenduserids);
        $this->assertSame("", $producenduserdescription);
    }

    public function testDocumentProductEndUserGlobalId(): void
    {
        self::$document->getDocumentProductEndUserGlobalId($producenduserglobalids);
        $this->assertIsArray($producenduserglobalids);
        $this->assertArrayNotHasKey("0088", $producenduserglobalids);
    }

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

    public function testDocumentProductEndUserAddress(): void
    {
        self::$document->getDocumentProductEndUserAddress($producenduserlineone, $producenduserlinetwo, $producenduserlinethree, $producenduserpostcode, $producendusercity, $producendusercountry, $producendusersubdivision);
        $this->assertSame("", $producenduserlineone);
        $this->assertSame("", $producenduserlinetwo);
        $this->assertSame("", $producenduserlinethree);
        $this->assertSame("", $producenduserpostcode);
        $this->assertSame("", $producendusercity);
        $this->assertSame("", $producendusercountry);
        $this->assertIsArray($producendusersubdivision);
        $this->assertEmpty($producendusersubdivision);
    }

    public function testDocumentProductEndUserLegalOrganization(): void
    {
        self::$document->getDocumentProductEndUserLegalOrganisation($producenduserlegalorgid, $producenduserlegalorgtype, $producenduserlegalorgname);
        $this->assertSame("", $producenduserlegalorgid);
        $this->assertSame("", $producenduserlegalorgtype);
        $this->assertSame("", $producenduserlegalorgname);
    }

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

    public function testDocumentSellerOrderReferencedDocument(): void
    {
        self::$document->getDocumentSellerOrderReferencedDocument($sellerorderrefdocid, $sellerorderrefdocdate);
        $this->assertSame("", $sellerorderrefdocid);
        $this->assertNotInstanceOf(\DateTime::class, $sellerorderrefdocdate);
    }

    public function testDocumentBuyerOrderReferencedDocument(): void
    {
        self::$document->getDocumentBuyerOrderReferencedDocument($buyerorderrefdocid, $buyerorderrefdocdate);
        $this->assertSame("", $buyerorderrefdocid);
        $this->assertNotInstanceOf(\DateTime::class, $buyerorderrefdocdate);
    }

    public function testDocumentQuotationReferencedDocument(): void
    {
        self::$document->getDocumentQuotationReferencedDocument($quotationrefdocid, $quotationrefdocdate);
        $this->assertSame("", $quotationrefdocid);
        $this->assertNotInstanceOf(\DateTime::class, $quotationrefdocdate);
    }

    public function testDocumentContractReferencedDocument(): void
    {
        self::$document->getDocumentContractReferencedDocument($contractrefdocid, $contractrefdocdate);
        $this->assertSame("", $contractrefdocid);
        $this->assertNotInstanceOf(\DateTime::class, $contractrefdocdate);
    }

    public function testDocumentAdditionalReferencedDocuments(): void
    {
        self::$document->getDocumentAdditionalReferencedDocuments($additionalrefdocs);
        $this->assertIsArray($additionalrefdocs);
        $this->assertEmpty($additionalrefdocs);
    }

    public function testDocumentProcuringProject(): void
    {
        self::$document->getDocumentProcuringProject($projectid, $projectname);
        $this->assertSame("", $projectid);
        $this->assertSame("", $projectname);
    }

    public function testDocumentSupplyChainEvent(): void
    {
        self::$document->getDocumentSupplyChainEvent($supplychainevent);
        $this->assertInstanceOf(\DateTime::class, $supplychainevent);
        $this->assertInstanceOf("DateTime", $supplychainevent);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180305'))->format('Ymd'), $supplychainevent->format('Ymd'));
    }

    public function testDocumentDespatchAdviceReferencedDocument(): void
    {
        self::$document->getDocumentDespatchAdviceReferencedDocument($despatchdocid, $despatchdocdate);
        $this->assertSame("", $despatchdocid);
        $this->assertNotInstanceOf(\DateTime::class, $despatchdocdate);
    }

    public function testDocumentReceivingAdviceReferencedDocument(): void
    {
        self::$document->getDocumentReceivingAdviceReferencedDocument($recadvid, $recadvdate);
        $this->assertSame("", $recadvid);
        $this->assertNotInstanceOf(\DateTime::class, $recadvdate);
    }

    public function testDocumentDeliveryNoteReferencedDocument(): void
    {
        self::$document->getDocumentDeliveryNoteReferencedDocument($deliverynoterefdocid, $deliverynoterefdocdate);
        $this->assertSame("", $deliverynoterefdocid);
        $this->assertNotInstanceOf(\DateTime::class, $deliverynoterefdocdate);
    }

    public function testDocumentBillingPeriod(): void
    {
        self::$document->getDocumentBillingPeriod($docbillingperiodstart, $docbillingperiodend);
        $this->assertNotInstanceOf(\DateTime::class, $docbillingperiodstart);
        $this->assertNotInstanceOf(\DateTime::class, $docbillingperiodend);
    }

    public function testDocumentAllowanceCharges(): void
    {
        self::$document->getDocumentAllowanceCharges($docallowancecharge);
        $this->assertIsArray($docallowancecharge);
        $this->assertEmpty($docallowancecharge);
    }

    public function testDocumentPaymentTerms(): void
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
        $this->assertEquals("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018", $docpaymentterms[0]["description"]);
        $this->assertNull($docpaymentterms[0]["duedate"]);
        $this->assertNotInstanceOf("DateTime", $docpaymentterms[0]["duedate"]);
        $this->assertEquals("", $docpaymentterms[0]["directdebitmandateid"]);
        $this->assertEqualsWithDelta(0.0, $docpaymentterms[0]["partialpaymentamount"], PHP_FLOAT_EPSILON);
    }

    public function testDocumentDeliveryTerms(): void
    {
        self::$document->getDocumentDeliveryTerms($devtermcode);
        $this->assertSame("", $devtermcode);
    }

    public function testDocumentAdditionalReferencedDocumentLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentAdditionalReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentAdditionalReferencedDocument());
    }

    public function testDocumentUltimateCustomerOrderReferencedDocumentLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentUltimateCustomerOrderReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentUltimateCustomerOrderReferencedDocument());
    }

    public function testDocumentPaymentMeansLoop(): void
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        $this->assertFalse(self::$document->nextGetDocumentPaymentMeans());
    }

    public function testGetDocumentPaymentMeans(): void
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        self::$document->getDocumentPaymentMeans($typeCode, $information, $cardType, $cardId, $cardHolderName, $buyerIban, $payeeIban, $payeeAccountName, $payeePropId, $payeeBic);
        $this->assertSame("58", $typeCode);
        $this->assertSame("Zahlung per SEPA Überweisung.", $information);
        $this->assertSame("", $cardType);
        $this->assertSame("", $cardId);
        $this->assertSame("", $cardHolderName);
        $this->assertSame("", $buyerIban);
        $this->assertSame("DE02120300000000202051", $payeeIban);
        $this->assertSame("Kunden AG", $payeeAccountName);
        $this->assertSame("", $payeePropId);
        $this->assertSame("BYLADEM1001", $payeeBic);
    }

    public function testDocumentTaxLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentTax());
        $this->assertTrue(self::$document->nextDocumentTax());
    }

    public function testDocumentTax(): void
    {
        $this->assertTrue(self::$document->firstDocumentTax());
        self::$document->getDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->assertSame("S", $categoryCode);
        $this->assertSame("VAT", $typeCode);
        $this->assertEqualsWithDelta(275.0, $basisAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(19.25, $calculatedAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(7.0, $rateApplicablePercent, PHP_FLOAT_EPSILON);

        $this->assertTrue(self::$document->nextDocumentTax());
        self::$document->getDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->assertSame("S", $categoryCode);
        $this->assertSame("VAT", $typeCode);
        $this->assertEqualsWithDelta(198.0, $basisAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(37.62, $calculatedAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(19.0, $rateApplicablePercent, PHP_FLOAT_EPSILON);
    }

    public function testtDocumentAllowanceChargeLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentAllowanceCharge());
    }

    public function testtDocumentLogisticsServiceChargeLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentLogisticsServiceCharge());
        $this->assertFalse(self::$document->nextDocumentLogisticsServiceCharge());
    }

    public function testtDocumentPaymentTermsLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }

    public function testtDocumentPaymentTerms(): void
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        self::$document->getDocumentPaymentTerm($termdescription, $termduedate, $termmandate);
        self::$document->getDiscountTermsFromPaymentTerm($dispercent, $discbasedatetime, $discmeasureval, $discmeasureunit, $discbaseamount, $discamount);
        self::$document->getPenaltyTermsFromPaymentTerm($penaltypercent, $penaltybasedatetime, $penaltymeasureval, $penaltymeasureunit, $penaltybaseamount, $penaltyamount);

        $this->assertSame("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018", $termdescription);
        $this->assertNotInstanceOf(\DateTime::class, $termduedate);
        $this->assertSame("", $termmandate);
        $this->assertEquals(0, $dispercent);
        $this->assertNotInstanceOf(\DateTime::class, $discbasedatetime);
        $this->assertEquals(0, $discmeasureval);
        $this->assertSame("", $discmeasureunit);
        $this->assertEquals(0, $discbaseamount);
        $this->assertEquals(0, $discamount);
        $this->assertNotInstanceOf(\DateTime::class, $penaltybasedatetime);
        $this->assertEquals(0, $penaltymeasureval);
        $this->assertSame("", $penaltymeasureunit);
        $this->assertEquals(0, $penaltybaseamount);
        $this->assertEquals(0, $penaltyamount);

        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }

    public function testDocumentReceivableSpecifiedTradeAccountingAccount(): void
    {
        $this->assertFalse(self::$document->firstDocumentReceivableSpecifiedTradeAccountingAccount());
        $this->assertFalse(self::$document->nextDocumentReceivableSpecifiedTradeAccountingAccount());
    }

    public function testDocumentPositionLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentPosition(), "has a first position");
        $this->assertTrue(self::$document->nextDocumentPosition(), "has a second position");
        $this->assertFalse(self::$document->nextDocumentPosition(), "has no third position");
    }

    public function testDocumentPositionFirst(): void
    {
        $this->assertTrue(self::$document->firstDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertSame("1", $lineid);
        $this->assertSame("", $linestatuscode);
        $this->assertSame("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertSame("Trennblätter A4", $prodname);
        $this->assertSame("", $proddesc);
        $this->assertSame("TB100A4", $prodsellerid);
        $this->assertSame("", $prodbuyerid);
        $this->assertSame("0160", $prodglobalidtype);
        $this->assertSame("4012345001235", $prodglobalid);

        self::$document->getDocumentPositionSellerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertSame("", $doclineorderid);
        $this->assertSame("", $doclineorderlineid);
        $this->assertNotInstanceOf(\DateTime::class, $doclineorderdate);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertSame("", $doclineorderid);
        $this->assertSame("", $doclineorderlineid);
        $this->assertNotInstanceOf(\DateTime::class, $doclineorderdate);

        self::$document->getDocumentPositionQuotationReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertSame("", $doclinecontid);
        $this->assertSame("", $doclinecontlineid);
        $this->assertNotInstanceOf(\DateTime::class, $doclinecontdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertSame("", $doclinecontid);
        $this->assertSame("", $doclinecontlineid);
        $this->assertNotInstanceOf(\DateTime::class, $doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEqualsWithDelta(9.90, $grosspriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $grosspricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEqualsWithDelta(9.90, $netpriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $netpricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $netpricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPriceTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertSame("", $categoryCode);
        $this->assertSame("", $typeCode);
        $this->assertEqualsWithDelta(0.0, $rateApplicablePercent, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $calculatedAmount, PHP_FLOAT_EPSILON);
        $this->assertSame("", $exemptionReason);
        $this->assertSame("", $exemptionReasonCode);

        self::$document->getDocumentPositionQuantity($billedquantity, $billedquantityunitcode, $chargeFreeQuantity, $chargeFreeQuantityunitcode, $packageQuantity, $packageQuantityunitcode);
        $this->assertEqualsWithDelta(20.0, $billedquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("H87", $billedquantityunitcode);
        $this->assertEqualsWithDelta(0.0, $chargeFreeQuantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $chargeFreeQuantityunitcode);
        $this->assertEqualsWithDelta(0.0, $packageQuantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $packageQuantityunitcode);

        self::$document->getDocumentPositionDespatchAdviceReferencedDocument($docposdespadvid, $docposdespadvlineid, $docposdespadvdatetime);
        $this->assertSame("", $docposdespadvid);
        $this->assertSame("", $docposdespadvlineid);
        $this->assertNotInstanceOf(\DateTime::class, $docposdespadvdatetime);

        self::$document->getDocumentPositionReceivingAdviceReferencedDocument($docposrecadvid, $docposrecadvlineid, $docposrecadvdatetime);
        $this->assertSame("", $docposrecadvid);
        $this->assertSame("", $docposrecadvlineid);
        $this->assertNotInstanceOf(\DateTime::class, $docposrecadvdatetime);

        self::$document->getDocumentPositionDeliveryNoteReferencedDocument($docposdelnoteid, $docposdelnotelineid, $docposdelnotedatetime);
        $this->assertSame("", $docposdelnoteid);
        $this->assertSame("", $docposdelnotelineid);
        $this->assertNotInstanceOf(\DateTime::class, $docposdelnotedatetime);

        self::$document->getDocumentPositionBillingPeriod($docposstartdate, $docpostenddate);
        $this->assertNotInstanceOf(\DateTime::class, $docposstartdate);
        $this->assertNotInstanceOf(\DateTime::class, $docpostenddate);

        $this->assertFalse(self::$document->firstDocumentPositionNote());
        $this->assertFalse(self::$document->nextDocumentPositionNote());

        $this->assertFalse(self::$document->firstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentPositionGrossPriceAllowanceCharge());

        $this->assertTrue(self::$document->firstDocumentPositionTax());
        $this->assertFalse(self::$document->nextDocumentPositionTax());

        self::$document->firstDocumentPositionTax();
        self::$document->getDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertSame("S", $categoryCode);
        $this->assertSame("VAT", $typeCode);
        $this->assertEqualsWithDelta(19.0, $rateApplicablePercent, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $calculatedAmount, PHP_FLOAT_EPSILON);
        $this->assertSame("", $exemptionReason);
        $this->assertSame("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummationSimple($lineTotalAmount);
        $this->assertEqualsWithDelta(198.0, $lineTotalAmount, PHP_FLOAT_EPSILON);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNotInstanceOf(\DateTime::class, $supplyeventdatetime);
    }

    public function testDocumentPositionSecond(): void
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertSame("2", $lineid);
        $this->assertSame("", $linestatuscode);
        $this->assertSame("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertSame("Joghurt Banane", $prodname);
        $this->assertSame("", $proddesc);
        $this->assertSame("ARNR2", $prodsellerid);
        $this->assertSame("", $prodbuyerid);
        $this->assertSame("0160", $prodglobalidtype);
        $this->assertSame("4000050986428", $prodglobalid);

        self::$document->getDocumentPositionSellerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertSame("", $doclineorderid);
        $this->assertSame("", $doclineorderlineid);
        $this->assertNotInstanceOf(\DateTime::class, $doclineorderdate);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertSame("", $doclineorderid);
        $this->assertSame("", $doclineorderlineid);
        $this->assertNotInstanceOf(\DateTime::class, $doclineorderdate);

        self::$document->getDocumentPositionQuotationReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertSame("", $doclinecontid);
        $this->assertSame("", $doclinecontlineid);
        $this->assertNotInstanceOf(\DateTime::class, $doclinecontdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertSame("", $doclinecontid);
        $this->assertSame("", $doclinecontlineid);
        $this->assertNotInstanceOf(\DateTime::class, $doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEqualsWithDelta(5.50, $grosspriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $grosspricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEqualsWithDelta(5.50, $netpriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $netpricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $netpricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPriceTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertSame("", $categoryCode);
        $this->assertSame("", $typeCode);
        $this->assertEqualsWithDelta(0.0, $rateApplicablePercent, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $calculatedAmount, PHP_FLOAT_EPSILON);
        $this->assertSame("", $exemptionReason);
        $this->assertSame("", $exemptionReasonCode);

        self::$document->getDocumentPositionQuantity($billedquantity, $billedquantityunitcode, $chargeFreeQuantity, $chargeFreeQuantityunitcode, $packageQuantity, $packageQuantityunitcode);
        $this->assertEqualsWithDelta(50.0, $billedquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("H87", $billedquantityunitcode);
        $this->assertEqualsWithDelta(0.0, $chargeFreeQuantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $chargeFreeQuantityunitcode);
        $this->assertEqualsWithDelta(0.0, $packageQuantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $packageQuantityunitcode);

        self::$document->getDocumentPositionDespatchAdviceReferencedDocument($docposdespadvid, $docposdespadvlineid, $docposdespadvdatetime);
        $this->assertSame("", $docposdespadvid);
        $this->assertSame("", $docposdespadvlineid);
        $this->assertNotInstanceOf(\DateTime::class, $docposdespadvdatetime);

        self::$document->getDocumentPositionReceivingAdviceReferencedDocument($docposrecadvid, $docposrecadvlineid, $docposrecadvdatetime);
        $this->assertSame("", $docposrecadvid);
        $this->assertSame("", $docposrecadvlineid);
        $this->assertNotInstanceOf(\DateTime::class, $docposrecadvdatetime);

        self::$document->getDocumentPositionDeliveryNoteReferencedDocument($docposdelnoteid, $docposdelnotelineid, $docposdelnotedatetime);
        $this->assertSame("", $docposdelnoteid);
        $this->assertSame("", $docposdelnotelineid);
        $this->assertNotInstanceOf(\DateTime::class, $docposdelnotedatetime);

        self::$document->getDocumentPositionBillingPeriod($docposstartdate, $docpostenddate);
        $this->assertNotInstanceOf(\DateTime::class, $docposstartdate);
        $this->assertNotInstanceOf(\DateTime::class, $docpostenddate);

        $this->assertFalse(self::$document->firstDocumentPositionNote());
        $this->assertFalse(self::$document->nextDocumentPositionNote());

        $this->assertFalse(self::$document->firstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentPositionGrossPriceAllowanceCharge());

        $this->assertTrue(self::$document->firstDocumentPositionTax());
        $this->assertFalse(self::$document->nextDocumentPositionTax());

        self::$document->firstDocumentPositionTax();
        self::$document->getDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertSame("S", $categoryCode);
        $this->assertSame("VAT", $typeCode);
        $this->assertEqualsWithDelta(7.0, $rateApplicablePercent, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $calculatedAmount, PHP_FLOAT_EPSILON);
        $this->assertSame("", $exemptionReason);
        $this->assertSame("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummationSimple($lineTotalAmount);
        $this->assertEqualsWithDelta(275.0, $lineTotalAmount, PHP_FLOAT_EPSILON);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNotInstanceOf(\DateTime::class, $supplyeventdatetime);
    }

    public function testDocumentPositionAdditionalReferencedDocument(): void
    {
        $this->assertFalse(self::$document->firstDocumentPositionAdditionalReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentPositionAdditionalReferencedDocument());
    }
}
