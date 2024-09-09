<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

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
    public const ATTACHMENT_FILENAMES = ['ZUGFeRD-invoice.xml'/*1.0*/, 'zugferd-invoice.xml'/*2.0*/, 'factur-x.xml'/*2.1*/, 'xrechnung.xml'];

    /**
     * Load a PDF file (ZUGFeRD/Factur-X)
     *
     * @param  string $pdfFilename
     * Contains a full-qualified filename which must exist and must be readable
     * @return ZugferdDocumentReader|null
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
     * Load a PDF content (ZUGFeRD/Factur-X)
     *
     * @param  string $pdfContent
     * String Containing the binary pdf data
     * @return ZugferdDocumentReader|null
     */
    public static function readAndGuessFromContent(string $pdfContent): ?ZugferdDocumentReader
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
                        $returnValue = ZugferdDocumentReader::readAndGuessFromContent($embeddedFile->getContent());
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
