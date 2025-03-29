<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\codelists\ZugferdPaymentMeans;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

class ReaderEn16931Bank2Test extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . "/../assets/xml_en16931_3.xml");
    }

    public function testDocumentProfile(): void
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
    }

    public function testDocumentGenerals(): void
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertSame('F20200024', $documentno);
        $this->assertSame(ZugferdInvoiceType::INVOICE, $documenttypecode);
        $this->assertInstanceOf(\DateTime::class, $documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20200115'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertSame("EUR", $invoiceCurrency);
        $this->assertSame("", $taxCurrency);
        $this->assertSame("", $documentname);
        $this->assertSame("", $documentlanguage);
        $this->assertNotInstanceOf(\DateTime::class, $effectiveSpecifiedPeriod);
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
        $this->assertInstanceOf('horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice', $this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
    }

    public function testDocumentPaymentMeansLoop(): void
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        $this->assertFalse(self::$document->nextGetDocumentPaymentMeans());
    }

    public function testtDocumentPaymentTermsLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }

    public function testDocumentGeneralPaymentInformation(): void
    {
        self::$document->getDocumentGeneralPaymentInformation($creditorReferenceID, $paymentReference);
        $this->assertSame("CREDID", $creditorReferenceID);
        $this->assertSame("F20180023BUYER", $paymentReference);
    }

    public function testGetDocumentPaymentMeans(): void
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        self::$document->getDocumentPaymentMeans($typeCode, $information, $cardType, $cardId, $cardHolderName, $buyerIban, $payeeIban, $payeeAccountName, $payeePropId, $payeeBic);
        $this->assertSame(ZugferdPaymentMeans::UNTDID_4461_30, $typeCode);
        $this->assertSame("", $information);
        $this->assertSame("", $cardType);
        $this->assertSame("", $cardId);
        $this->assertSame("", $cardHolderName);
        $this->assertSame("FRDEBIT", $buyerIban);
        $this->assertSame("FR76 1254 2547 2569 8542 5874 698", $payeeIban);
        $this->assertSame("", $payeeAccountName);
        $this->assertSame("LOC BANK ACCOUNT", $payeePropId);
        $this->assertSame("", $payeeBic);
    }

    public function testtDocumentPaymentTerms(): void
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        self::$document->getDocumentPaymentTerm($termdescription, $termduedate, $termmandate);
        self::$document->getDiscountTermsFromPaymentTerm($dispercent, $discbasedatetime, $discmeasureval, $discmeasureunit, $discbaseamount, $discamount);
        self::$document->getPenaltyTermsFromPaymentTerm($penaltypercent, $penaltybasedatetime, $penaltymeasureval, $penaltymeasureunit, $penaltybaseamount, $penaltyamount);

        $this->assertSame("", $termdescription);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20200215'))->format('Ymd'), $termduedate->format('Ymd'));
        $this->assertSame("MANDATE PT", $termmandate);
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

    public function testDocumentSellerTaxRepresentativeGeneral(): void
    {
        self::$document->getDocumentSellerTaxRepresentative($sellertaxreprname, $sellertaxreprids, $sellertaxreprdescription);
        $this->assertSame("SELLER TAX REP", $sellertaxreprname);
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
        $this->assertNotEmpty($sellertaxreprtaxreg);
        $this->assertArrayHasKey("VA", $sellertaxreprtaxreg);
        $this->assertEquals("FR 05 987 654 321", $sellertaxreprtaxreg["VA"]);
    }

    public function testDocumentSellerTaxRepresentativeAddress(): void
    {
        self::$document->getDocumentSellerTaxRepresentativeAddress($sellertaxreprlineone, $sellertaxreprlinetwo, $sellertaxreprlinethree, $sellertaxreprpostcode, $sellertaxreprcity, $sellertaxreprcountry, $sellertaxreprsubdivision);
        $this->assertSame("35 rue d'ici", $sellertaxreprlineone);
        $this->assertSame("Seller line 2", $sellertaxreprlinetwo);
        $this->assertSame("Seller line 3", $sellertaxreprlinethree);
        $this->assertSame("75018", $sellertaxreprpostcode);
        $this->assertSame("PARIS", $sellertaxreprcity);
        $this->assertSame("FR", $sellertaxreprcountry);
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
}
