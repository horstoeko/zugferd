<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\exception\ZugferdExceptionCodes;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdNoPdfAttachmentFoundException;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocument;
use horstoeko\zugferd\ZugferdDocumentPdfReaderExt;
use horstoeko\zugferd\ZugferdDocumentReader;

class PdfReaderExtGeneralTest extends TestCase
{
    public function testReadFromFileWhichDoesNotExist(): void
    {
        $this->expectException(ZugferdFileNotFoundException::class);

        ZugferdDocumentPdfReaderExt::readAndGuessFromFile(__DIR__ . "/../assets/unknown.pdf");
    }

    public function testReadFromFileWhichHasNoValidAttachment(): void
    {
        $this->expectException(ZugferdNoPdfAttachmentFoundException::class);
        $this->expectExceptionMessage('No PDF attachment found');
        $this->expectExceptionCode(ZugferdExceptionCodes::NOPDFATTACHMENTFOUND);

        ZugferdDocumentPdfReaderExt::readAndGuessFromFile(__DIR__ . "/../assets/pdf_invalid.pdf");
    }

    public function testReadFromFileWhichExistsAndHasValidAttachment(): void
    {
        $document = ZugferdDocumentPdfReaderExt::readAndGuessFromFile(__DIR__ . "/../assets/pdf_zf_en16931_1.pdf");

        $this->checkDocumentReader($document);
    }

    public function testReadFromContentWhichHasNoValidAttachment(): void
    {
        $this->expectException(ZugferdNoPdfAttachmentFoundException::class);
        $this->expectExceptionMessage('No PDF attachment found');
        $this->expectExceptionCode(ZugferdExceptionCodes::NOPDFATTACHMENTFOUND);

        $pdfContent = file_get_contents(__DIR__ . "/../assets/pdf_invalid.pdf");

        ZugferdDocumentPdfReaderExt::readAndGuessFromContent($pdfContent);
    }

    public function testReadFromContentWhichHasValidAttachment(): void
    {
        $pdfContent = file_get_contents(__DIR__ . "/../assets/pdf_zf_en16931_1.pdf");

        $document = ZugferdDocumentPdfReaderExt::readAndGuessFromContent($pdfContent);

        $this->checkDocumentReader($document);
    }

    public function testGetXmlFromFileWhichDoesNotExist(): void
    {
        $this->expectException(ZugferdFileNotFoundException::class);

        ZugferdDocumentPdfReaderExt::getInvoiceDocumentContentFromFile(__DIR__ . "/../assets/unknown.pdf");
    }

    public function testGetXmlFromFileWhichHasNoValidAttachment(): void
    {
        $this->expectException(ZugferdNoPdfAttachmentFoundException::class);
        $this->expectExceptionMessage('No PDF attachment found');
        $this->expectExceptionCode(ZugferdExceptionCodes::NOPDFATTACHMENTFOUND);

        ZugferdDocumentPdfReaderExt::getInvoiceDocumentContentFromFile(__DIR__ . "/../assets/pdf_invalid.pdf");
    }

    public function testGetXmlFromFileWhichExistsAndHasValidAttachment(): void
    {
        $xmlString = ZugferdDocumentPdfReaderExt::getInvoiceDocumentContentFromFile(__DIR__ . "/../assets/pdf_zf_en16931_1.pdf");

        $this->checkInvoiceDocumentXml($xmlString);
    }

    public function testGetXmlFromContentWhichHasNoValidAttachment(): void
    {
        $this->expectException(ZugferdNoPdfAttachmentFoundException::class);
        $this->expectExceptionMessage('No PDF attachment found');
        $this->expectExceptionCode(ZugferdExceptionCodes::NOPDFATTACHMENTFOUND);

        $pdfContent = file_get_contents(__DIR__ . "/../assets/pdf_invalid.pdf");

        ZugferdDocumentPdfReaderExt::getInvoiceDocumentContentFromContent($pdfContent);
    }

    public function testGetXmlFromContentWhichHasValidAttachment(): void
    {
        $pdfContent = file_get_contents(__DIR__ . "/../assets/pdf_zf_en16931_1.pdf");

        $xmlString = ZugferdDocumentPdfReaderExt::getInvoiceDocumentContentFromContent($pdfContent);

        $this->checkInvoiceDocumentXml($xmlString);
    }

    public function testAdditionalAttachments(): void
    {
        $filename = __DIR__ . "/../assets/pdf_zf_en16931_2.pdf";

        $xmlString = ZugferdDocumentPdfReaderExt::getInvoiceDocumentContentFromFile($filename);

        $this->checkInvoiceDocumentXml($xmlString);

        $additionalDocuments = ZugferdDocumentPdfReaderExt::getAdditionalDocumentContentsFromFile($filename);

        $this->checkAdditionalAttachments($additionalDocuments);

        $pdfContent = file_get_contents($filename);
        $additionalDocuments = ZugferdDocumentPdfReaderExt::getAdditionalDocumentContentsFromContent($pdfContent);

        $this->checkAdditionalAttachments($additionalDocuments);
    }

    public function testInvoiceDocumentAndAttachmentsNoStatic(): void
    {
        $pdfReaderExt = ZugferdDocumentPdfReaderExt::fromFile(__DIR__ . "/../assets/pdf_zf_en16931_2.pdf");

        $documentReader = $pdfReaderExt->resolveInvoiceDocumentReader();

        $this->checkDocumentReader($documentReader);

        $xmlString = $pdfReaderExt->resolveInvoiceDocumentContent();

        $this->checkInvoiceDocumentXml($xmlString);

        $additionalDocuments = $pdfReaderExt->resolveAdditionalDocumentContents();

        $this->checkAdditionalAttachments($additionalDocuments);
    }

    private function checkDocumentReader($documentReader): void
    {
        $this->assertNotNull($documentReader);
        $this->assertInstanceOf(ZugferdDocument::class, $documentReader);
        $this->assertInstanceOf(ZugferdDocumentReader::class, $documentReader);
    }

    private function checkInvoiceDocumentXml($xmlString): void
    {
        $this->assertNotNull($xmlString);
        $this->assertIsString($xmlString);
        $this->assertStringContainsString("<?xml version='1.0'", $xmlString);
        $this->assertStringContainsString("<rsm:CrossIndustryInvoice", $xmlString);
        $this->assertStringContainsString("</rsm:CrossIndustryInvoice>", $xmlString);
    }

    private function checkAdditionalAttachments($additionalDocuments): void
    {
        $this->assertNotEmpty($additionalDocuments);
        $this->assertCount(2, $additionalDocuments);
        $this->assertArrayHasKey(0, $additionalDocuments);
        $this->assertArrayHasKey(1, $additionalDocuments);
        $this->assertArrayNotHasKey(2, $additionalDocuments);
        $this->assertArrayNotHasKey(3, $additionalDocuments);

        $this->assertIsArray($additionalDocuments[0]);
        $this->assertArrayHasKey(ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE, $additionalDocuments[0]);
        $this->assertArrayHasKey(ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_CONTENT, $additionalDocuments[0]);
        $this->assertArrayHasKey(ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_FILENAME, $additionalDocuments[0]);
        $this->assertArrayHasKey(ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_MIMETYPE, $additionalDocuments[0]);
        $this->assertEquals(1, $additionalDocuments[0][ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE]);
        $this->assertEquals('Aufmass.png', $additionalDocuments[0][ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_FILENAME]);
        $this->assertEquals('image/png', $additionalDocuments[0][ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_MIMETYPE]);

        $this->assertIsArray($additionalDocuments[1]);
        $this->assertArrayHasKey(ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE, $additionalDocuments[1]);
        $this->assertArrayHasKey(ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_CONTENT, $additionalDocuments[1]);
        $this->assertArrayHasKey(ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_FILENAME, $additionalDocuments[1]);
        $this->assertArrayHasKey(ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_MIMETYPE, $additionalDocuments[1]);
        $this->assertEquals(1, $additionalDocuments[1][ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE]);
        $this->assertEquals('ElektronRapport.pdf', $additionalDocuments[1][ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_FILENAME]);
        $this->assertEquals('application/pdf', $additionalDocuments[1][ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_MIMETYPE]);
    }
}
