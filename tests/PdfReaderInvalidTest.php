<?php

namespace horstoeko\zugferd\tests;

use \PHPUnit\Framework\TestCase;
use \horstoeko\zugferd\ZugferdDocumentPdfReader;
use \horstoeko\zugferd\ZugferdDocumentReader;

class PdfReaderInvalidTest extends TestCase
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
        self::$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/data/InvalidPDF.pdf");
        $this->assertNull(self::$document);
    }
}
