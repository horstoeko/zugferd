<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\exception\ZugferdExceptionCodes;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdNoPdfAttachmentFoundException;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocument;
use horstoeko\zugferd\ZugferdDocumentPdfReader;

class PdfReaderGeneralTest extends TestCase
{
    /* ZugferdPdfReader::readAndGuessFromFile */

    public function testReadFromFileWhichDoesNotExist(): void
    {
        $this->expectException(ZugferdFileNotFoundException::class);

        ZugferdDocumentPdfReader::readAndGuessFromFile(__DIR__ . "/../assets/unknown.pdf");
    }

    public function testReadFromFileWhichHasNoValidAttachment(): void
    {
        $this->expectException(ZugferdNoPdfAttachmentFoundException::class);
        $this->expectExceptionMessage('No PDF attachment found');
        $this->expectExceptionCode(ZugferdExceptionCodes::NOPDFATTACHMENTFOUND);

        ZugferdDocumentPdfReader::readAndGuessFromFile(__DIR__ . "/../assets/pdf_invalid.pdf");
    }

    public function testReadFromFileWhichExistsAndHasValidAttachment(): void
    {
        $document = ZugferdDocumentPdfReader::readAndGuessFromFile(__DIR__ . "/../assets/pdf_zf_en16931_1.pdf");

        $this->assertInstanceOf(ZugferdDocument::class, $document);
    }

    /* ZugferdPdfReader::readAndGuessFromContent */

    public function testReadFromContentWhichHasNoValidAttachment(): void
    {
        $this->expectException(ZugferdNoPdfAttachmentFoundException::class);
        $this->expectExceptionMessage('No PDF attachment found');
        $this->expectExceptionCode(ZugferdExceptionCodes::NOPDFATTACHMENTFOUND);

        $pdfContent = file_get_contents(__DIR__ . "/../assets/pdf_invalid.pdf");

        ZugferdDocumentPdfReader::readAndGuessFromContent($pdfContent);
    }

    public function testReadFromContentWhichHasValidAttachment(): void
    {
        $pdfContent = file_get_contents(__DIR__ . "/../assets/pdf_zf_en16931_1.pdf");

        $document = ZugferdDocumentPdfReader::readAndGuessFromContent($pdfContent);

        $this->assertInstanceOf(ZugferdDocument::class, $document);
    }

    /* ZugferdPdfReader::getXmlFromFile */

    public function testGetXmlFromFileWhichDoesNotExist(): void
    {
        $this->expectException(ZugferdFileNotFoundException::class);

        ZugferdDocumentPdfReader::getXmlFromFile(__DIR__ . "/../assets/unknown.pdf");
    }

    public function testGetXmlFromFileWhichHasNoValidAttachment(): void
    {
        $this->expectException(ZugferdNoPdfAttachmentFoundException::class);
        $this->expectExceptionMessage('No PDF attachment found');
        $this->expectExceptionCode(ZugferdExceptionCodes::NOPDFATTACHMENTFOUND);

        ZugferdDocumentPdfReader::getXmlFromFile(__DIR__ . "/../assets/pdf_invalid.pdf");
    }

    public function testGetXmlFromFileWhichExistsAndHasValidAttachment(): void
    {
        $xmlString = ZugferdDocumentPdfReader::getXmlFromFile(__DIR__ . "/../assets/pdf_zf_en16931_1.pdf");

        $this->assertStringContainsString("<?xml version='1.0'", $xmlString);
        $this->assertStringContainsString("<rsm:CrossIndustryInvoice", $xmlString);
        $this->assertStringContainsString("</rsm:CrossIndustryInvoice>", $xmlString);
    }

    /* ZugferdPdfReader::getXmlFromContent */

    public function testGetXmlFromContentWhichHasNoValidAttachment(): void
    {
        $this->expectException(ZugferdNoPdfAttachmentFoundException::class);
        $this->expectExceptionMessage('No PDF attachment found');
        $this->expectExceptionCode(ZugferdExceptionCodes::NOPDFATTACHMENTFOUND);

        $pdfContent = file_get_contents(__DIR__ . "/../assets/pdf_invalid.pdf");

        ZugferdDocumentPdfReader::getXmlFromContent($pdfContent);
    }

    public function testGetXmlFromContentWhichHasValidAttachment(): void
    {
        $pdfContent = file_get_contents(__DIR__ . "/../assets/pdf_zf_en16931_1.pdf");

        $xmlString = ZugferdDocumentPdfReader::getXmlFromContent($pdfContent);

        $this->assertStringContainsString("<?xml version='1.0'", $xmlString);
        $this->assertStringContainsString("<rsm:CrossIndustryInvoice", $xmlString);
        $this->assertStringContainsString("</rsm:CrossIndustryInvoice>", $xmlString);
    }
}
