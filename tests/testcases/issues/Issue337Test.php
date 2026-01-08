<?php

namespace horstoeko\zugferd\tests\testcases\issues;

use DateTime;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\tests\traits\HandlesXmlTests;
use horstoeko\zugferd\codelists\ZugferdCurrencyCodes;
use horstoeko\zugferd\exception\ZugferdUnsupportedMimetype;

class Issue337Test extends TestCase
{
    use HandlesXmlTests;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);

        self::$document->setDocumentInformation(
            'R-2024/00001',
            ZugferdInvoiceType::INVOICE,
            DateTime::createFromFormat("Ymd", "20241231"),
            ZugferdCurrencyCodes::EURO
        );
    }

    public function testBase64(): void
    {
        self::$document->addDocumentInvoiceSupportingDocumentWithBase64Data('REFDOC-2024/00001-1', '00_AdditionalDocument.unknwon', $this->deliverBase64EncodedPdf(), 'Attachment 1');
        self::$document->addDocumentInvoiceSupportingDocumentWithFile('REFDOC-2024/00001-2', __DIR__ . '/../../assets/pdf_plain.pdf', 'Attachment 2');
        self::$document->addDocumentInvoiceSupportingDocumentWithBase64Data('REFDOC-2024/00001-3', '02_AdditionalDocument.unknwon', $this->deliverBase64EncodedJpeg(), 'Attachment 3');

        $this->assertXPathValueWithIndex('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:IssuerAssignedID', 0, 'REFDOC-2024/00001-1');
        $this->assertXPathValueWithIndex('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:TypeCode', 0, '916');
        $this->assertXPathValueWithIndexAndAttribute('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:AttachmentBinaryObject', 0, $this->deliverBase64EncodedPdf(), 'mimeCode', 'application/pdf');
        $this->assertXPathValueWithIndexAndAttribute('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:AttachmentBinaryObject', 0, $this->deliverBase64EncodedPdf(), 'filename', '00_AdditionalDocument.pdf');

        $this->assertXPathValueWithIndex('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:IssuerAssignedID', 1, 'REFDOC-2024/00001-2');
        $this->assertXPathValueWithIndex('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:TypeCode', 1, '916');
        $this->assertXPathValueWithIndexAndAttribute('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:AttachmentBinaryObject', 1, $this->deliverBase64EncodedPdf(), 'mimeCode', 'application/pdf');
        $this->assertXPathValueWithIndexAndAttribute('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:AttachmentBinaryObject', 1, $this->deliverBase64EncodedPdf(), 'filename', 'pdf_plain.pdf');

        $this->assertXPathValueWithIndex('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:IssuerAssignedID', 2, 'REFDOC-2024/00001-3');
        $this->assertXPathValueWithIndex('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:TypeCode', 2, '916');
        $this->assertXPathValueWithIndexAndAttribute('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:AttachmentBinaryObject', 2, $this->deliverBase64EncodedJpeg(), 'mimeCode', 'image/jpeg');
        $this->assertXPathValueWithIndexAndAttribute('//rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:AdditionalReferencedDocument/ram:AttachmentBinaryObject', 2, $this->deliverBase64EncodedJpeg(), 'filename', '02_AdditionalDocument.jpeg');
    }

    public function testBase64UnknownMimeType(): void
    {
        $this->expectException(ZugferdUnsupportedMimetype::class);

        self::$document->addDocumentInvoiceSupportingDocumentWithBase64Data('REFDOC-2024/00001-1', '00_AdditionalDocument.unknwon', $this->deliverBase64UnknownMimeType(), 'Attachment 1');
    }

    private function deliverBase64EncodedPdf(): string
    {
        $content = file_get_contents(__DIR__ . '/../../assets/pdf_plain.pdf');
        return base64_encode($content);
    }

    private function deliverBase64EncodedJpeg(): string
    {
        $content = file_get_contents(__DIR__ . '/../../assets/dummy_picture.jpg');
        return base64_encode($content);
    }

    private function deliverBase64UnknownMimeType(): string
    {
        $content = file_get_contents(__DIR__ . '/../../assets/csv_dummy.csv');
        return base64_encode($content);
    }
}
