<?php

namespace horstoeko\zugferd;

use \horstoeko\zugferd\ZugferdDocumentReader;
use \Smalot\PdfParser\Parser as PdfParser;

/**
 * Class representing the document reader for incoming PDF/A-Documents with
 * attached XML data in BASIC-, EN16931- and EXTENDED profile
 */
class ZugferdDocumentPdfReader
{
    /**
     * Filename of the relevant attachment file
     */
    const ATTACHMENT_FILEAME = 'factur-x.xml';

    /**
     * Load a PDF file (ZUGFeRD/Factur-X)
     *
     * @param string $pdfFilename
     * Contains a full-qualified filename which must exist and must be readable
     * @return ZugferdDocumentReader|null
     * @throws Exception
     */
    public static function readAndGuessFromFile(string $pdfFilename): ?ZugferdDocumentReader
    {
        if (!file_exists($pdfFilename)) {
            throw new \Exception("File {$pdfFilename} not found.");
        }
        if (!is_readable($pdfFilename)) {
            throw new \Exception("File {$pdfFilename} could not be read.");
        }

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseFile($pdfFilename);
        $filespec = $pdfParsed->getObjectsByType('Filespec');

        $attachmentFound = false;
        $attachmentIndex = 0;
        $embeddedFileIndex = 0;
        $returnValue = null;

        try {
            foreach ($filespec as $spec) {
                $specDetails = $spec->getDetails();
                if (static::ATTACHMENT_FILEAME == $specDetails['F']) {
                    $attachmentFound = true;
                    break;
                }
                $attachmentIndex++;
            }

            if (true == $attachmentFound) {
                $embeddedFiles = $pdfParsed->getObjectsByType('EmbeddedFile');
                foreach ($embeddedFiles as $embedFile) {
                    if ($attachmentIndex == $embeddedFileIndex) {
                        $returnValue = ZugferdDocumentReader::readAndGuessFromContent($embedFile->getContent());
                        break;
                    }
                    $embeddedFileIndex++;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Unable to get Xml from PDF : ' . $e);
        }

        return $returnValue;
    }
}
