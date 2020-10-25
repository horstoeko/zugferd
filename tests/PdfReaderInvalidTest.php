<?php

namespace horstoeko\zugferd\tests;

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdDocumentPdfReader;
use horstoeko\zugferd\ZugferdDocumentReader;

class PdfReaderInvalidTest extends TestCase
{
    /**
     * @var ZugferdDocumentPdfReader
     */
    protected static $pdfReader;

    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$pdfReader = new ZugferdDocumentPdfReader();
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentPdfReader::readAndGuessFromFile
     */
    public function testCanReadPdf()
    {
        self::$document = self::$pdfReader->readAndGuessFromFile(dirname(__FILE__) . "/data/InvalidPDF.pdf");
        $this->assertNull(self::$document);
    }
}
