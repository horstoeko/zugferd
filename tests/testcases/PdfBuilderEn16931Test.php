<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\codelists\ZugferdPaymentMeans;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdUnknownMimetype;
use horstoeko\zugferd\exception\ZugferdInvalidArgumentException;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\tests\traits\HandlesXmlTests;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentPdfBuilder;
use horstoeko\zugferd\ZugferdDocumentPdfBuilderAbstract;
use horstoeko\zugferd\ZugferdProfiles;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\StreamReader;
use Smalot\PdfParser\Parser as PdfParser;

class PdfBuilderEn16931Test extends TestCase
{
    use HandlesXmlTests;

    /**
     * Source pdf filename
     *
     * @var string
     */
    protected static $sourcePdfFilename = "";

    /**
     * Destination pdf filename
     *
     * @var string
     */
    protected static $destPdfFilename = "";

    public static function setUpBeforeClass(): void
    {
        self::$sourcePdfFilename = __DIR__ . "/../assets/pdf_plain.pdf";
        self::$destPdfFilename = __DIR__ . "/../assets/GeneratedPDF.pdf";

        self::$document = (ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931))
            ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
            ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
            ->addDocumentNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, null, 'REG')
            ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
            ->addDocumentPaymentMean(ZugferdPaymentMeans::UNTDID_4461_58, null, null, null, null, null, "DE12500105170648489890", null, null, null)
            ->setDocumentSeller("Lieferant GmbH", "549910")
            ->addDocumentSellerGlobalId("4000001123452", "0088")
            ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
            ->addDocumentSellerTaxRegistration("VA", "DE123456789")
            ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
            ->setDocumentSellerContact("Heinz Mükker", "Buchhaltung", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de")
            ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
            ->setDocumentBuyerReference("34676-342323")
            ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
            ->addDocumentTax("S", "VAT", 275.0, 19.25, 7.0)
            ->addDocumentTax("S", "VAT", 198.0, 37.62, 19.0)
            ->setDocumentSummation(529.87, 529.87, 473.00, 0.0, 0.0, 473.00, 56.87, null, 0.0)
            ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
            ->addNewPosition("1")
            ->setDocumentPositionNote("Bemerkung zu Zeile 1")
            ->setDocumentPositionProductDetails("Trennblätter A4", "", "TB100A4", null, "0160", "4012345001235")
            ->addDocumentPositionProductCharacteristic("Farbe", "Gelb")
            ->addDocumentPositionProductClassification("ClassCode", "ClassName", "ListId", "ListVersionId")
            ->setDocumentPositionProductOriginTradeCountry("CN")
            ->setDocumentPositionGrossPrice(9.9000)
            ->setDocumentPositionNetPrice(9.9000)
            ->setDocumentPositionQuantity(20, "H87")
            ->addDocumentPositionTax('S', 'VAT', 19)
            ->setDocumentPositionLineSummation(198.0)
            ->addNewPosition("2")
            ->setDocumentPositionNote("Bemerkung zu Zeile 2")
            ->setDocumentPositionProductDetails("Joghurt Banane", "", "ARNR2", null, "0160", "4000050986428")
            ->addDocumentPositionProductCharacteristic("Suesstoff", "Nein")
            ->addDocumentPositionProductClassification("ClassCode", "ClassName", "ListId", "ListVersionId")
            ->SetDocumentPositionGrossPrice(5.5000)
            ->SetDocumentPositionNetPrice(5.5000)
            ->SetDocumentPositionQuantity(50, "H87")
            ->AddDocumentPositionTax('S', 'VAT', 7)
            ->SetDocumentPositionLineSummation(275.0);
    }

    public static function tearDownAfterClass(): void
    {
        @unlink(self::$destPdfFilename);
    }

    /**
     * Tests
     */
    public function testBuildFromSourcePdfFileWhichDoesNotExist(): void
    {
        $this->expectException(ZugferdFileNotFoundException::class);
        $this->expectExceptionMessage('The file /tmp/anonexisting.pdf was not found');

        ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, '/tmp/anonexisting.pdf');
    }

    public function testBuildFromSourcePdfFile(): void
    {
        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $this->assertFileExists(self::$destPdfFilename);

        ob_start();
        $pdfBuilder->saveDocumentInline(self::$destPdfFilename);
        $pdfContent = ob_get_clean();

        $this->assertIsString($pdfContent);
        $this->assertNotSame('', $pdfContent);

        $pdfContent = $pdfBuilder->downloadString();

        $this->assertNotSame('', $pdfContent);
        $this->assertStringStartsNotWith('%PDF-1.4', $pdfContent);
    }

    public function testBuildFromSourcePdfStringWhichIsInvalid(): void
    {
        $this->expectException(PdfParserException::class);
        $this->expectExceptionMessage('Unable to find PDF file header.');

        $pdfContent = 'this_is_not_a_pdf_string';

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfString(self::$document, $pdfContent);
        $pdfBuilder->generateDocument();
    }

    public function testBuildFromSourcePdfString(): void
    {
        $pdfContent = file_get_contents(self::$sourcePdfFilename);

        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, $pdfContent);
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $this->assertFileExists(self::$destPdfFilename);

        ob_start();
        $pdfBuilder->saveDocumentInline(self::$destPdfFilename);
        $pdfContent = ob_get_clean();

        $this->assertIsString($pdfContent);
        $this->assertNotSame('', $pdfContent);

        $pdfContent = $pdfBuilder->downloadString();

        $this->assertNotSame('', $pdfContent);
        $this->assertStringStartsNotWith('%PDF-1.4', $pdfContent);
    }

    public function testPdfMetaData(): void
    {
        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails); //"FPDF 1.84"
        $this->assertArrayHasKey("CreationDate", $pdfDetails); //"2020-12-09T05:19:39+00:00"
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails); //"1"
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["CreationDate"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["Title"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["Subject"]);
        $this->assertEquals("Lieferant GmbH", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["dc:title"]);
        $this->assertEquals("Lieferant GmbH", $pdfDetails["dc:creator"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString("2018-03-05", $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["xmp:modifydate"]);
    }

    public function testSetAdditionalCreatorTool(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setAdditionalCreatorTool('Dummy');

        $this->assertStringStartsWith('Dummy / Factur-X PHP library', $pdfBuilder->getCreatorToolName());
    }

    public function testSetAttachmentRelationshipTypeToUnknown(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setAttachmentRelationshipType('unknown');

        $this->assertSame(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_DATA, $pdfBuilder->getAttachmentRelationshipType());
    }

    public function testSetAttachmentRelationshipTypeToData(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setAttachmentRelationshipType('Data');

        $this->assertSame(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_DATA, $pdfBuilder->getAttachmentRelationshipType());
    }

    public function testSetAttachmentRelationshipTypeToAlternative(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setAttachmentRelationshipType('Alternative');

        $this->assertSame(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_ALTERNATIVE, $pdfBuilder->getAttachmentRelationshipType());
    }

    public function testSetAttachmentRelationshipTypeToSource(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setAttachmentRelationshipType('Source');

        $this->assertSame(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_SOURCE, $pdfBuilder->getAttachmentRelationshipType());
    }

    public function testSetAttachmentRelationshipTypeToDataDirect(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setAttachmentRelationshipTypeToData();

        $this->assertSame(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_DATA, $pdfBuilder->getAttachmentRelationshipType());
    }

    public function testSetAttachmentRelationshipTypeToAlternativeDirect(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setAttachmentRelationshipTypeToAlternative();

        $this->assertSame(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_ALTERNATIVE, $pdfBuilder->getAttachmentRelationshipType());
    }

    public function testSetAttachmentRelationshipTypeToSourceDirect(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setAttachmentRelationshipTypeToSource();

        $this->assertSame(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_SOURCE, $pdfBuilder->getAttachmentRelationshipType());
    }

    public function testAttachAdditionalFileFileDoesNotExist(): void
    {
        $filename = __DIR__ . '/unknown.txt';

        $this->expectException(ZugferdFileNotFoundException::class);
        $this->expectExceptionMessage(sprintf("The file %s was not found", $filename));

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByRealFile($filename);
    }

    public function testAttachAdditionalFileFileIsEmpty(): void
    {
        $this->expectException(ZugferdInvalidArgumentException::class);
        $this->expectExceptionMessage("You must specify a filename for the content to attach");

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByRealFile("");
    }

    public function testAttachAdditionalFileMimetypeUnknown(): void
    {
        $filename = __DIR__ . "/../assets/dummy_attachment_1.dummy";

        $this->expectException(ZugferdUnknownMimetype::class);
        $this->expectExceptionMessage("No mimetype found");

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByRealFile($filename);
    }

    public function testAttachAdditionalFileInvalidRelationShip(): void
    {
        $filename = __DIR__ . "/../assets/txt_addattachment_1.txt";

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByRealFile($filename, "", "Dummy");

        $property = $this->getPrivatePropertyFromClassname(ZugferdDocumentPdfBuilderAbstract::class, "additionalFilesToAttach");

        $this->assertIsArray($property->getValue($pdfBuilder));
        $this->assertIsArray($property->getValue($pdfBuilder)[0]);
        $this->assertEquals(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_SUPPLEMENT, $property->getValue($pdfBuilder)[0][3]);
    }

    public function testAttachAdditionalFileValidRelationShip(): void
    {
        $filename = __DIR__ . "/../assets/txt_addattachment_1.txt";

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByRealFile($filename, "", "Alternative");

        $property = $this->getPrivatePropertyFromClassname(ZugferdDocumentPdfBuilderAbstract::class, "additionalFilesToAttach");

        $this->assertIsArray($property->getValue($pdfBuilder));
        $this->assertIsArray($property->getValue($pdfBuilder)[0]);
        $this->assertEquals(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_ALTERNATIVE, $property->getValue($pdfBuilder)[0][3]);
    }

    public function testAttachAdditionalFileFinalResult(): void
    {
        $filename = __DIR__ . "/../assets/txt_addattachment_1.txt";

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByRealFile($filename, "", "Alternative");

        $property = $this->getPrivatePropertyFromClassname(ZugferdDocumentPdfBuilderAbstract::class, "additionalFilesToAttach");

        $this->assertIsArray($property->getValue($pdfBuilder));
        $this->assertIsArray($property->getValue($pdfBuilder)[0]);
        $this->assertInstanceOf(StreamReader::class, $property->getValue($pdfBuilder)[0][0]);
        $this->assertEquals("txt_addattachment_1.txt", $property->getValue($pdfBuilder)[0][1]);
        $this->assertEquals("txt_addattachment_1.txt", $property->getValue($pdfBuilder)[0][2]);
        $this->assertEquals(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_ALTERNATIVE, $property->getValue($pdfBuilder)[0][3]);

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByRealFile($filename, "An Attachment", "Alternative");

        $property = $this->getPrivatePropertyFromClassname(ZugferdDocumentPdfBuilderAbstract::class, "additionalFilesToAttach");

        $this->assertIsArray($property->getValue($pdfBuilder));
        $this->assertIsArray($property->getValue($pdfBuilder)[0]);
        $this->assertInstanceOf(StreamReader::class, $property->getValue($pdfBuilder)[0][0]);
        $this->assertEquals("txt_addattachment_1.txt", $property->getValue($pdfBuilder)[0][1]);
        $this->assertEquals("An Attachment", $property->getValue($pdfBuilder)[0][2]);
        $this->assertEquals(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_ALTERNATIVE, $property->getValue($pdfBuilder)[0][3]);
    }

    public function testAdditionalFilesAreEmbedded(): void
    {
        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByRealFile(__DIR__ . "/../assets/txt_addattachment_1.txt");
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfFilespecs = $pdfParsed->getObjectsByType('Filespec');

        $this->assertCount(2, $pdfFilespecs);
        $this->assertArrayHasKey("8_0", $pdfFilespecs);
        $this->assertArrayHasKey("10_0", $pdfFilespecs);

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

        $pdfFilespec = $pdfFilespecs["10_0"];
        $pdfFilespecDetails = $pdfFilespec->getDetails();

        $this->assertIsArray($pdfFilespecDetails);
        $this->assertArrayHasKey("F", $pdfFilespecDetails);
        $this->assertArrayHasKey("Type", $pdfFilespecDetails);
        $this->assertArrayHasKey("UF", $pdfFilespecDetails);
        $this->assertArrayHasKey("AFRelationship", $pdfFilespecDetails);
        $this->assertArrayHasKey("Desc", $pdfFilespecDetails);
        $this->assertArrayHasKey("EF", $pdfFilespecDetails);
        $this->assertEquals("txt_addattachment_1.txt", $pdfFilespecDetails["F"]);
        $this->assertEquals("Filespec", $pdfFilespecDetails["Type"]);
        $this->assertEquals("txt_addattachment_1.txt", $pdfFilespecDetails["UF"]);
        $this->assertEquals(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_SUPPLEMENT, $pdfFilespecDetails["AFRelationship"]);
        $this->assertEquals("txt_addattachment_1.txt", $pdfFilespecDetails["Desc"]);

        $pdfFilespecDetailsEF = $pdfFilespecDetails["EF"];
        $this->assertIsArray($pdfFilespecDetailsEF);
        $this->assertArrayHasKey("F", $pdfFilespecDetailsEF);
        $this->assertArrayHasKey("UF", $pdfFilespecDetailsEF);

        $pdfFilespecDetailsEF_F = $pdfFilespecDetailsEF["F"];
        $this->assertIsArray($pdfFilespecDetailsEF_F);
        $this->assertArrayHasKey("Filter", $pdfFilespecDetailsEF_F);
        $this->assertArrayHasKey("Subtype", $pdfFilespecDetailsEF_F);
        $this->assertArrayHasKey("Type", $pdfFilespecDetailsEF_F);
        $this->assertArrayHasKey("Length", $pdfFilespecDetailsEF_F);
        $this->assertEquals("FlateDecode", $pdfFilespecDetailsEF_F["Filter"]);
        $this->assertEquals("text/plain", $pdfFilespecDetailsEF_F["Subtype"]);
        $this->assertEquals("EmbeddedFile", $pdfFilespecDetailsEF_F["Type"]);
        $this->assertEquals(195, $pdfFilespecDetailsEF_F["Length"]);

        $pdfFilespecDetailsEF_UF = $pdfFilespecDetailsEF["UF"];
        $this->assertIsArray($pdfFilespecDetailsEF_UF);
        $this->assertArrayHasKey("Filter", $pdfFilespecDetailsEF_UF);
        $this->assertArrayHasKey("Subtype", $pdfFilespecDetailsEF_UF);
        $this->assertArrayHasKey("Type", $pdfFilespecDetailsEF_UF);
        $this->assertArrayHasKey("Length", $pdfFilespecDetailsEF_UF);
        $this->assertEquals("FlateDecode", $pdfFilespecDetailsEF_UF["Filter"]);
        $this->assertEquals("text/plain", $pdfFilespecDetailsEF_UF["Subtype"]);
        $this->assertEquals("EmbeddedFile", $pdfFilespecDetailsEF_UF["Type"]);
        $this->assertEquals(195, $pdfFilespecDetailsEF_UF["Length"]);
    }

    public function testAttachAdditionalFileByContentEmptyContent(): void
    {
        $this->expectException(ZugferdInvalidArgumentException::class);
        $this->expectExceptionMessage("You must specify a content to attach");

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByContent("", "", "", "");
    }

    public function testAttachAdditionalFileByContentEmptyFilename(): void
    {
        $this->expectException(ZugferdInvalidArgumentException::class);
        $this->expectExceptionMessage("You must specify a filename for the content to attach");

        $filename = __DIR__ . "/../assets/txt_addattachment_1.txt";

        $content = file_get_contents($filename);

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByContent($content, "", "", "");
    }

    public function testAttachAdditionalFileByContentAllValid(): void
    {
        $filename = __DIR__ . "/../assets/txt_addattachment_1.txt";

        $content = file_get_contents($filename);

        $pdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->attachAdditionalFileByContent($content, "file.txt", "A file attachment");
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfFilespecs = $pdfParsed->getObjectsByType('Filespec');

        $this->assertCount(2, $pdfFilespecs);
        $this->assertArrayHasKey("8_0", $pdfFilespecs);
        $this->assertArrayHasKey("10_0", $pdfFilespecs);

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

        $pdfFilespec = $pdfFilespecs["10_0"];
        $pdfFilespecDetails = $pdfFilespec->getDetails();

        $this->assertIsArray($pdfFilespecDetails);
        $this->assertArrayHasKey("F", $pdfFilespecDetails);
        $this->assertArrayHasKey("Type", $pdfFilespecDetails);
        $this->assertArrayHasKey("UF", $pdfFilespecDetails);
        $this->assertArrayHasKey("AFRelationship", $pdfFilespecDetails);
        $this->assertArrayHasKey("Desc", $pdfFilespecDetails);
        $this->assertArrayHasKey("EF", $pdfFilespecDetails);
        $this->assertEquals("file.txt", $pdfFilespecDetails["F"]);
        $this->assertEquals("Filespec", $pdfFilespecDetails["Type"]);
        $this->assertEquals("file.txt", $pdfFilespecDetails["UF"]);
        $this->assertEquals(ZugferdDocumentPdfBuilder::AF_RELATIONSHIP_SUPPLEMENT, $pdfFilespecDetails["AFRelationship"]);
        $this->assertEquals("A file attachment", $pdfFilespecDetails["Desc"]);

        $pdfFilespecDetailsEF = $pdfFilespecDetails["EF"];
        $this->assertIsArray($pdfFilespecDetailsEF);
        $this->assertArrayHasKey("F", $pdfFilespecDetailsEF);
        $this->assertArrayHasKey("UF", $pdfFilespecDetailsEF);

        $pdfFilespecDetailsEF_F = $pdfFilespecDetailsEF["F"];
        $this->assertIsArray($pdfFilespecDetailsEF_F);
        $this->assertArrayHasKey("Filter", $pdfFilespecDetailsEF_F);
        $this->assertArrayHasKey("Subtype", $pdfFilespecDetailsEF_F);
        $this->assertArrayHasKey("Type", $pdfFilespecDetailsEF_F);
        $this->assertArrayHasKey("Length", $pdfFilespecDetailsEF_F);
        $this->assertEquals("FlateDecode", $pdfFilespecDetailsEF_F["Filter"]);
        $this->assertEquals("text/plain", $pdfFilespecDetailsEF_F["Subtype"]);
        $this->assertEquals("EmbeddedFile", $pdfFilespecDetailsEF_F["Type"]);
        $this->assertEquals(195, $pdfFilespecDetailsEF_F["Length"]);

        $pdfFilespecDetailsEF_UF = $pdfFilespecDetailsEF["UF"];
        $this->assertIsArray($pdfFilespecDetailsEF_UF);
        $this->assertArrayHasKey("Filter", $pdfFilespecDetailsEF_UF);
        $this->assertArrayHasKey("Subtype", $pdfFilespecDetailsEF_UF);
        $this->assertArrayHasKey("Type", $pdfFilespecDetailsEF_UF);
        $this->assertArrayHasKey("Length", $pdfFilespecDetailsEF_UF);
        $this->assertEquals("FlateDecode", $pdfFilespecDetailsEF_UF["Filter"]);
        $this->assertEquals("text/plain", $pdfFilespecDetailsEF_UF["Subtype"]);
        $this->assertEquals("EmbeddedFile", $pdfFilespecDetailsEF_UF["Type"]);
        $this->assertEquals(195, $pdfFilespecDetailsEF_UF["Length"]);
    }

    public function testDeterministicMode(): void
    {
        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setDeterministicModeEnabled(true);
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails);
        $this->assertArrayHasKey("CreationDate", $pdfDetails);
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails);
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString('2000-01-01', $pdfDetails["CreationDate"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["Title"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["Subject"]);
        $this->assertEquals("Lieferant GmbH", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["dc:title"]);
        $this->assertEquals("Lieferant GmbH", $pdfDetails["dc:creator"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString('2000-01-01', $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString('2000-01-01', $pdfDetails["xmp:modifydate"]);
    }

    public function testCustomMetaInformation(): void
    {
        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setTitleTemplate('%3$s : %2$s %1$s');
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails);
        $this->assertArrayHasKey("CreationDate", $pdfDetails);
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails);
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["CreationDate"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["Title"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["Subject"]);
        $this->assertEquals("Lieferant GmbH", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["dc:title"]);
        $this->assertEquals("Lieferant GmbH", $pdfDetails["dc:creator"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString("2018-03-05", $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["xmp:modifydate"]);

        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setTitleTemplate('%3$s : %2$s %1$s');
        $pdfBuilder->setKeywordTemplate('%1$s, %2$s, %3$s, %4$s');
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails);
        $this->assertArrayHasKey("CreationDate", $pdfDetails);
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails);
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["CreationDate"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["Title"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["Subject"]);
        $this->assertEquals("Lieferant GmbH", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["dc:title"]);
        $this->assertEquals("Lieferant GmbH", $pdfDetails["dc:creator"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString("2018-03-05", $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["xmp:modifydate"]);

        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setTitleTemplate('%3$s : %2$s %1$s');
        $pdfBuilder->setKeywordTemplate('%1$s, %2$s, %3$s, %4$s');
        $pdfBuilder->setAuthorTemplate('Issued by seller with name %3$s');
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails);
        $this->assertArrayHasKey("CreationDate", $pdfDetails);
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails);
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["CreationDate"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["Title"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["Subject"]);
        $this->assertEquals("Issued by seller with name Lieferant GmbH", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["dc:title"]);
        $this->assertEquals("Issued by seller with name Lieferant GmbH", $pdfDetails["dc:creator"]);
        $this->assertEquals("FacturX/ZUGFeRD Invoice 471102 dated 2018-03-05 issued by Lieferant GmbH", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString("2018-03-05", $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["xmp:modifydate"]);

        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setTitleTemplate('%3$s : %2$s %1$s');
        $pdfBuilder->setKeywordTemplate('%1$s, %2$s, %3$s, %4$s');
        $pdfBuilder->setAuthorTemplate('Issued by seller with name %3$s');
        $pdfBuilder->setSubjectTemplate('%2$s-Document, Issued by %3$s');
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails);
        $this->assertArrayHasKey("CreationDate", $pdfDetails);
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails);
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["CreationDate"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["Title"]);
        $this->assertEquals("Invoice-Document, Issued by Lieferant GmbH", $pdfDetails["Subject"]);
        $this->assertEquals("Issued by seller with name Lieferant GmbH", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["dc:title"]);
        $this->assertEquals("Issued by seller with name Lieferant GmbH", $pdfDetails["dc:creator"]);
        $this->assertEquals("Invoice-Document, Issued by Lieferant GmbH", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString("2018-03-05", $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["xmp:modifydate"]);

        $whichArray = [];

        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setMetaInformationCallback(
            function ($which) use (&$whichArray) {
                $whichArray[] = $which;

                $this->assertIsString($which);
                $this->assertContains($which, ['author', 'keywords', 'title', 'subject']);

                if ($which === 'title') {
                    return "DummyTitle";
                }

                if ($which === 'author') {
                    return "DummyAuthor";
                }

                if ($which === 'subject') {
                    return "DummySubject";
                }
            }
        );
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $this->assertNotEmpty($whichArray);
        $this->assertCount(4, $whichArray);
        $this->assertContains('author', $whichArray);
        $this->assertContains('keywords', $whichArray);
        $this->assertContains('title', $whichArray);
        $this->assertContains('subject', $whichArray);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails);
        $this->assertArrayHasKey("CreationDate", $pdfDetails);
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails);
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["CreationDate"]);
        $this->assertEquals("DummyTitle", $pdfDetails["Title"]);
        $this->assertEquals("DummySubject", $pdfDetails["Subject"]);
        $this->assertEquals("DummyAuthor", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("DummyTitle", $pdfDetails["dc:title"]);
        $this->assertEquals("DummyAuthor", $pdfDetails["dc:creator"]);
        $this->assertEquals("DummySubject", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString("2018-03-05", $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["xmp:modifydate"]);

        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setMetaInformationCallback(
            function ($which) {
                if ($which === 'title') {
                    return "";
                }

                if ($which === 'author') {
                    return "";
                }

                if ($which === 'subject') {
                    return "";
                }
            }
        );
        $pdfBuilder->setTitleTemplate('%3$s : %2$s %1$s');
        $pdfBuilder->setKeywordTemplate('%1$s, %2$s, %3$s, %4$s');
        $pdfBuilder->setAuthorTemplate('Issued by seller with name %3$s');
        $pdfBuilder->setSubjectTemplate('%2$s-Document, Issued by %3$s');
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails);
        $this->assertArrayHasKey("CreationDate", $pdfDetails);
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails);
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["CreationDate"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["Title"]);
        $this->assertEquals("Invoice-Document, Issued by Lieferant GmbH", $pdfDetails["Subject"]);
        $this->assertEquals("Issued by seller with name Lieferant GmbH", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["dc:title"]);
        $this->assertEquals("Issued by seller with name Lieferant GmbH", $pdfDetails["dc:creator"]);
        $this->assertEquals("Invoice-Document, Issued by Lieferant GmbH", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString("2018-03-05", $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["xmp:modifydate"]);

        $pdfBuilder = new ZugferdDocumentPdfBuilder(self::$document, self::$sourcePdfFilename);
        $pdfBuilder->setMetaInformationCallback(null);
        $pdfBuilder->setTitleTemplate('%3$s : %2$s %1$s');
        $pdfBuilder->setKeywordTemplate('%1$s, %2$s, %3$s, %4$s');
        $pdfBuilder->setAuthorTemplate('Issued by seller with name %3$s');
        $pdfBuilder->setSubjectTemplate('%2$s-Document, Issued by %3$s');
        $pdfBuilder->generateDocument();
        $pdfBuilder->saveDocument(self::$destPdfFilename);

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile(self::$destPdfFilename);
        $pdfDetails = $pdfParsed->getDetails();

        $this->assertArrayHasKey("Producer", $pdfDetails);
        $this->assertArrayHasKey("CreationDate", $pdfDetails);
        $this->assertArrayHasKey("Title", $pdfDetails);
        $this->assertArrayHasKey("Subject", $pdfDetails);
        $this->assertArrayHasKey("Author", $pdfDetails);
        $this->assertArrayHasKey("Keywords", $pdfDetails);
        $this->assertArrayHasKey("Pages", $pdfDetails);
        $this->assertArrayHasKey("fx:documenttype", $pdfDetails);
        $this->assertArrayHasKey("fx:documentfilename", $pdfDetails);
        $this->assertArrayHasKey("fx:version", $pdfDetails);
        $this->assertArrayHasKey("fx:conformancelevel", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:part", $pdfDetails);
        $this->assertArrayHasKey("pdfaid:conformance", $pdfDetails);
        $this->assertArrayHasKey("dc:title", $pdfDetails);
        $this->assertArrayHasKey("dc:creator", $pdfDetails);
        $this->assertArrayHasKey("dc:description", $pdfDetails);
        $this->assertArrayHasKey("xmp:creatortool", $pdfDetails);
        $this->assertArrayHasKey("xmp:createdate", $pdfDetails);
        $this->assertArrayHasKey("xmp:modifydate", $pdfDetails);
        $this->assertStringContainsString('FPDF', $pdfDetails["Producer"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["CreationDate"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["Title"]);
        $this->assertEquals("Invoice-Document, Issued by Lieferant GmbH", $pdfDetails["Subject"]);
        $this->assertEquals("Issued by seller with name Lieferant GmbH", $pdfDetails["Author"]);
        $this->assertEquals("1", $pdfDetails["Pages"]);
        $this->assertEquals("INVOICE", $pdfDetails["fx:documenttype"]);
        $this->assertEquals("factur-x.xml", $pdfDetails["fx:documentfilename"]);
        $this->assertEquals("1.0", $pdfDetails["fx:version"]);
        $this->assertEquals("EN 16931", $pdfDetails["fx:conformancelevel"]);
        $this->assertEquals("3", $pdfDetails["pdfaid:part"]);
        $this->assertEquals("B", $pdfDetails["pdfaid:conformance"]);
        $this->assertEquals("Lieferant GmbH : Invoice 471102", $pdfDetails["dc:title"]);
        $this->assertEquals("Issued by seller with name Lieferant GmbH", $pdfDetails["dc:creator"]);
        $this->assertEquals("Invoice-Document, Issued by Lieferant GmbH", $pdfDetails["dc:description"]);
        $this->assertStringContainsString('Factur-X PHP library', $pdfDetails["xmp:creatortool"]);
        $this->assertStringContainsString("2018-03-05", $pdfDetails["xmp:createdate"]);
        $this->assertStringContainsString(date("Y-m-d"), $pdfDetails["xmp:modifydate"]);
    }
}
