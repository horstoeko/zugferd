<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use Exception;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdFileNotReadableException;
use horstoeko\zugferd\exception\ZugferdNoPdfAttachmentFoundException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;
use horstoeko\zugferd\exception\ZugferdUnknownXmlContentException;
use JMS\Serializer\Exception\RuntimeException;
use Smalot\PdfParser\Parser as PdfParser;

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
     * @throws Exception
     * @return ZugferdDocumentReader
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws RuntimeException
     */
    public static function readAndGuessFromFile(string $pdfFilename): ZugferdDocumentReader
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
     *
     * @param  string $pdfContent String containing the binary pdf data
     * @return ZugferdDocumentReader
     * @throws Exception
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws RuntimeException
     */
    public static function readAndGuessFromContent(string $pdfContent): ZugferdDocumentReader
    {
        $xmlContent = static::internalExtractXMLFromPdfContent($pdfContent);

        return ZugferdDocumentReader::readAndGuessFromContent($xmlContent);
    }

    /**
     * Returns a XML content from a PDF file
     *
     * @param  string $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return string
     * @throws Exception
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdNoPdfAttachmentFoundException
     */
    public static function getXmlFromFile(string $pdfFilename): string
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
     * @param  string $pdfContent
     * @return string
     * @throws Exception
     * @throws ZugferdNoPdfAttachmentFoundException
     */
    public static function getXmlFromContent(string $pdfContent): string
    {
        return static::internalExtractXMLFromPdfContent($pdfContent);
    }

    /**
     * Get the attachment content from XML.
     * See the allowed filenames which are supported
     *
     * @param  string $pdfContent
     * @return string
     * @throws Exception
     * @throws ZugferdNoPdfAttachmentFoundException
     */
    protected static function internalExtractXMLFromPdfContent(string $pdfContent): string
    {
        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseContent($pdfContent);
        $filespecs = $pdfParsed->getObjectsByType('Filespec');

        $attachmentFound = false;
        $attachmentIndex = 0;
        $embeddedFileIndex = 0;

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
                    return $embeddedFile->getContent();
                }
                $embeddedFileIndex++;
            }
        }

        throw new ZugferdNoPdfAttachmentFoundException();
    }
}
