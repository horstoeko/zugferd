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
     * Tries to load a PDF file (ZUGFeRD/Factur-X) and return a ZugferdDocumentReader
     *
     * @param  string $pdfFilename
     * @return ZugferdDocumentReader
     * @throws Exception
     * @throws RuntimeException
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    public static function readAndGuessFromFile(string $pdfFilename): ZugferdDocumentReader
    {
        return ZugferdDocumentPdfReaderExt::readAndGuessFromFile($pdfFilename);
    }

    /**
     * Tries to load an attachment content from PDF and return a ZugferdDocumentReader
     *
     * @param  string $pdfContent
     * @return ZugferdDocumentReader
     * @throws Exception
     * @throws RuntimeException
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    public static function readAndGuessFromContent(string $pdfContent): ZugferdDocumentReader
    {
        return ZugferdDocumentPdfReaderExt::readAndGuessFromContent($pdfContent);
    }

    /**
     * Returns a XML content from a PDF file
     *
     * @param  string $pdfFilename
     * @return string
     * @throws Exception
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdNoPdfAttachmentFoundException
     */
    public static function getXmlFromFile(string $pdfFilename): string
    {
        return ZugferdDocumentPdfReaderExt::getInvoiceDocumentContentFromFile($pdfFilename);
    }

    /**
     * Returns a XML content from a PDF binary stream (string)
     *
     * @param  string $pdfContent
     * @return string
     * @throws Exception
     * @throws ZugferdNoPdfAttachmentFoundException
     */
    public static function getXmlFromContent(string $pdfContent): string
    {
        return ZugferdDocumentPdfReaderExt::getInvoiceDocumentContentFromContent($pdfContent);
    }
}
