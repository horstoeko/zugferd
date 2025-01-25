<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use Smalot\PdfParser\Parser as PdfParser;
use horstoeko\zugferd\ZugferdDocumentPdfMerger;
use horstoeko\zugferd\ZugferdDocumentPdfBuilder;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;

class PdfMergerTest extends TestCase
{
    public function testConstructByXmlFileAndPdfFile(): void
    {
        $xmlFilename = __DIR__ . '/../assets/xml_en16931_1.xml';
        $pdfFilename = __DIR__ . '/../assets/pdf_plain.pdf';

        $pdfMerger = new ZugferdDocumentPdfMerger($xmlFilename, $pdfFilename);

        $this->assertSame($xmlFilename, $this->getPrivatePropertyFromObject($pdfMerger, 'xmlDataOrFilename')->getValue($pdfMerger));

        $this->checkAndValidateMerger($pdfMerger);
    }

    public function testConstructByXmlContentAndPdfFile(): void
    {
        $xmlFilename = __DIR__ . '/../assets/xml_en16931_1.xml';
        $pdfFilename = __DIR__ . '/../assets/pdf_plain.pdf';

        $xmlContent = file_get_contents($xmlFilename);

        $pdfMerger = new ZugferdDocumentPdfMerger($xmlContent, $pdfFilename);

        $this->assertStringStartsWith("<?xml version='1.0' encoding='UTF-8'?>", $this->getPrivatePropertyFromObject($pdfMerger, 'xmlDataOrFilename')->getValue($pdfMerger));

        $this->checkAndValidateMerger($pdfMerger);
    }

    public function testConstructByXmlFileAndPdfContent(): void
    {
        $xmlFilename = __DIR__ . '/../assets/xml_en16931_1.xml';
        $pdfFilename = __DIR__ . '/../assets/pdf_plain.pdf';

        $pdfContent = file_get_contents($pdfFilename);

        $pdfMerger = new ZugferdDocumentPdfMerger($xmlFilename, $pdfContent);

        $this->assertSame($xmlFilename, $this->getPrivatePropertyFromObject($pdfMerger, 'xmlDataOrFilename')->getValue($pdfMerger));

        $this->checkAndValidateMerger($pdfMerger);
    }

    public function testConstructByXmlContentAndPdfContent(): void
    {
        $xmlFilename = __DIR__ . '/../assets/xml_en16931_1.xml';
        $pdfFilename = __DIR__ . '/../assets/pdf_plain.pdf';

        $xmlContent = file_get_contents($xmlFilename);
        $pdfContent = file_get_contents($pdfFilename);

        $pdfMerger = new ZugferdDocumentPdfMerger($xmlContent, $pdfContent);

        $this->assertStringStartsWith("<?xml version='1.0' encoding='UTF-8'?>", $this->getPrivatePropertyFromObject($pdfMerger, 'xmlDataOrFilename')->getValue($pdfMerger));

        $this->checkAndValidateMerger($pdfMerger);
    }

    private function checkAndValidateMerger(ZugferdDocumentPdfMerger $pdfMerger): void
    {
        $this->assertSame("", $this->getPrivatePropertyFromObject($pdfMerger, 'xmlDataCache')->getValue($pdfMerger));

        $pdfMerger->generateDocument();
        $pdfContent = $pdfMerger->downloadString();

        $this->assertStringStartsWith("<?xml version='1.0' encoding='UTF-8'?>", $this->getPrivatePropertyFromObject($pdfMerger, 'xmlDataCache')->getValue($pdfMerger));

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseContent($pdfContent);
        $pdfFilespecs = $pdfParsed->getObjectsByType('Filespec');

        $this->assertCount(1, $pdfFilespecs);
        $this->assertArrayHasKey("8_0", $pdfFilespecs);

        $pdfFilespec = $pdfFilespecs["8_0"];
        $pdfFilespecDetails = $pdfFilespec->getDetails();

        $this->assertIsArray($pdfFilespecDetails);
        $this->assertArrayHasKey("F", $pdfFilespecDetails);
        $this->assertArrayHasKey("Type", $pdfFilespecDetails);
        $this->assertArrayHasKey("UF", $pdfFilespecDetails);
        $this->assertArrayHasKey("AFRelationship", $pdfFilespecDetails);
        $this->assertArrayHasKey("Desc", $pdfFilespecDetails);
        $this->assertArrayHasKey("EF", $pdfFilespecDetails);
        $this->assertEquals("factur-x.xml", $pdfFilespecDetails["F"]);
        $this->assertEquals("Filespec", $pdfFilespecDetails["Type"]);
        $this->assertEquals("factur-x.xml", $pdfFilespecDetails["UF"]);
        $this->assertEquals(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_DATA, $pdfFilespecDetails["AFRelationship"]);
        $this->assertEquals("Factur-X Invoice", $pdfFilespecDetails["Desc"]);

        $this->assertSame('EN 16931', $this->getPrivateMethodFromObject($pdfMerger, 'getProfileDefinitionParameter')->invokeArgs($pdfMerger, ['xmpname']));
        $this->assertSame('EN 16931 (COMFORT)', $this->getPrivateMethodFromObject($pdfMerger, 'getProfileDefinitionParameter')->invokeArgs($pdfMerger, ['altname']));
        $this->expectException(ZugferdUnknownProfileParameterException::class);
        $this->getPrivateMethodFromObject($pdfMerger, 'getProfileDefinitionParameter')->invokeArgs($pdfMerger, ['unknown']);
    }
}
