<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentPdfReader;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

class PdfReaderMultipleAttachmentsTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public function testCanReadPdf(): void
    {
        self::$document = ZugferdDocumentPdfReader::readAndGuessFromFile(__DIR__ . "/../assets/pdf_zf_en16931_2.pdf");
        $this->assertNotNull(self::$document);
    }

    public function testDocumentProfile(): void
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_XRECHNUNG, self::$document->getProfileId());
    }

    public function testDocumentGenerals(): void
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('181301674', $documentno);
        $this->assertEquals("204", $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180425'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertEquals("EUR", $invoiceCurrency);
        $this->assertEquals("", $taxCurrency);
        $this->assertEquals("", $documentname);
        $this->assertEquals("", $documentlanguage);
        $this->assertNull($effectiveSpecifiedPeriod);
        $this->assertNotNull($this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
        $this->assertEquals('horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice', get_class($this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject')));
    }
}
