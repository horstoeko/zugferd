<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\codelists\ZugferdPaymentMeans;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

class ReaderEn16931Bank1Test extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . "/../assets/xml_en16931_4.xml");
    }

    public function testDocumentProfile(): void
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
    }

    public function testDocumentGetters(): void
    {
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
        $this->assertInstanceOf('horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice', $this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getSerializer'));
        $this->assertInstanceOf(\JMS\Serializer\Serializer::class, $this->invokePrivateMethodFromObject(self::$document, 'getSerializer'));
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getObjectHelper'));
        $this->assertInstanceOf('horstoeko\zugferd\ZugferdObjectHelper', $this->invokePrivateMethodFromObject(self::$document, 'getObjectHelper'));
        $this->assertEquals('en16931', self::$document->getProfileDefinitionParameter('name'));
        $this->assertEquals('EN 16931 (COMFORT)', self::$document->getProfileDefinitionParameter('altname'));
        $this->assertEquals('urn:cen.eu:en16931:2017', self::$document->getProfileDefinitionParameter('contextparameter'));
        $this->assertEquals('factur-x.xml', self::$document->getProfileDefinitionParameter('attachmentfilename'));
        $this->assertEquals('EN 16931', self::$document->getProfileDefinitionParameter('xmpname'));
        $this->assertEquals('1.0', self::$document->getProfileDefinitionParameter('xmpversion'));
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getProfileDefinitionParameter('unknownparameter');
            }
        );
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
        $this->assertSame("DE98ZZZ09999999999", $creditorReferenceID);
        $this->assertSame("", $paymentReference);
    }

    public function testGetDocumentPaymentMeans(): void
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        self::$document->getDocumentPaymentMeans($typeCode, $information, $cardType, $cardId, $cardHolderName, $buyerIban, $payeeIban, $payeeAccountName, $payeePropId, $payeeBic);
        $this->assertSame(ZugferdPaymentMeans::UNTDID_4461_59, $typeCode);
        $this->assertSame("", $information);
        $this->assertSame("", $cardType);
        $this->assertSame("", $cardId);
        $this->assertSame("", $cardHolderName);
        $this->assertSame("DE21860000000086001055", $buyerIban);
        $this->assertSame("", $payeeIban);
        $this->assertSame("", $payeeAccountName);
        $this->assertSame("", $payeePropId);
        $this->assertSame("", $payeeBic);
    }

    public function testtDocumentPaymentTerms(): void
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        self::$document->getDocumentPaymentTerm($termdescription, $termduedate, $termmandate);
        self::$document->getDiscountTermsFromPaymentTerm($dispercent, $discbasedatetime, $discmeasureval, $discmeasureunit, $discbaseamount, $discamount);
        self::$document->getPenaltyTermsFromPaymentTerm($penaltypercent, $penaltybasedatetime, $penaltymeasureval, $penaltymeasureunit, $penaltybaseamount, $penaltyamount);

        $this->assertSame("Der Betrag in Höhe von EUR 529,87 wird am 20.03.2018 von Ihrem Konto per SEPA-Lastschrift eingezogen.", $termdescription);
        $this->assertNotInstanceOf(\DateTime::class, $termduedate);
        $this->assertSame("REF A-123", $termmandate);
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
}
