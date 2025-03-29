<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdDocumentPdfReader;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;

class PdfReaderExtendedTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public function testCanReadPdf(): void
    {
        self::$document = ZugferdDocumentPdfReader::readAndGuessFromFile(__DIR__ . "/../assets/pdf_zf_extended_1.pdf");
        $this->assertNotNull(self::$document);
    }

    public function testDocumentProfile(): void
    {
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->getProfileId());
        $this->assertEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_XRECHNUNG, self::$document->getProfileId());
    }

    public function testDocumentGenerals(): void
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertSame('KR87654321012', $documentno);
        $this->assertSame(ZugferdInvoiceType::INVOICE, $documenttypecode);
        $this->assertInstanceOf(\DateTime::class, $documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20181006'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertSame("EUR", $invoiceCurrency);
        $this->assertSame("", $taxCurrency);
        $this->assertSame("KOSTENRECHNUNG", $documentname);
        $this->assertSame("", $documentlanguage);
        $this->assertNotInstanceOf(\DateTime::class, $effectiveSpecifiedPeriod);
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
        $this->assertInstanceOf('horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice', $this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
    }

    public function testDocumentNotes(): void
    {
        self::$document->getDocumentNotes($notes);
        $this->assertIsArray($notes);
        $this->assertNotEmpty($notes);
        $this->assertCount(3, $notes);
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
        $this->assertTrue($istest);
    }

    public function testDocumentSummation(): void
    {
        self::$document->getDocumentSummation($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);
        $this->assertEqualsWithDelta(480.22, $grandTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(480.22, $duePayableAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(410.10, $lineTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(15.00, $chargeTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(21.55, $allowanceTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(403.55, $taxBasisTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(76.67, $taxTotalAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.00, $roundingAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.00, $totalPrepaidAmount, PHP_FLOAT_EPSILON);
    }

    public function testDocumentSellerGeneral(): void
    {
        self::$document->getDocumentSeller($sellername, $sellerids, $sellerdescription);
        $this->assertSame("MUSTERLIEFERANT GMBH", $sellername);
        $this->assertIsArray($sellerids);
        $this->assertArrayHasKey(0, $sellerids);
        $this->assertArrayNotHasKey(1, $sellerids);
        $this->assertEquals("549910", $sellerids[0]);
        $this->assertSame("", $sellerdescription);
    }

    public function testDocumentSellerGlobalId(): void
    {
        self::$document->getDocumentSellerGlobalId($sellerglobalids);
        $this->assertIsArray($sellerglobalids);
        $this->assertArrayHasKey("0088", $sellerglobalids);
        $this->assertEquals("4333741000005", $sellerglobalids["0088"]);
    }

    public function testDocumentSellerTaxRegistration(): void
    {
        self::$document->getDocumentSellerTaxRegistration($sellertaxreg);
        $this->assertIsArray($sellertaxreg);
        $this->assertArrayNotHasKey("VA", $sellertaxreg);
        $this->assertArrayHasKey("FC", $sellertaxreg);
        $this->assertArrayNotHasKey(0, $sellertaxreg);
        $this->assertArrayNotHasKey(1, $sellertaxreg);
        $this->assertArrayNotHasKey("ZZ", $sellertaxreg);
        $this->assertEquals("201/113/40209", $sellertaxreg["FC"]);
    }

    public function testDocumentSellerAddress(): void
    {
        self::$document->getDocumentSellerAddress($sellerlineone, $sellerlinetwo, $sellerlinethree, $sellerpostcode, $sellercity, $sellercountry, $sellersubdivision);
        $this->assertSame("BAHNHOFSTRASSE 99", $sellerlineone);
        $this->assertSame("", $sellerlinetwo);
        $this->assertSame("", $sellerlinethree);
        $this->assertSame("99199", $sellerpostcode);
        $this->assertSame("MUSTERHAUSEN", $sellercity);
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
        $this->assertSame("", $sellercontactpersonname);
        $this->assertSame("", $sellercontactdepartmentname);
        $this->assertSame("+49 932 431 500", $sellercontactphoneno);
        $this->assertSame("", $sellercontactfaxno);
        $this->assertSame("max.mustermann@musterlieferant.de", $sellercontactemailaddr);
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
        $this->assertSame("MUSTER-KUNDE GMBH", $buyername);
        $this->assertIsArray($buyerids);
        $this->assertArrayHasKey(0, $buyerids);
        $this->assertArrayNotHasKey(1, $buyerids);
        $this->assertEquals("339420", $buyerids[0]);
        $this->assertSame("", $buyerdescription);
    }

    public function testDocumentBuyerGlobalId(): void
    {
        self::$document->getDocumentBuyerGlobalId($buyerglobalids);
        $this->assertIsArray($buyerglobalids);
        $this->assertArrayHasKey("0088", $buyerglobalids);
        $this->assertEquals("4304171000002", $buyerglobalids["0088"]);
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
        $this->assertSame("KUNDENWEG 88", $buyerlineone);
        $this->assertSame("", $buyerlinetwo);
        $this->assertSame("", $buyerlinethree);
        $this->assertSame("40235", $buyerpostcode);
        $this->assertSame("DUESSELDORF", $buyercity);
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
        $this->assertSame("MUSTER-MARKT", $shiptoname);
        $this->assertIsArray($shiptoids);
        $this->assertEmpty($shiptoids);
        $this->assertSame("", $shiptodescription);
    }

    public function testDocumentShipToGlobalId(): void
    {
        self::$document->getDocumentShipToGlobalId($shiptoglobalids);
        $this->assertIsArray($shiptoglobalids);
        $this->assertArrayHasKey("0088", $shiptoglobalids);
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
        $this->assertSame("HAUPTSTRASSE 44", $shiptolineone);
        $this->assertSame("", $shiptolinetwo);
        $this->assertSame("", $shiptolinethree);
        $this->assertSame("31157", $shiptopostcode);
        $this->assertSame("SARSTEDT", $shiptocity);
        $this->assertSame("DE", $shiptocountry);
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
        $this->assertTrue(self::$document->firstDocumentShipToContact());
        self::$document->getDocumentShipToContact($shiptocontactpersonname, $shiptocontactdepartmentname, $shiptocontactphoneno, $shiptocontactfaxno, $shiptocontactemailaddr);
        $this->assertSame("", $shiptocontactpersonname);
        $this->assertSame("7322", $shiptocontactdepartmentname);
        $this->assertSame("", $shiptocontactphoneno);
        $this->assertSame("", $shiptocontactfaxno);
        $this->assertSame("", $shiptocontactemailaddr);
        $this->assertFalse(self::$document->nextDocumentShipToContact());
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
        $this->assertSame("MUSTER-KUNDE GMBH", $invoiceename);
        $this->assertIsArray($invoiceeids);
        $this->assertNotEmpty($invoiceeids);
        $this->assertArrayHasKey(0, $invoiceeids);
        $this->assertSame("", $invoiceedescription);
    }

    public function testDocumentInvoiceeGlobalId(): void
    {
        self::$document->getDocumentInvoiceeGlobalId($invoiceeglobalids);
        $this->assertIsArray($invoiceeglobalids);
        $this->assertNotEmpty($invoiceeglobalids);
        $this->assertArrayHasKey("0088", $invoiceeglobalids);
        $this->assertEquals("4304171000002", $invoiceeglobalids["0088"]);
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
        $this->assertSame("KUNDENWEG 88", $invoiceelineone);
        $this->assertSame("", $invoiceelinetwo);
        $this->assertSame("", $invoiceelinethree);
        $this->assertSame("40235", $invoiceepostcode);
        $this->assertSame("DUESSELDORF", $invoiceecity);
        $this->assertSame("DE", $invoiceecountry);
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
        $this->assertNotEmpty($additionalrefdocs);
        $this->assertArrayHasKey(0, $additionalrefdocs);
        $this->assertIsArray($additionalrefdocs[0]);
        $this->assertArrayHasKey("IssuerAssignedID", $additionalrefdocs[0]);
        $this->assertArrayHasKey("TypeCode", $additionalrefdocs[0]);
        $this->assertEquals("A777123", $additionalrefdocs[0]["IssuerAssignedID"]);
        $this->assertEquals("130", $additionalrefdocs[0]["TypeCode"]);
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
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180930'))->format('Ymd'), $supplychainevent->format('Ymd'));
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
        $this->assertSame("L87654321012", $deliverynoterefdocid);
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
        $this->assertNotEmpty($docallowancecharge);
        $this->assertCount(1, $docallowancecharge);
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
        $this->assertEquals("Skontovereinbarung: 2% bei Zahlung innerhalb 10 Tagen nach Rechnungsdatum", $docpaymentterms[0]["description"]);
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
        $this->assertTrue(self::$document->firstDocumentAdditionalReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentAdditionalReferencedDocument());
    }

    public function testGetDocumentAdditionalReferencedDocument(): void
    {
        $this->assertTrue(self::$document->firstDocumentAdditionalReferencedDocument());
        self::$document->getDocumentAdditionalReferencedDocument($issuerassignedid, $typecode, $uriid, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->assertSame("A777123", $issuerassignedid);
        $this->assertSame("130", $typecode);
        $this->assertSame("", $uriid);
        $this->assertIsArray($name);
        $this->assertEmpty($name);
        $this->assertSame("", $reftypecode);
        $this->assertNotInstanceOf(\DateTime::class, $issueddate);
        $this->assertSame("", $binarydatafilename);
    }

    public function testDocumentUltimateCustomerOrderReferencedDocumentLoop(): void
    {
        $this->assertFalse(self::$document->firstDocumentUltimateCustomerOrderReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentUltimateCustomerOrderReferencedDocument());
    }

    public function testDocumentPaymentMeansLoop(): void
    {
        $this->assertFalse(self::$document->firstGetDocumentPaymentMeans());
        $this->assertFalse(self::$document->nextGetDocumentPaymentMeans());
    }

    public function testDocumentTaxLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentTax());
        $this->assertFalse(self::$document->nextDocumentTax());
    }

    public function testDocumentTax(): void
    {
        $this->assertTrue(self::$document->firstDocumentTax());
        self::$document->getDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->assertSame("S", $categoryCode);
        $this->assertSame("VAT", $typeCode);
        $this->assertEqualsWithDelta(403.55, $basisAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(76.67, $calculatedAmount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(19.0, $rateApplicablePercent, PHP_FLOAT_EPSILON);
        $this->assertSame(-6.55, $allowanceChargeBasisAmount);
    }

    public function testtDocumentAllowanceChargeLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentAllowanceCharge());
    }


    public function testtDocumentAllowanceCharge(): void
    {
        $this->assertTrue(self::$document->firstDocumentAllowanceCharge());
        self::$document->getDocumentAllowanceCharge($actualAmount, $isCharge, $taxCategoryCode, $taxTypeCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->assertEqualsWithDelta(21.55, $actualAmount, PHP_FLOAT_EPSILON);
        $this->assertFalse($isCharge);
        $this->assertSame("S", $taxCategoryCode);
        $this->assertSame("VAT", $taxTypeCode);
        $this->assertEqualsWithDelta(19.00, $rateApplicablePercent, PHP_FLOAT_EPSILON);
        $this->assertEquals(0, $sequence);
        $this->assertEquals(0, $calculationPercent);
        $this->assertEqualsWithDelta(410.10, $basisAmount, PHP_FLOAT_EPSILON);
        $this->assertEquals(0, $basisQuantity);
        $this->assertSame("", $basisQuantityUnitCode);
        $this->assertSame("", $reasonCode);
        $this->assertSame("Sonderrabatt", $reason);
    }

    public function testtDocumentLogisticsServiceChargeLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentLogisticsServiceCharge());
        $this->assertFalse(self::$document->nextDocumentLogisticsServiceCharge());
    }

    public function testGetDocumentLogisticsServiceCharge(): void
    {
        $this->assertTrue(self::$document->firstDocumentLogisticsServiceCharge());
        self::$document->getDocumentLogisticsServiceCharge($description, $appliedAmount, $taxTypeCodes, $taxCategoryCodes, $rateApplicablePercents);
        $this->assertSame("Transportkosten: Frachbetrag", $description);
        $this->assertEqualsWithDelta(15.00, $appliedAmount, PHP_FLOAT_EPSILON);
        $this->assertIsArray($taxTypeCodes);
        $this->assertCount(1, $taxTypeCodes);
        $this->assertArrayHasKey(0, $taxTypeCodes);
        $this->assertEquals("VAT", $taxTypeCodes[0]);
        $this->assertIsArray($taxCategoryCodes);
        $this->assertCount(1, $taxCategoryCodes);
        $this->assertArrayHasKey(0, $taxCategoryCodes);
        $this->assertEquals("S", $taxCategoryCodes[0]);
        $this->assertIsArray($rateApplicablePercents);
        $this->assertCount(1, $rateApplicablePercents);
        $this->assertArrayHasKey(0, $rateApplicablePercents);
        $this->assertEqualsWithDelta(19.0, $rateApplicablePercents[0], PHP_FLOAT_EPSILON);
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

        $this->assertSame("Skontovereinbarung: 2% bei Zahlung innerhalb 10 Tagen nach Rechnungsdatum", $termdescription);
        $this->assertNotInstanceOf(\DateTime::class, $termduedate);
        $this->assertSame("", $termmandate);
        $this->assertEqualsWithDelta(2.0, $dispercent, PHP_FLOAT_EPSILON);
        $this->assertNotInstanceOf(\DateTime::class, $discbasedatetime);
        $this->assertEquals(10, $discmeasureval);
        $this->assertSame("DAY", $discmeasureunit);
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
        $this->assertTrue(self::$document->firstDocumentPosition());
        $this->assertTrue(self::$document->nextDocumentPosition());
        $this->assertTrue(self::$document->nextDocumentPosition());
        $this->assertTrue(self::$document->nextDocumentPosition());
        $this->assertTrue(self::$document->nextDocumentPosition());
        $this->assertFalse(self::$document->nextDocumentPosition());
    }

    public function testDocumentPositionFirst(): void
    {
        $this->assertTrue(self::$document->firstDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertSame("1", $lineid);
        $this->assertSame("", $linestatuscode);
        $this->assertSame("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertSame("Wirkarbeit HT", $prodname);
        $this->assertSame("", $proddesc);
        $this->assertSame("WA997", $prodsellerid);
        $this->assertSame("", $prodbuyerid);
        $this->assertSame("0088", $prodglobalidtype);
        $this->assertSame("4123456000014", $prodglobalid);

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
        $this->assertEqualsWithDelta(0.0520, $grosspriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $grosspricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEqualsWithDelta(0.0520, $netpriceamount, PHP_FLOAT_EPSILON);
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
        $this->assertEqualsWithDelta(10000.0, $billedquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("KWH", $billedquantityunitcode);
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
        $this->assertEqualsWithDelta(52.00, $lineTotalAmount, PHP_FLOAT_EPSILON);

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
        $this->assertSame("Ökosteuer Lieferant", $prodname);
        $this->assertSame("", $proddesc);
        $this->assertSame("ÖST250", $prodsellerid);
        $this->assertSame("", $prodbuyerid);
        $this->assertSame("0088", $prodglobalidtype);
        $this->assertSame("4123456000021", $prodglobalid);

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
        $this->assertEqualsWithDelta(0.0205, $grosspriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $grosspricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEqualsWithDelta(0.0205, $netpriceamount, PHP_FLOAT_EPSILON);
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
        $this->assertEquals(10000, $billedquantity);
        $this->assertSame("KWH", $billedquantityunitcode);
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
        $this->assertEqualsWithDelta(20.50, $lineTotalAmount, PHP_FLOAT_EPSILON);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNotInstanceOf(\DateTime::class, $supplyeventdatetime);
    }

    public function testDocumentPositionThird(): void
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertSame("3", $lineid);
        $this->assertSame("", $linestatuscode);
        $this->assertSame("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertSame("Kommissionierer 1250032 D. Muster", $prodname);
        $this->assertSame("Besteller: Hr. Mayer, Personalnr. 4488", $proddesc);
        $this->assertSame("", $prodsellerid);
        $this->assertSame("", $prodbuyerid);
        $this->assertSame("0088", $prodglobalidtype);
        $this->assertSame("4260331811362", $prodglobalid);

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
        $this->assertEqualsWithDelta(15.0000, $grosspriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $grosspricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEqualsWithDelta(10.5000, $netpriceamount, PHP_FLOAT_EPSILON);
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
        $this->assertEqualsWithDelta(27.5000, $billedquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("HUR", $billedquantityunitcode);
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

        $this->assertTrue(self::$document->firstDocumentPositionGrossPriceAllowanceCharge());
        $this->assertFalse(self::$document->nextDocumentPositionGrossPriceAllowanceCharge());

        self::$document->firstDocumentPositionGrossPriceAllowanceCharge();
        self::$document->getDocumentPositionGrossPriceAllowanceCharge(
            $docPosAllowanceChargeactualAmount,
            $docPosAllowanceChargeisCharge,
            $docPosAllowanceChargecalculationPercent,
            $docPosAllowanceChargebasisAmount,
            $docPosAllowanceChargereason,
            $docPosAllowanceChargeTaxTypeCode,
            $docPosAllowanceChargeTaxCategoryCode,
            $docPosAllowanceChargerateApplicablePercent,
            $docPosAllowanceChargesequence,
            $docPosAllowanceChargebasisQuantity,
            $docPosAllowanceChargebasisQuantityUnitCode,
            $docPosAllowanceChargereasonCode
        );
        $this->assertEqualsWithDelta(4.5000, $docPosAllowanceChargeactualAmount, PHP_FLOAT_EPSILON);
        $this->assertFalse($docPosAllowanceChargeisCharge);
        $this->assertEquals(0, $docPosAllowanceChargecalculationPercent);
        $this->assertEquals(0, $docPosAllowanceChargebasisAmount);
        $this->assertSame("Artikelrabatt 1", $docPosAllowanceChargereason);
        $this->assertSame("", $docPosAllowanceChargeTaxTypeCode);
        $this->assertSame("", $docPosAllowanceChargeTaxCategoryCode);
        $this->assertEquals(0, $docPosAllowanceChargerateApplicablePercent);
        $this->assertEquals(0, $docPosAllowanceChargesequence);
        $this->assertEquals(0, $docPosAllowanceChargebasisQuantity);
        $this->assertSame("", $docPosAllowanceChargebasisQuantityUnitCode);
        $this->assertSame("", $docPosAllowanceChargereasonCode);

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
        $this->assertEqualsWithDelta(288.75, $lineTotalAmount, PHP_FLOAT_EPSILON);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNotInstanceOf(\DateTime::class, $supplyeventdatetime);
    }

    public function testDocumentPositionFourth(): void
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertSame("4", $lineid);
        $this->assertSame("", $linestatuscode);
        $this->assertSame("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertSame("FALTENBEUTEL 16x6x28 CM", $prodname);
        $this->assertSame("", $proddesc);
        $this->assertSame("FB05", $prodsellerid);
        $this->assertSame("", $prodbuyerid);
        $this->assertSame("0088", $prodglobalidtype);
        $this->assertSame("2001015001325", $prodglobalid);

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
        $this->assertEqualsWithDelta(0.0105, $grosspriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $grosspricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEqualsWithDelta(0.0105, $netpriceamount, PHP_FLOAT_EPSILON);
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
        $this->assertEqualsWithDelta(3500.0, $billedquantity, PHP_FLOAT_EPSILON);
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
        $this->assertEqualsWithDelta(36.75, $lineTotalAmount, PHP_FLOAT_EPSILON);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNotInstanceOf(\DateTime::class, $supplyeventdatetime);
    }

    public function testDocumentPositionFifth(): void
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertSame("5", $lineid);
        $this->assertSame("", $linestatuscode);
        $this->assertSame("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertSame("Kopierpapier A4", $prodname);
        $this->assertSame("Zählerstand von-bis: 543210 - 544420", $proddesc);
        $this->assertSame("KOP05", $prodsellerid);
        $this->assertSame("", $prodbuyerid);
        $this->assertSame("0088", $prodglobalidtype);
        $this->assertSame("4123456000038", $prodglobalid);

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
        $this->assertEqualsWithDelta(0.0100, $grosspriceamount, PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(0.0, $grosspricebasisquantity, PHP_FLOAT_EPSILON);
        $this->assertSame("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEqualsWithDelta(0.0100, $netpriceamount, PHP_FLOAT_EPSILON);
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
        $this->assertEqualsWithDelta(1210.0, $billedquantity, PHP_FLOAT_EPSILON);
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
        $this->assertEqualsWithDelta(12.10, $lineTotalAmount, PHP_FLOAT_EPSILON);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNotInstanceOf(\DateTime::class, $supplyeventdatetime);
    }

    public function testDocumentPositionAdditionalReferencedDocument(): void
    {
        $this->assertFalse(self::$document->firstDocumentPositionAdditionalReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentPositionAdditionalReferencedDocument());
    }
}
