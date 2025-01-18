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
 * Class representing the extended document reader for incoming PDF/A-Documents with
 * attached XML data in BASIC-, EN16931- and EXTENDED profile. The Extended PDF reader
 * reads also additinal attached documents from PDF
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentPdfReaderExt
{
    /**
     * List of filenames which are possible for an attached XML-Invoice-Document in PDF
     */
    public const ATTACHMENT_FILENAMES = [
        'ZUGFeRD-invoice.xml'/*1.0*/,
        'zugferd-invoice.xml'/*2.0*/,
        'factur-x.xml'/*2.1*/,
        'xrechnung.xml'
    ];

    /**
     * Identifier for a XML-Invoice-Docuemnt
     */
    private const ATTACHMENT_TYPE_XMLINVOICE = 0;

    /**
     * Identifier for an additional document
     */
    private const ATTACHMENT_TYPE_ADDITIONAL = 1;

    /**
     * Key of the type element in the internal attachment list
     */
    public const ATTACHMENT_KEY_TYPE = 'type';

    /**
     * Key of the content element in the internal attachment list
     */
    public const ATTACHMENT_KEY_CONTENT = 'content';

    /**
     * Key of the filename element in the internal attachment list
     */
    public const ATTACHMENT_KEY_FILENAME = 'filename';

    /**
     * Key of the filename element in the internal attachment list
     */
    public const ATTACHMENT_KEY_MIMETYPE = 'mimetype';

    /**
     * Array containing all the attached files found in PDF
     *
     * @var array<int, array{type: int, content: string, filename: string, mimetype: string}>
     */
    private $attachmentContentList = [];

    /**
     * (Hidden) Constructor
     */
    final protected function __construct()
    {
    }

    /**
     * Load a PDF file
     *
     * @param  string $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return ZugferdDocumentPdfReaderExt
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws Exception
     */
    public static function fromFile(string $pdfFilename): ZugferdDocumentPdfReaderExt
    {
        if (!file_exists($pdfFilename)) {
            throw new ZugferdFileNotFoundException($pdfFilename);
        }

        $pdfContent = file_get_contents($pdfFilename);

        if ($pdfContent === false) {
            throw new ZugferdFileNotReadableException($pdfFilename);
        }

        return static::fromContent($pdfContent);
    }

    /**
     * Load a PDF content string
     *
     * @param  string $pdfContent Contains the raw data of a PDF
     * @return ZugferdDocumentPdfReaderExt
     * @throws Exception
     */
    public static function fromContent(string $pdfContent): ZugferdDocumentPdfReaderExt
    {
        return (new ZugferdDocumentPdfReaderExt())->collectAttachmentsFromPdfContent($pdfContent);
    }

    /**
     * Load a PDF file and return a ZugferDocumentReader-Instance
     *
     * @param  string $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @throws Exception
     * @throws RuntimeException
     * @return ZugferdDocumentReader
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     * @see    \horstoeko\zugferd\ZugferdDocumentPdfReader::readAndGuessFromFile() For a similar purpose in another context.
     */
    public static function readAndGuessFromFile(string $pdfFilename): ZugferdDocumentReader
    {
        return static::fromFile($pdfFilename)->resolveInvoiceDocumentReader();
    }

    /**
     * Load a PDF content and return a ZugferDocumentReader-Instance
     *
     * @param  string $pdfContent Contains the raw data of a PDF
     * @throws Exception
     * @throws RuntimeException
     * @return ZugferdDocumentReader
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @see    \horstoeko\zugferd\ZugferdDocumentPdfReader::readAndGuessFromContent() For a similar purpose in another context.
     */
    public static function readAndGuessFromContent(string $pdfContent): ZugferdDocumentReader
    {
        return static::fromContent($pdfContent)->resolveInvoiceDocumentReader();
    }

    /**
     * Returns a invoice document XML content from a PDF file
     * similar to ZugferdDocumentPdfReader::getXmlFromContent
     *
     * @param  string $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return string
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws Exception
     * @throws ZugferdNoPdfAttachmentFoundException
     * @see    \horstoeko\zugferd\ZugferdDocumentPdfReader::getXmlFromFile() For a similar purpose in another context.
     */
    public static function getInvoiceDocumentContentFromFile(string $pdfFilename): string
    {
        return static::fromFile($pdfFilename)->resolveInvoiceDocumentContent();
    }

    /**
     * Returns a invoice document XML content from a PDF content string
     *
     * @param  string $pdfContent Contains the raw data of a PDF
     * @return string
     * @throws Exception
     * @throws ZugferdNoPdfAttachmentFoundException
     * @see    \horstoeko\zugferd\ZugferdDocumentPdfReader::getXmlFromContent() For a similar purpose in another context.
     */
    public static function getInvoiceDocumentContentFromContent(string $pdfContent): string
    {
        return static::fromContent($pdfContent)->resolveInvoiceDocumentContent();
    }

    /**
     * Returns all additional documents (except the invoice document) from a PDF file
     *
     * @param  string $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return array<int, array{type: int, content: string, filename: string, mimetype: string}>
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws Exception
     */
    public static function getAdditionalDocumentContentsFromFile(string $pdfFilename): array
    {
        return static::fromFile($pdfFilename)->resolveAdditionalDocumentContents();
    }

    /**
     * Returns all additional documents (except the invoice document) from a PDF content string
     *
     * @param  string $pdfContent Contains the raw data of a PDF
     * @return array<int, array{type: int, content: string, filename: string, mimetype: string}>
     * @throws Exception
     */
    public static function getAdditionalDocumentContentsFromContent(string $pdfContent): array
    {
        return static::fromContent($pdfContent)->resolveAdditionalDocumentContents();
    }

    /**
     * Returns an instance of ZugferdDocumentReader by a valid invoice attachment
     *
     * @return ZugferdDocumentReader
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws RuntimeException
     */
    public function resolveInvoiceDocumentReader(): ZugferdDocumentReader
    {
        return ZugferdDocumentReader::readAndGuessFromContent($this->resolveInvoiceDocumentContent());
    }

    /**
     * Returns the content as string if a valid invoice attachment was found, otherwise
     * an exception will be raised
     *
     * @return string
     * @throws ZugferdNoPdfAttachmentFoundException
     */
    public function resolveInvoiceDocumentContent(): string
    {
        $invoiceContent =
            array_values(
                array_filter(
                    $this->attachmentContentList,
                    function ($attachmentContentItem) {
                        return $attachmentContentItem[ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE] === ZugferdDocumentPdfReaderExt::ATTACHMENT_TYPE_XMLINVOICE;
                    }
                )
            );

        if ($invoiceContent === []) {
            throw new ZugferdNoPdfAttachmentFoundException();
        }

        return $invoiceContent[0][ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_CONTENT];
    }

    /**
     * Returns a list of all additional attached documents except the invoice document
     *
     * @return array<int, array{type: int, content: string, filename: string, mimetype: string}>
     */
    public function resolveAdditionalDocumentContents(): array
    {
        return
            array_values(
                array_filter(
                    $this->attachmentContentList,
                    function ($attachmentContentItem) {
                        return $attachmentContentItem[ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE] === ZugferdDocumentPdfReaderExt::ATTACHMENT_TYPE_ADDITIONAL;
                    }
                )
            );
    }

    /**
     * Get a list of all the attachments.
     *
     * @param  string $pdfContent Contains the raw data of a PDF
     * @return ZugferdDocumentPdfReaderExt
     * @throws Exception
     */
    protected function collectAttachmentsFromPdfContent(string $pdfContent): ZugferdDocumentPdfReaderExt
    {
        $this->attachmentContentList = [];

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseContent($pdfContent);
        $fileSpecs = $pdfParsed->getObjectsByType('Filespec');

        $fileSpecs = array_filter(
            $fileSpecs,
            function ($fileSpec) {
                return $fileSpec->has('F') && $fileSpec->has('EF');
            }
        );

        $fileSpecs = array_filter(
            $fileSpecs,
            function ($fileSpec) {
                return $fileSpec->get('EF')->has('F');
            }
        );

        foreach ($fileSpecs as $fileSpec) {
            $this->attachmentContentList[] = [
                ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE => in_array($fileSpec->get('F')->getContent(), ZugferdDocumentPdfReaderExt::ATTACHMENT_FILENAMES) ? ZugferdDocumentPdfReaderExt::ATTACHMENT_TYPE_XMLINVOICE : ZugferdDocumentPdfReaderExt::ATTACHMENT_TYPE_ADDITIONAL,
                ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_CONTENT => $fileSpec->get('EF')->get('F')->getContent(),
                ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_FILENAME => $fileSpec->get('F')->getContent(),
                ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_MIMETYPE => $fileSpec->get('EF')->get('F')->has('Subtype') ? (string)($fileSpec->get('EF')->get('F')->get('Subtype')->getContent()) : "",
            ];
        }

        return $this;
    }
}
