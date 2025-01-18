<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

class ReaderExtendedTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . "/../assets/xml_extended_1.xml");
    }

    public function testDocumentProfile(): void
    {
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->getProfileId());
        $this->assertEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
    }

    public function testDocumentGetters(): void
    {
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
        $this->assertEquals('horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice', get_class($this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject')));
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getSerializer'));
        $this->assertEquals(\JMS\Serializer\Serializer::class, get_class($this->invokePrivateMethodFromObject(self::$document, 'getSerializer')));
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getObjectHelper'));
        $this->assertEquals('horstoeko\zugferd\ZugferdObjectHelper', get_class($this->invokePrivateMethodFromObject(self::$document, 'getObjectHelper')));
        $this->assertEquals('extended', self::$document->getProfileDefinitionParameter('name'));
        $this->assertEquals('EXTENDED', self::$document->getProfileDefinitionParameter('altname'));
        $this->assertEquals('urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended', self::$document->getProfileDefinitionParameter('contextparameter'));
        $this->assertEquals('factur-x.xml', self::$document->getProfileDefinitionParameter('attachmentfilename'));
        $this->assertEquals('EXTENDED', self::$document->getProfileDefinitionParameter('xmpname'));
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getProfileDefinitionParameter('unknownparameter');
            }
        );
    }

    public function testDocumentGenerals(): void
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('KR87654321012', $documentno);
        $this->assertEquals(ZugferdInvoiceType::INVOICE, $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20181006'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertEquals("EUR", $invoiceCurrency);
        $this->assertEquals("", $taxCurrency);
        $this->assertEquals("KOSTENRECHNUNG", $documentname);
        $this->assertEquals("", $documentlanguage);
        $this->assertNull($effectiveSpecifiedPeriod);
    }

    public function testDocumentNotes(): void
    {
        self::$document->getDocumentNotes($notes);
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

    public function testDocumentGeneralPaymentInformation(): void
    {
        self::$document->getDocumentGeneralPaymentInformation($creditorReferenceID, $paymentReference);
        $this->assertEquals("", $creditorReferenceID);
        $this->assertEquals("", $paymentReference);
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

    public function testGetDocumentBuyerReference(): void
    {
        self::$document->getDocumentBuyerReference($buyerReference);
        $this->assertEquals("08154712", $buyerReference);
    }

    public function testDocumentSellerGeneral(): void
    {
        self::$document->getDocumentSeller($sellername, $sellerids, $sellerdescription);
        $this->assertEquals("MUSTERLIEFERANT GMBH", $sellername);
        $this->assertIsArray($sellerids);
        $this->assertArrayHasKey(0, $sellerids);
        $this->assertArrayNotHasKey(1, $sellerids);
        $this->assertEquals("549910", $sellerids[0]);
        $this->assertEquals("", $sellerdescription);
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
        $this->assertEquals("BAHNHOFSTRASSE 99", $sellerlineone);
        $this->assertEquals("", $sellerlinetwo);
        $this->assertEquals("", $sellerlinethree);
        $this->assertEquals("99199", $sellerpostcode);
        $this->assertEquals("MUSTERHAUSEN", $sellercity);
        $this->assertEquals("DE", $sellercountry);
        $this->assertIsArray($sellersubdivision);
        $this->assertEmpty($sellersubdivision);
    }

    public function testDocumentSellerLegalOrganization(): void
    {
        self::$document->getDocumentSellerLegalOrganisation($sellerlegalorgid, $sellerlegalorgtype, $sellerlegalorgname);
        $this->assertEquals("", $sellerlegalorgid);
        $this->assertEquals("", $sellerlegalorgtype);
        $this->assertEquals("", $sellerlegalorgname);
    }

    public function testDocumentSellerContact(): void
    {
        $this->assertTrue(self::$document->firstDocumentSellerContact());
        self::$document->getDocumentSellerContact($sellercontactpersonname, $sellercontactdepartmentname, $sellercontactphoneno, $sellercontactfaxno, $sellercontactemailaddr);
        $this->assertEquals("", $sellercontactpersonname);
        $this->assertEquals("", $sellercontactdepartmentname);
        $this->assertEquals("+49 932 431 500", $sellercontactphoneno);
        $this->assertEquals("", $sellercontactfaxno);
        $this->assertEquals("max.mustermann@musterlieferant.de", $sellercontactemailaddr);
        $this->assertFalse(self::$document->nextDocumentSellerContact());
    }

    public function testGetDocumentSellerCommunication(): void
    {
        self::$document->getDocumentSellerCommunication($uriScheme, $uri);
        $this->assertEquals("", $uriScheme);
        $this->assertEquals("", $uri);
    }

    public function testDocumentBuyerGeneral(): void
    {
        self::$document->getDocumentBuyer($buyername, $buyerids, $buyerdescription);
        $this->assertEquals("MUSTER-KUNDE GMBH", $buyername);
        $this->assertIsArray($buyerids);
        $this->assertArrayHasKey(0, $buyerids);
        $this->assertArrayNotHasKey(1, $buyerids);
        $this->assertEquals("339420", $buyerids[0]);
        $this->assertEquals("", $buyerdescription);
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
        $this->assertEquals("KUNDENWEG 88", $buyerlineone);
        $this->assertEquals("", $buyerlinetwo);
        $this->assertEquals("", $buyerlinethree);
        $this->assertEquals("40235", $buyerpostcode);
        $this->assertEquals("DUESSELDORF", $buyercity);
        $this->assertEquals("DE", $buyercountry);
        $this->assertIsArray($buyersubdivision);
        $this->assertEmpty($buyersubdivision);
    }

    public function testDocumentBuyerLegalOrganization(): void
    {
        self::$document->getDocumentBuyerLegalOrganisation($buyerlegalorgid, $buyerlegalorgtype, $buyerlegalorgname);
        $this->assertEquals("", $buyerlegalorgid);
        $this->assertEquals("", $buyerlegalorgtype);
        $this->assertEquals("", $buyerlegalorgname);
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
        $this->assertEquals("", $uriScheme);
        $this->assertEquals("", $uri);
    }

    public function testDocumentSellerTaxRepresentativeGeneral(): void
    {
        self::$document->getDocumentSellerTaxRepresentative($sellertaxreprname, $sellertaxreprids, $sellertaxreprdescription);
        $this->assertEquals("", $sellertaxreprname);
        $this->assertIsArray($sellertaxreprids);
        $this->assertEmpty($sellertaxreprids);
        $this->assertEquals("", $sellertaxreprdescription);
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
        $this->assertEquals("", $sellertaxreprlineone);
        $this->assertEquals("", $sellertaxreprlinetwo);
        $this->assertEquals("", $sellertaxreprlinethree);
        $this->assertEquals("", $sellertaxreprpostcode);
        $this->assertEquals("", $sellertaxreprcity);
        $this->assertEquals("", $sellertaxreprcountry);
        $this->assertIsArray($sellertaxreprsubdivision);
        $this->assertEmpty($sellertaxreprsubdivision);
    }

    public function testDocumentSellerTaxRepresentativeLegalOrganization(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeLegalOrganisation($sellertaxreprlegalorgid, $sellertaxreprlegalorgtype, $sellertaxreprlegalorgname);
        $this->assertEquals("", $sellertaxreprlegalorgid);
        $this->assertEquals("", $sellertaxreprlegalorgtype);
        $this->assertEquals("", $sellertaxreprlegalorgname);
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
        $this->assertEquals("MUSTER-MARKT", $shiptoname);
        $this->assertIsArray($shiptoids);
        $this->assertEmpty($shiptoids);
        $this->assertEquals("", $shiptodescription);
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
        $this->assertEquals("HAUPTSTRASSE 44", $shiptolineone);
        $this->assertEquals("", $shiptolinetwo);
        $this->assertEquals("", $shiptolinethree);
        $this->assertEquals("31157", $shiptopostcode);
        $this->assertEquals("SARSTEDT", $shiptocity);
        $this->assertEquals("DE", $shiptocountry);
        $this->assertIsArray($shiptosubdivision);
        $this->assertEmpty($shiptosubdivision);
    }

    public function testDocumentShipToLegalOrganization(): void
    {
        self::$document->getDocumentShipToLegalOrganisation($shiptolegalorgid, $shiptolegalorgtype, $shiptolegalorgname);
        $this->assertEquals("", $shiptolegalorgid);
        $this->assertEquals("", $shiptolegalorgtype);
        $this->assertEquals("", $shiptolegalorgname);
    }

    public function testDocumentShipToContact(): void
    {
        $this->assertTrue(self::$document->firstDocumentShipToContact());
        self::$document->getDocumentShipToContact($shiptocontactpersonname, $shiptocontactdepartmentname, $shiptocontactphoneno, $shiptocontactfaxno, $shiptocontactemailaddr);
        $this->assertEquals("", $shiptocontactpersonname);
        $this->assertEquals("7322", $shiptocontactdepartmentname);
        $this->assertEquals("", $shiptocontactphoneno);
        $this->assertEquals("", $shiptocontactfaxno);
        $this->assertEquals("", $shiptocontactemailaddr);
        $this->assertFalse(self::$document->nextDocumentShipToContact());
    }

    public function testDocumentUltimateShipToGeneral(): void
    {
        self::$document->getDocumentUltimateShipTo($ultimateshiptoname, $ultimateshiptoids, $ultimateshiptodescription);
        $this->assertEquals("", $ultimateshiptoname);
        $this->assertIsArray($ultimateshiptoids);
        $this->assertEmpty($ultimateshiptoids);
        $this->assertEquals("", $ultimateshiptodescription);
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
        $this->assertEquals("", $ultimateshiptolineone);
        $this->assertEquals("", $ultimateshiptolinetwo);
        $this->assertEquals("", $ultimateshiptolinethree);
        $this->assertEquals("", $ultimateshiptopostcode);
        $this->assertEquals("", $ultimateshiptocity);
        $this->assertEquals("", $ultimateshiptocountry);
        $this->assertIsArray($ultimateshiptosubdivision);
        $this->assertEmpty($ultimateshiptosubdivision);
    }

    public function testDocumentUltimateShipToLegalOrganization(): void
    {
        self::$document->getDocumentUltimateShipToLegalOrganisation($ultimateshiptolegalorgid, $ultimateshiptolegalorgtype, $ultimateshiptolegalorgname);
        $this->assertEquals("", $ultimateshiptolegalorgid);
        $this->assertEquals("", $ultimateshiptolegalorgtype);
        $this->assertEquals("", $ultimateshiptolegalorgname);
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
        $this->assertEquals("", $shipfromname);
        $this->assertIsArray($shipfromids);
        $this->assertEmpty($shipfromids);
        $this->assertEquals("", $shipfromdescription);
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
        $this->assertEquals("", $shipfromlineone);
        $this->assertEquals("", $shipfromlinetwo);
        $this->assertEquals("", $shipfromlinethree);
        $this->assertEquals("", $shipfrompostcode);
        $this->assertEquals("", $shipfromcity);
        $this->assertEquals("", $shipfromcountry);
        $this->assertIsArray($shipfromsubdivision);
        $this->assertEmpty($shipfromsubdivision);
    }

    public function testDocumentShipFromLegalOrganization(): void
    {
        self::$document->getDocumentShipFromLegalOrganisation($shipfromlegalorgid, $shipfromlegalorgtype, $shipfromlegalorgname);
        $this->assertEquals("", $shipfromlegalorgid);
        $this->assertEquals("", $shipfromlegalorgtype);
        $this->assertEquals("", $shipfromlegalorgname);
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
        $this->assertEquals("", $invoicername);
        $this->assertIsArray($invoicerids);
        $this->assertEmpty($invoicerids);
        $this->assertEquals("", $invoicerdescription);
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
        $this->assertEquals("", $invoicerlineone);
        $this->assertEquals("", $invoicerlinetwo);
        $this->assertEquals("", $invoicerlinethree);
        $this->assertEquals("", $invoicerpostcode);
        $this->assertEquals("", $invoicercity);
        $this->assertEquals("", $invoicercountry);
        $this->assertIsArray($invoicersubdivision);
        $this->assertEmpty($invoicersubdivision);
    }

    public function testDocumentInvoicerLegalOrganization(): void
    {
        self::$document->getDocumentInvoicerLegalOrganisation($invoicerlegalorgid, $invoicerlegalorgtype, $invoicerlegalorgname);
        $this->assertEquals("", $invoicerlegalorgid);
        $this->assertEquals("", $invoicerlegalorgtype);
        $this->assertEquals("", $invoicerlegalorgname);
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
        $this->assertEquals("MUSTER-KUNDE GMBH", $invoiceename);
        $this->assertIsArray($invoiceeids);
        $this->assertNotEmpty($invoiceeids);
        $this->assertArrayHasKey(0, $invoiceeids);
        $this->assertEquals("", $invoiceedescription);
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
        $this->assertEquals("KUNDENWEG 88", $invoiceelineone);
        $this->assertEquals("", $invoiceelinetwo);
        $this->assertEquals("", $invoiceelinethree);
        $this->assertEquals("40235", $invoiceepostcode);
        $this->assertEquals("DUESSELDORF", $invoiceecity);
        $this->assertEquals("DE", $invoiceecountry);
        $this->assertIsArray($invoiceesubdivision);
        $this->assertEmpty($invoiceesubdivision);
    }

    public function testDocumentInvoiceeLegalOrganization(): void
    {
        self::$document->getDocumentInvoiceeLegalOrganisation($invoiceelegalorgid, $invoiceelegalorgtype, $invoiceelegalorgname);
        $this->assertEquals("", $invoiceelegalorgid);
        $this->assertEquals("", $invoiceelegalorgtype);
        $this->assertEquals("", $invoiceelegalorgname);
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
        $this->assertEquals("", $payeename);
        $this->assertIsArray($payeeids);
        $this->assertEmpty($payeeids);
        $this->assertEquals("", $payeedescription);
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
        $this->assertEquals("", $payeelineone);
        $this->assertEquals("", $payeelinetwo);
        $this->assertEquals("", $payeelinethree);
        $this->assertEquals("", $payeepostcode);
        $this->assertEquals("", $payeecity);
        $this->assertEquals("", $payeecountry);
        $this->assertIsArray($payeesubdivision);
        $this->assertEmpty($payeesubdivision);
    }

    public function testDocumentPayeeLegalOrganization(): void
    {
        self::$document->getDocumentPayeeLegalOrganisation($payeelegalorgid, $payeelegalorgtype, $payeelegalorgname);
        $this->assertEquals("", $payeelegalorgid);
        $this->assertEquals("", $payeelegalorgtype);
        $this->assertEquals("", $payeelegalorgname);
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
        $this->assertEquals("", $producendusername);
        $this->assertIsArray($producenduserids);
        $this->assertArrayNotHasKey(0, $producenduserids);
        $this->assertArrayNotHasKey(1, $producenduserids);
        $this->assertEquals("", $producenduserdescription);
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
        $this->assertEquals("", $producenduserlineone);
        $this->assertEquals("", $producenduserlinetwo);
        $this->assertEquals("", $producenduserlinethree);
        $this->assertEquals("", $producenduserpostcode);
        $this->assertEquals("", $producendusercity);
        $this->assertEquals("", $producendusercountry);
        $this->assertIsArray($producendusersubdivision);
        $this->assertEmpty($producendusersubdivision);
    }

    public function testDocumentProductEndUserLegalOrganization(): void
    {
        self::$document->getDocumentProductEndUserLegalOrganisation($producenduserlegalorgid, $producenduserlegalorgtype, $producenduserlegalorgname);
        $this->assertEquals("", $producenduserlegalorgid);
        $this->assertEquals("", $producenduserlegalorgtype);
        $this->assertEquals("", $producenduserlegalorgname);
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
        $this->assertEquals("", $sellerorderrefdocid);
        $this->assertNull($sellerorderrefdocdate);
    }

    public function testDocumentBuyerOrderReferencedDocument(): void
    {
        self::$document->getDocumentBuyerOrderReferencedDocument($buyerorderrefdocid, $buyerorderrefdocdate);
        $this->assertEquals("", $buyerorderrefdocid);
        $this->assertNull($buyerorderrefdocdate);
    }

    public function testDocumentQuotationReferencedDocument(): void
    {
        self::$document->getDocumentQuotationReferencedDocument($quotationrefdocid, $quotationrefdocdate);
        $this->assertEquals("", $quotationrefdocid);
        $this->assertNull($quotationrefdocdate);
    }

    public function testDocumentContractReferencedDocument(): void
    {
        self::$document->getDocumentContractReferencedDocument($contractrefdocid, $contractrefdocdate);
        $this->assertEquals("", $contractrefdocid);
        $this->assertNull($contractrefdocdate);
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

    public function testDocumentInvoiceReferencedDocuments(): void
    {
        self::$document->getDocumentInvoiceReferencedDocuments($invoicerefdocs);
        $this->assertIsArray($invoicerefdocs);
        $this->assertNotEmpty($invoicerefdocs);
        $this->assertArrayHasKey(0, $invoicerefdocs);
        $this->assertIsArray($invoicerefdocs[0]);
        $this->assertArrayHasKey("IssuerAssignedID", $invoicerefdocs[0]);
        $this->assertArrayHasKey("TypeCode", $invoicerefdocs[0]);
        $this->assertArrayHasKey("FormattedIssueDateTime", $invoicerefdocs[0]);
        $this->assertEquals("S-INV1", $invoicerefdocs[0]["IssuerAssignedID"]);
        $this->assertEquals("83", $invoicerefdocs[0]["TypeCode"]);
        $this->assertArrayHasKey(1, $invoicerefdocs);
        $this->assertIsArray($invoicerefdocs[1]);
        $this->assertArrayHasKey("IssuerAssignedID", $invoicerefdocs[1]);
        $this->assertArrayHasKey("TypeCode", $invoicerefdocs[1]);
        $this->assertArrayHasKey("FormattedIssueDateTime", $invoicerefdocs[1]);
        $this->assertEquals("S-INV2", $invoicerefdocs[1]["IssuerAssignedID"]);
        $this->assertEquals("84", $invoicerefdocs[1]["TypeCode"]);
    }

    public function testDocumentProcuringProject(): void
    {
        self::$document->getDocumentProcuringProject($projectid, $projectname);
        $this->assertEquals("", $projectid);
        $this->assertEquals("", $projectname);
    }

    public function testDocumentSupplyChainEvent(): void
    {
        self::$document->getDocumentSupplyChainEvent($supplychainevent);
        $this->assertNotNull($supplychainevent);
        $this->assertInstanceOf("DateTime", $supplychainevent);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180930'))->format('Ymd'), $supplychainevent->format('Ymd'));
    }

    public function testDocumentDespatchAdviceReferencedDocument(): void
    {
        self::$document->getDocumentDespatchAdviceReferencedDocument($despatchdocid, $despatchdocdate);
        $this->assertEquals("", $despatchdocid);
        $this->assertNull($despatchdocdate);
    }

    public function testDocumentReceivingAdviceReferencedDocument(): void
    {
        self::$document->getDocumentReceivingAdviceReferencedDocument($recadvid, $recadvdate);
        $this->assertEquals("", $recadvid);
        $this->assertNull($recadvdate);
    }

    public function testDocumentDeliveryNoteReferencedDocument(): void
    {
        self::$document->getDocumentDeliveryNoteReferencedDocument($deliverynoterefdocid, $deliverynoterefdocdate);
        $this->assertEquals("L87654321012", $deliverynoterefdocid);
        $this->assertNull($deliverynoterefdocdate);
    }

    public function testDocumentBillingPeriod(): void
    {
        self::$document->getDocumentBillingPeriod($docbillingperiodstart, $docbillingperiodend);
        $this->assertNull($docbillingperiodstart);
        $this->assertNull($docbillingperiodend);
    }

    public function testDocumentAllowanceCharges(): void
    {
        self::$document->getDocumentAllowanceCharges($docallowancecharge);
        $this->assertIsArray($docallowancecharge);
        $this->assertNotEmpty($docallowancecharge);
        $this->assertEquals(1, count($docallowancecharge));
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
        $this->assertEquals(0.0, $docpaymentterms[0]["partialpaymentamount"]);
    }

    public function testDocumentDeliveryTerms(): void
    {
        self::$document->getDocumentDeliveryTerms($devtermcode);
        $this->assertEquals("", $devtermcode);
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
        $this->assertEquals("A777123", $issuerassignedid);
        $this->assertEquals("130", $typecode);
        $this->assertEquals("", $uriid);
        $this->assertIsArray($name);
        $this->assertEmpty($name);
        $this->assertEquals("", $reftypecode);
        $this->assertNull($issueddate);
        $this->assertEquals("", $binarydatafilename);
    }

    public function testDocumentInvoiceReferencedDocumentLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentInvoiceReferencedDocument());
        $this->assertTrue(self::$document->nextDocumentInvoiceReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentInvoiceReferencedDocument());
    }

    public function testGetDocumentInvoiceReferencedDocument(): void
    {
        $this->assertTrue(self::$document->firstDocumentInvoiceReferencedDocument());
        self::$document->getDocumentInvoiceReferencedDocument($issuerassignedid, $typecode, $issueddate);
        $this->assertEquals("S-INV1", $issuerassignedid);
        $this->assertEquals("83", $typecode);
        $this->assertTrue(self::$document->nextDocumentInvoiceReferencedDocument());
        self::$document->getDocumentInvoiceReferencedDocument($issuerassignedid, $typecode, $issueddate);
        $this->assertEquals("S-INV2", $issuerassignedid);
        $this->assertEquals("84", $typecode);
        $this->assertFalse(self::$document->nextDocumentInvoiceReferencedDocument());
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

    public function testDocumentTaxLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentTax());
        $this->assertFalse(self::$document->nextDocumentTax());
    }

    public function testDocumentTax(): void
    {
        $this->assertTrue(self::$document->firstDocumentTax());
        self::$document->getDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(403.55, $basisAmount);
        $this->assertEquals(76.67, $calculatedAmount);
        $this->assertEquals(19.0, $rateApplicablePercent);
        $this->assertEquals(-6.55, $allowanceChargeBasisAmount);
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

    public function testtDocumentLogisticsServiceChargeLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentLogisticsServiceCharge());
        $this->assertFalse(self::$document->nextDocumentLogisticsServiceCharge());
    }

    public function testGetDocumentLogisticsServiceCharge(): void
    {
        $this->assertTrue(self::$document->firstDocumentLogisticsServiceCharge());
        self::$document->getDocumentLogisticsServiceCharge($description, $appliedAmount, $taxTypeCodes, $taxCategoryCodes, $rateApplicablePercents);
        $this->assertEquals("Transportkosten: Frachbetrag", $description);
        $this->assertEquals(15.00, $appliedAmount);
        $this->assertIsArray($taxTypeCodes);
        $this->assertEquals(1, count($taxTypeCodes));
        $this->assertArrayHasKey(0, $taxTypeCodes);
        $this->assertEquals("VAT", $taxTypeCodes[0]);
        $this->assertIsArray($taxCategoryCodes);
        $this->assertEquals(1, count($taxCategoryCodes));
        $this->assertArrayHasKey(0, $taxCategoryCodes);
        $this->assertEquals("S", $taxCategoryCodes[0]);
        $this->assertIsArray($rateApplicablePercents);
        $this->assertEquals(1, count($rateApplicablePercents));
        $this->assertArrayHasKey(0, $rateApplicablePercents);
        $this->assertEquals(19.0, $rateApplicablePercents[0]);
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

        $this->assertEquals("Skontovereinbarung: 2% bei Zahlung innerhalb 10 Tagen nach Rechnungsdatum", $termdescription);
        $this->assertNull($termduedate);
        $this->assertEquals("", $termmandate);
        $this->assertEquals(2.0, $dispercent);
        $this->assertNull($discbasedatetime);
        $this->assertEquals(10, $discmeasureval);
        $this->assertEquals("DAY", $discmeasureunit);
        $this->assertEquals(0, $discbaseamount);
        $this->assertEquals(0, $discamount);

        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
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
        $this->assertEquals("1", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("Wirkarbeit HT", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("WA997", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4123456000014", $prodglobalid);

        self::$document->getDocumentPositionProductDetailsExt($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid, $prodindustyid, $prodmodelid, $prodbatchid, $prodbrandname, $prodmodelname);
        $this->assertEquals("Wirkarbeit HT", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("WA997", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4123456000014", $prodglobalid);
        $this->assertEquals("IndustryId", $prodindustyid);
        $this->assertEquals("ModelId", $prodmodelid);
        $this->assertEquals("BatchId", $prodbatchid);
        $this->assertEquals("BrandeName", $prodbrandname);
        $this->assertEquals("ModelName", $prodmodelname);

        self::$document->getDocumentPositionSellerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionQuotationReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0520, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(0.0520, $netpriceamount);
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
        $this->assertEquals(10000.0, $billedquantity);
        $this->assertEquals("KWH", $billedquantityunitcode);
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
        $this->assertEquals(19.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummationSimple($lineTotalAmount);
        $this->assertEquals(52.00, $lineTotalAmount);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    public function testDocumentPositionSecond(): void
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("2", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("Ökosteuer Lieferant", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("ÖST250", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4123456000021", $prodglobalid);

        self::$document->getDocumentPositionSellerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionQuotationReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0205, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(0.0205, $netpriceamount);
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
        $this->assertEquals(10000, $billedquantity);
        $this->assertEquals("KWH", $billedquantityunitcode);
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
        $this->assertEquals(19.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummationSimple($lineTotalAmount);
        $this->assertEquals(20.50, $lineTotalAmount);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    public function testDocumentPositionThird(): void
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("3", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("Kommissionierer 1250032 D. Muster", $prodname);
        $this->assertEquals("Besteller: Hr. Mayer, Personalnr. 4488", $proddesc);
        $this->assertEquals("", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4260331811362", $prodglobalid);

        self::$document->getDocumentPositionSellerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionQuotationReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(15.0000, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(10.5000, $netpriceamount);
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
        $this->assertEquals(27.5000, $billedquantity);
        $this->assertEquals("HUR", $billedquantityunitcode);
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
        $this->assertNull($docpostenddate);

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

        $this->assertTrue(self::$document->firstDocumentPositionTax());
        $this->assertFalse(self::$document->nextDocumentPositionTax());

        self::$document->firstDocumentPositionTax();
        self::$document->getDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
        $this->assertEquals("S", $categoryCode);
        $this->assertEquals("VAT", $typeCode);
        $this->assertEquals(19.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummationSimple($lineTotalAmount);
        $this->assertEquals(288.75, $lineTotalAmount);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    public function testDocumentPositionFourth(): void
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("4", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("FALTENBEUTEL 16x6x28 CM", $prodname);
        $this->assertEquals("", $proddesc);
        $this->assertEquals("FB05", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("2001015001325", $prodglobalid);

        self::$document->getDocumentPositionSellerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionQuotationReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0105, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(0.0105, $netpriceamount);
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
        $this->assertEquals(3500.0, $billedquantity);
        $this->assertEquals("H87", $billedquantityunitcode);
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
        $this->assertEquals(19.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummationSimple($lineTotalAmount);
        $this->assertEquals(36.75, $lineTotalAmount);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    public function testDocumentPositionFifth(): void
    {
        $this->assertTrue(self::$document->nextDocumentPosition());

        self::$document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $this->assertEquals("5", $lineid);
        $this->assertEquals("", $linestatuscode);
        $this->assertEquals("", $linestatusreasoncode);

        self::$document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $this->assertEquals("Kopierpapier A4", $prodname);
        $this->assertEquals("Zählerstand von-bis: 543210 - 544420", $proddesc);
        $this->assertEquals("KOP05", $prodsellerid);
        $this->assertEquals("", $prodbuyerid);
        $this->assertEquals("0088", $prodglobalidtype);
        $this->assertEquals("4123456000038", $prodglobalid);

        self::$document->getDocumentPositionSellerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionBuyerOrderReferencedDocument($doclineorderid, $doclineorderlineid, $doclineorderdate);
        $this->assertEquals("", $doclineorderid);
        $this->assertEquals("", $doclineorderlineid);
        $this->assertNull($doclineorderdate);

        self::$document->getDocumentPositionQuotationReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionContractReferencedDocument($doclinecontid, $doclinecontlineid, $doclinecontdate);
        $this->assertEquals("", $doclinecontid);
        $this->assertEquals("", $doclinecontlineid);
        $this->assertNull($doclinecontdate);

        self::$document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $this->assertEquals(0.0100, $grosspriceamount);
        $this->assertEquals(0.0, $grosspricebasisquantity);
        $this->assertEquals("", $grosspricebasisquantityunitcode);

        self::$document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $this->assertEquals(0.0100, $netpriceamount);
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
        $this->assertEquals(1210.0, $billedquantity);
        $this->assertEquals("H87", $billedquantityunitcode);
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
        $this->assertEquals(19.0, $rateApplicablePercent);
        $this->assertEquals(0.0, $calculatedAmount);
        $this->assertEquals("", $exemptionReason);
        $this->assertEquals("", $exemptionReasonCode);

        self::$document->getDocumentPositionLineSummationSimple($lineTotalAmount);
        $this->assertEquals(12.10, $lineTotalAmount);

        self::$document->getDocumentPositionSupplyChainEvent($supplyeventdatetime);
        $this->assertNull($supplyeventdatetime);
    }

    public function testDocumentPositionAdditionalReferencedDocument(): void
    {
        $this->assertFalse(self::$document->firstDocumentPositionAdditionalReferencedDocument());
        $this->assertFalse(self::$document->nextDocumentPositionAdditionalReferencedDocument());
    }
}
