<?php

namespace horstoeko\zugferd\tests;

use \PHPUnit\Framework\TestCase;
use \horstoeko\zugferd\ZugferdProfiles;
use \horstoeko\zugferd\ZugferdDocumentReader;
use \horstoeko\zugferd\codelists\ZugferdInvoiceType;
use \horstoeko\zugferd\codelists\ZugferdPaymentMeans;

class ReaderEn16931Bank1Test extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/data/en16931_sepa_prenotification.xml");
    }

    public function testDocumentProfile(): void
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->profile);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInformation
     */
    public function testDocumentGenerals(): void
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('471102', $documentno);
        $this->assertEquals(ZugferdInvoiceType::INVOICE, $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180305'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertEquals("EUR", $invoiceCurrency);
        $this->assertEquals("", $taxCurrency);
        $this->assertEquals("", $documentname);
        $this->assertEquals("", $documentlanguage);
        $this->assertNull($effectiveSpecifiedPeriod);
        $this->assertNotNull(self::$document->getInvoiceObject());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstGetDocumentPaymentMeans
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextGetDocumentPaymentMeans
     */
    public function testDocumentPaymentMeansLoop(): void
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        $this->assertFalse(self::$document->nextGetDocumentPaymentMeans());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPaymentTerms
     */
    public function testtDocumentPaymentTermsLoop(): void
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentGeneralPaymentInformation
     */
    public function testDocumentGeneralPaymentInformation(): void
    {
        self::$document->getDocumentGeneralPaymentInformation($creditorReferenceID, $paymentReference);
        $this->assertEquals("DE98ZZZ09999999999", $creditorReferenceID);
        $this->assertEquals("", $paymentReference);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstGetDocumentPaymentMeans
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPaymentMeans
     */
    public function testGetDocumentPaymentMeans(): void
    {
        $this->assertTrue(self::$document->firstGetDocumentPaymentMeans());
        self::$document->getDocumentPaymentMeans($typeCode, $information, $cardType, $cardId, $cardHolderName, $buyerIban, $payeeIban, $payeeAccountName, $payeePropId, $payeeBic);
        $this->assertEquals(ZugferdPaymentMeans::UNTDID_4461_59, $typeCode);
        $this->assertEquals("", $information);
        $this->assertEquals("", $cardType);
        $this->assertEquals("", $cardId);
        $this->assertEquals("", $cardHolderName);
        $this->assertEquals("DE21860000000086001055", $buyerIban);
        $this->assertEquals("", $payeeIban);
        $this->assertEquals("", $payeeAccountName);
        $this->assertEquals("", $payeePropId);
        $this->assertEquals("", $payeeBic);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::firstDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::nextDocumentPaymentTerms
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentPaymentTerm
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDiscountTermsFromPaymentTerm
     */
    public function testtDocumentPaymentTerms(): void
    {
        $this->assertTrue(self::$document->firstDocumentPaymentTerms());
        self::$document->getDocumentPaymentTerm($termdescription, $termduedate, $termmandate);
        self::$document->getDiscountTermsFromPaymentTerm($dispercent, $discbasedatetime, $discmeasureval, $discmeasureunit, $discbaseamount, $discamount);

        $this->assertEquals("Der Betrag in Höhe von EUR 529,87 wird am 20.03.2018 von Ihrem Konto per SEPA-Lastschrift eingezogen.", $termdescription);
        $this->assertNull($termduedate);
        $this->assertEquals("REF A-123", $termmandate);
        $this->assertEquals(0, $dispercent);
        $this->assertNull($discbasedatetime);
        $this->assertEquals(0, $discmeasureval);
        $this->assertEquals("", $discmeasureunit);
        $this->assertEquals(0, $discbaseamount);
        $this->assertEquals(0, $discamount);

        $this->assertFalse(self::$document->nextDocumentPaymentTerms());
    }
}
