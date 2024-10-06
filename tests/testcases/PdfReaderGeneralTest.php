<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocument;
use horstoeko\zugferd\ZugferdDocumentPdfReader;

class PdfReaderGeneralTest extends TestCase
{
    public function testCanReadPdf(): void
    {
        $document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/../assets/pdf_invalid.pdf");
        $this->assertNull($document);
    }

    public function testFileNotFound(): void
    {
        $this->expectException(ZugferdFileNotFoundException::class);
        $document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/../assets/unknown.pdf");
    }

    public function testCanReadPdf2(): void
    {
        $document = ZugferdDocumentPdfReader::getXmlFromFile(dirname(__FILE__) . "/../assets/pdf_invalid.pdf");
        $this->assertNull($document);
    }

    public function testFileNotFound2(): void
    {
        $this->expectException(ZugferdFileNotFoundException::class);
        $document = ZugferdDocumentPdfReader::getXmlFromFile(dirname(__FILE__) . "/../assets/unknown.pdf");
    }

    public function testCanReadPdf3(): void
    {
        $document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/../assets/pdf_zf_en16931_1.pdf");
        $this->assertNotNull($document);
        $this->assertInstanceOf(ZugferdDocument::class, $document);
    }

    public function testCanReadPdf4(): void
    {
        $xmlString = ZugferdDocumentPdfReader::getXmlFromFile(dirname(__FILE__) . "/../assets/pdf_zf_en16931_1.pdf");
        $this->assertNotNull($xmlString);
        $this->assertIsString($xmlString);
        $this->assertStringContainsString("<?xml version='1.0'", $xmlString);
        $this->assertStringContainsString("<rsm:CrossIndustryInvoice", $xmlString);
        $this->assertStringContainsString("</rsm:CrossIndustryInvoice>", $xmlString);
    }
}
