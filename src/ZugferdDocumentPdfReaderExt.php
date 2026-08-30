<?php

declare(strict_types=1);

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
use horstoeko\zugferd\exception\ZugferdUnknownProfileIdException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;
use horstoeko\zugferd\exception\ZugferdUnknownXmlContentException;
use JMS\Serializer\Exception\InvalidArgumentException;
use JMS\Serializer\Exception\RuntimeException;
use Smalot\PdfParser\Parser as PdfParser;

/**
 * Class representing the extended document reader for incoming PDF/A-Documents with
 * attached XML data in BASIC-, EN16931- and EXTENDED profile. The Extended PDF reader
 * reads also additinal attached documents from PDF
 *
 * @category Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentPdfReaderExt
{
    /**
     * List of filenames which are possible for an attached XML-Invoice-Document in PDF
     */
    public const ATTACHMENT_FILENAMES = [
        'ZUGFeRD-invoice.xml'/* 1.0 */,
        'zugferd-invoice.xml'/* 2.0 */,
        'factur-x.xml'/* 2.1 */,
        'xrechnung.xml',
    ];

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
     * Identifier for a XML-Invoice-Docuemnt
     */
    private const ATTACHMENT_TYPE_XMLINVOICE = 0;

    /**
     * Identifier for an additional document
     */
    private const ATTACHMENT_TYPE_ADDITIONAL = 1;

    /**
     * Array containing all the attached files found in PDF
     *
     * @var array<int, array{type: int, content: string, filename: string, mimetype: string}>
     */
    private $attachmentContentList = [];

    /**
     * (Hidden) Constructor
     */
    final protected function __construct() {}

    /**
     * Load a PDF file
     *
     * @param  string                      $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return ZugferdDocumentPdfReaderExt
     *
     * @throws Exception
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     */
    public static function fromFile(string $pdfFilename): self
    {
        if (!file_exists($pdfFilename)) {
            throw new ZugferdFileNotFoundException($pdfFilename);
        }

        $pdfContent = file_get_contents($pdfFilename);

        if (false === $pdfContent) {
            throw new ZugferdFileNotReadableException($pdfFilename);
        }

        return self::fromContent($pdfContent);
    }

    /**
     * Load a PDF content string
     *
     * @param  string                      $pdfContent Contains the raw data of a PDF
     * @return ZugferdDocumentPdfReaderExt
     *
     * @throws Exception
     */
    public static function fromContent(string $pdfContent): self
    {
        return (new self())->collectAttachmentsFromPdfContent($pdfContent);
    }

    /**
     * Load a PDF file and return a ZugferDocumentReader-Instance
     *
     * @param  string                $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return ZugferdDocumentReader
     *
     * @throws Exception
     * @throws RuntimeException
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     *
     * @see  ZugferdDocumentPdfReader::readAndGuessFromFile() For a similar purpose in another context.
     */
    public static function readAndGuessFromFile(string $pdfFilename): ZugferdDocumentReader
    {
        return self::fromFile($pdfFilename)->resolveInvoiceDocumentReader();
    }

    /**
     * Load a PDF content and return a ZugferDocumentReader-Instance
     *
     * @param  string                $pdfContent Contains the raw data of a PDF
     * @return ZugferdDocumentReader
     *
     * @throws Exception
     * @throws RuntimeException
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     *
     * @see  ZugferdDocumentPdfReader::readAndGuessFromContent() For a similar purpose in another context.
     */
    public static function readAndGuessFromContent(string $pdfContent): ZugferdDocumentReader
    {
        return self::fromContent($pdfContent)->resolveInvoiceDocumentReader();
    }

    /**
     * Returns a invoice document XML content from a PDF file
     * similar to ZugferdDocumentPdfReader::getXmlFromContent
     *
     * @param  string $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return string
     *
     * @throws Exception
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdNoPdfAttachmentFoundException
     *
     * @see  ZugferdDocumentPdfReader::getXmlFromFile() For a similar purpose in another context.
     */
    public static function getInvoiceDocumentContentFromFile(string $pdfFilename): string
    {
        return self::fromFile($pdfFilename)->resolveInvoiceDocumentContent();
    }

    /**
     * Returns a invoice document XML content from a PDF content string
     *
     * @param  string $pdfContent Contains the raw data of a PDF
     * @return string
     *
     * @throws Exception
     * @throws ZugferdNoPdfAttachmentFoundException
     *
     * @see  ZugferdDocumentPdfReader::getXmlFromContent() For a similar purpose in another context.
     */
    public static function getInvoiceDocumentContentFromContent(string $pdfContent): string
    {
        return self::fromContent($pdfContent)->resolveInvoiceDocumentContent();
    }

    /**
     * Returns all additional documents (except the invoice document) from a PDF file
     *
     * @param  string                                                                            $pdfFilename Contains a full-qualified filename which must exist and must be readable
     * @return array<int, array{type: int, content: string, filename: string, mimetype: string}>
     *
     * @throws Exception
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     */
    public static function getAdditionalDocumentContentsFromFile(string $pdfFilename): array
    {
        return self::fromFile($pdfFilename)->resolveAdditionalDocumentContents();
    }

    /**
     * Returns all additional documents (except the invoice document) from a PDF content string
     *
     * @param  string                                                                            $pdfContent Contains the raw data of a PDF
     * @return array<int, array{type: int, content: string, filename: string, mimetype: string}>
     *
     * @throws Exception
     */
    public static function getAdditionalDocumentContentsFromContent(string $pdfContent): array
    {
        return self::fromContent($pdfContent)->resolveAdditionalDocumentContents();
    }

    /**
     * Returns an instance of ZugferdDocumentReader by a valid invoice attachment
     *
     * @return ZugferdDocumentReader
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdNoPdfAttachmentFoundException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
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
     *
     * @throws ZugferdNoPdfAttachmentFoundException
     */
    public function resolveInvoiceDocumentContent(): string
    {
        $invoiceContent
            = array_values(
                array_filter(
                    $this->attachmentContentList,
                    static function ($attachmentContentItem) {
                        return ZugferdDocumentPdfReaderExt::ATTACHMENT_TYPE_XMLINVOICE === $attachmentContentItem[ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE];
                    }
                )
            );

        if ([] === $invoiceContent) {
            throw new ZugferdNoPdfAttachmentFoundException();
        }

        return $invoiceContent[0][self::ATTACHMENT_KEY_CONTENT];
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
                    static function ($attachmentContentItem) {
                        return ZugferdDocumentPdfReaderExt::ATTACHMENT_TYPE_ADDITIONAL === $attachmentContentItem[ZugferdDocumentPdfReaderExt::ATTACHMENT_KEY_TYPE];
                    }
                )
            );
    }

    /**
     * Get a list of all the attachments.
     *
     * @param  string                      $pdfContent Contains the raw data of a PDF
     * @return ZugferdDocumentPdfReaderExt
     *
     * @throws Exception
     */
    protected function collectAttachmentsFromPdfContent(string $pdfContent): self
    {
        $this->attachmentContentList = [];

        $pdfParser = new PdfParser();
        $pdfParsed = $pdfParser->parseContent($pdfContent);
        $fileSpecs = $pdfParsed->getObjectsByType('Filespec');

        $fileSpecs = array_filter(
            $fileSpecs,
            static function ($fileSpec) {
                return $fileSpec->has('F') && $fileSpec->has('EF');
            }
        );

        $fileSpecs = array_filter(
            $fileSpecs,
            static function ($fileSpec) {
                return $fileSpec->get('EF')->has('F');
            }
        );

        foreach ($fileSpecs as $fileSpec) {
            $this->attachmentContentList[] = [
                self::ATTACHMENT_KEY_TYPE => in_array($fileSpec->get('F')->getContent(), self::ATTACHMENT_FILENAMES, true) ? self::ATTACHMENT_TYPE_XMLINVOICE : self::ATTACHMENT_TYPE_ADDITIONAL,
                self::ATTACHMENT_KEY_CONTENT => $fileSpec->get('EF')->get('F')->getContent(),
                self::ATTACHMENT_KEY_FILENAME => $fileSpec->get('F')->getContent(),
                self::ATTACHMENT_KEY_MIMETYPE => $fileSpec->get('EF')->get('F')->has('Subtype') ? (string) ($fileSpec->get('EF')->get('F')->get('Subtype')->getContent()) : '',
            ];
        }

        return $this;
    }
}
