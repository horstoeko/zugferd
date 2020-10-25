<?php

namespace horstoeko\zugferd;

use \horstoeko\zugferd\ZugferdDocumentReader;
use \Smalot\PdfParser\Parser as PdfParser;

class ZugferdDocumentPdfReader
{
    /**
     * Filename of the relevant attachment file
     */
    const ATTACHMENT_FILEAME = 'factur-x.xml';

    /**
     * PDF parser instnace
     *
     * @var \Smalot\PdfParser\Parser
     */
    protected $parser = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parser = new PdfParser();
    }

    /**
     * Load a PDF file (ZUGFeRD/Factur-X)
     *
     * @param string $pdfFilename
     * @return ZugferdDocumentReader|null
     * @throws Exception
     */
    public function readAndGuessFromFile(string $pdfFilename): ?ZugferdDocumentReader
    {
        if (!file_exists($pdfFilename)) {
            throw new \Exception("File {$pdfFilename} not found.");
        }
        if (!is_readable($pdfFilename)) {
            throw new \Exception("File {$pdfFilename} could not be read.");
        }

        $pdfParsed = $this->parser->parseFile($pdfFilename);
        $filespec = $pdfParsed->getObjectsByType('Filespec');

        $attachmentFound = false;
        $returnValue = null;

        try {
            foreach ($filespec as $spec) {
                $specDetails = $spec->getDetails();
                if (static::ATTACHMENT_FILEAME == $specDetails['F']) {
                    $attachmentFound = true;
                    break;
                }
            }

            if (true == $attachmentFound) {
                $embeddedFiles = $pdfParsed->getObjectsByType('EmbeddedFile');
                foreach ($embeddedFiles as $embedFile) {
                    $returnValue = ZugferdDocumentReader::readAndGuessFromContent($embedFile->getContent());
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Unable to get Xml from PDF : ' . $e);
        }

        return $returnValue;
    }
}
