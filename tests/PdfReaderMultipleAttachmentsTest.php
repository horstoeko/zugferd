<?php

namespace horstoeko\zugferd\tests;

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdDocumentPdfReader;
use horstoeko\zugferd\ZugferdDocumentReader;

class PdfReaderMultipleAttachmentsTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentPdfReader::readAndGuessFromFile
     */
    public function testCanReadPdf()
    {
        self::$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/data/zugferd_2p1_EN16931_Elektron.pdf");
        $this->assertNotNull(self::$document);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentReader::getDocumentInformation
     */
    public function testDocumentGenerals()
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
        $this->assertNotNull(self::$document->getInvoiceObject());
    }
}
