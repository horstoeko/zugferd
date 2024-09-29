<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use Exception;
use Smalot\PdfParser\Parser as PdfParser;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdFileNotReadableException;

/**
 * Class representing the document reader for incoming PDF/A-Documents with
 * attached XML data in BASIC-, EN16931- and EXTENDED profile
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentPdfReader
{
    /**
     * List of filenames which are possible in PDF
     */
    public const ATTACHMENT_FILENAMES = [
        'ZUGFeRD-invoice.xml'/*1.0*/,
        'zugferd-invoice.xml'/*2.0*/,
        'factur-x.xml'/*2.1*/,
        'xrechnung.xml'
    ];

    /**
     * Load a PDF file (ZUGFeRD/Factur-X)
     *
     * @param  string $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return ZugferdDocumentReader|null
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws Exception
     */
    public static function readAndGuessFromFile(string $pdfFilename): ?ZugferdDocumentReader
    {
        if (!file_exists($pdfFilename)) {
            throw new ZugferdFileNotFoundException($pdfFilename);
        }

        $pdfContent = file_get_contents($pdfFilename);

        if ($pdfContent === false) {
            throw new ZugferdFileNotReadableException($pdfFilename);
        }

        return static::readAndGuessFromContent($pdfContent);
    }

    /**
     * Tries to load an attachment content from PDF and return a ZugferdDocumentReader
     * If any erros occured or no attachments were found null is returned
     *
     * @param  string $pdfContent String Containing the binary pdf data
     * @return ZugferdDocumentReader|null
     * @throws Exception
     */
    public static function readAndGuessFromContent(string $pdfContent): ?ZugferdDocumentReader
    {
        $xmlContent = static::internalExtractXMLFromPdfContent($pdfContent);

        if (is_null($xmlContent)) {
            return null;
        }

        try {
            return ZugferdDocumentReader::readAndGuessFromContent($xmlContent);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Returns a XML content from a PDF file
     *
     * @param  string $pdfFilename
     * Contains a full-qualified filename which must exist and must be readable
     * @return string|null
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws Exception
     */
    public static function getXmlFromFile(string $pdfFilename): ?string
    {
        if (!file_exists($pdfFilename)) {
            throw new ZugferdFileNotFoundException($pdfFilename);
        }

        $pdfContent = file_get_contents($pdfFilename);

        if ($pdfContent === false) {
            throw new ZugferdFileNotReadableException($pdfFilename);
        }

        return static::getXmlFromContent($pdfContent);
    }

    /**
     * Returns a XML content from a PDF binary stream (string)
     *
     * @param  string $pdfContent String Containing the binary pdf data
     * @return string|null
     * @throws Exception
     */
    public static function getXmlFromContent(string $pdfContent): ?string
    {
        return static::internalExtractXMLFromPdfContent($pdfContent);
    }

    /**
     * Get the attachment content from XML.
     * See the allowed filenames which are supported
     *
     * @param  string $pdfContent
     * @return null|string
     * @throws Exception
     */
    private static function internalExtractXMLFromPdfContent(string $pdfContent): ?string
    {
        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseContent($pdfContent);
        $filespecs = $pdfParsed->getObjectsByType('Filespec');

        $attachmentFound = false;
        $attachmentIndex = 0;
        $embeddedFileIndex = 0;
        $returnValue = null;

        try {
            foreach ($filespecs as $filespec) {
                $filespecDetails = $filespec->getDetails();
                if (in_array($filespecDetails['F'], static::ATTACHMENT_FILENAMES)) {
                    $attachmentFound = true;
                    break;
                }
                $attachmentIndex++;
            }

            if (true == $attachmentFound) {
                /**
                 * @var array<\Smalot\PdfParser\PDFObject>
                 */
                $embeddedFiles = $pdfParsed->getObjectsByType('EmbeddedFile');
                foreach ($embeddedFiles as $embeddedFile) {
                    if ($attachmentIndex == $embeddedFileIndex) {
                        $returnValue = $embeddedFile->getContent();
                        break;
                    }
                    $embeddedFileIndex++;
                }
            }
        } catch (\Exception $e) {
            $returnValue = null;
        }

        return $returnValue;
    }
}
