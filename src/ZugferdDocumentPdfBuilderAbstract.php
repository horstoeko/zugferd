<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use DateTime;
use DOMDocument;
use DOMXpath;
use Throwable;
use horstoeko\mimedb\MimeDb;
use horstoeko\stringmanagement\FileUtils;
use horstoeko\stringmanagement\StringUtils;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdFileNotReadableException;
use horstoeko\zugferd\exception\ZugferdUnknownMimetype;
use horstoeko\zugferd\exception\ZugferdInvalidArgumentException;
use horstoeko\zugferd\ZugferdPackageVersion;
use horstoeko\zugferd\ZugferdPdfWriter;
use horstoeko\zugferd\ZugferdSettings;
use setasign\Fpdi\PdfParser\StreamReader as PdfStreamReader;

/**
 * Class representing the base facillity adding XML data
 * to an existing PDF with conversion to PDF/A
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
abstract class ZugferdDocumentPdfBuilderAbstract
{
    /**
     * Constants for Relationship types
     * 'Data', 'Alternative', 'Source', 'Supplement', 'Unspecified'
     */
    public const AF_RELATIONSHIP_DATA = "Data";

    public const AF_RELATIONSHIP_ALTERNATIVE = "Alternative";

    public const AF_RELATIONSHIP_SOURCE = "Source";

    public const AF_RELATIONSHIP_SUPPLEMENT = "Supplement";

    public const AF_RELATIONSHIP_UNSPECIFIED = "Unspecified";

    /**
     * Additional creator tool (e.g. the ERP software that called the PHP library)
     *
     * @var string
     */
    private $additionalCreatorTool = "";

    /**
     * The relationship type to use for the XML attachment. Detault is Data
     *
     * @var string
     */
    private $attachmentRelationshipType = 'Data';

    /**
     * Instance of the pdfwriter
     *
     * @var ZugferdPdfWriter
     */
    private $pdfWriter;

    /**
     * Contains the data of the original PDF document
     *
     * @var string
     */
    private $pdfData = "";

    /**
     * List of files which should be additionally attached to PDF
     *
     * @var array
     */
    private $additionalFilesToAttach = [];

    /**
     * User-defined template for the author-metainformation
     *
     * @var string
     */
    private $authorTemplate = "";

    /**
     * User-defined template for the keyword-metainformation
     *
     * @var string
     */
    private $keywordTemplate = "";

    /**
     * User-defined template for the title-metainformation
     *
     * @var string
     */
    private $titleTemplate = "";

    /**
     * User-defined template for the subject-metainformation
     *
     * @var string
     */
    private $subjectTemplate = "";

    /**
     * User-defined callback function for all metainformation
     *
     * @var callable|null
     */
    private $metaInformationCallback;

    /**
     * Internal flag which indicate, that attachment pane should be opened
     *
     * @var boolean
     */
    private $attachmentPaneVisibility = true;

    /**
     * Constructor
     *
     * @param string $pdfData
     * The full filename or a string containing the binary pdf data. This
     * is the original PDF (e.g. created by a ERP system)
     */
    public function __construct(string $pdfData)
    {
        $this->pdfData = $pdfData;
        $this->pdfWriter = new ZugferdPdfWriter();
    }

    /**
     * Generates the final document
     *
     * @return static
     */
    public function generateDocument()
    {
        $this->startCreatePdf();

        return $this;
    }

    /**
     * Saves the generated PDF document to a file
     *
     * @param  string $toFilename The full qualified filename to which the generated PDF (with attachment)is stored
     * @return static
     */
    public function saveDocument(string $toFilename)
    {
        $this->pdfWriter->Output('F', $toFilename);

        return $this;
    }

    /**
     * Starts a HTTP download of the generated PDF document
     *
     * @param  string $toFilename
     * @return string
     */
    public function saveDocumentInline(string $toFilename): string
    {
        return $this->pdfWriter->Output('I', $toFilename);
    }

    /**
     * Returns the content of the generared PDF as a string
     *
     * @return string
     */
    public function downloadString(): string
    {
        return $this->pdfWriter->Output('S');
    }

    /**
     * Sets an additional creator tool (e.g. the ERP software that called the PHP library)
     *
     * @param  string $additionalCreatorTool The name of the creator
     * @return static
     */
    public function setAdditionalCreatorTool(string $additionalCreatorTool)
    {
        $this->additionalCreatorTool = $additionalCreatorTool;

        return $this;
    }

    /**
     * Returns the creator tool name (the PHP library, and if given also the additional creator tool)
     *
     * @return string
     */
    public function getCreatorToolName(): string
    {
        $toolName = sprintf('Factur-X PHP library v%s by HorstOeko', ZugferdPackageVersion::getInstalledVersion());

        if ($this->additionalCreatorTool) {
            return $this->additionalCreatorTool . ' / ' . $toolName;
        }

        return $toolName;
    }

    /**
     * Set the type of relationship for the XML attachment. Allowed
     * types are 'Data', 'Alternative' and 'Source'
     *
     * @param  string $relationshipType Type of relationship
     * @return static
     */
    public function setAttachmentRelationshipType(string $relationshipType)
    {
        if (!in_array($relationshipType, [static::AF_RELATIONSHIP_DATA, static::AF_RELATIONSHIP_ALTERNATIVE, static::AF_RELATIONSHIP_SOURCE])) {
            $relationshipType = static::AF_RELATIONSHIP_DATA;
        }

        $this->attachmentRelationshipType = $relationshipType;

        return $this;
    }

    /**
     * Returns the relationship type for the XML attachment. This
     * can return 'Data', 'Alternative'
     *
     * @return string
     */
    public function getAttachmentRelationshipType(): string
    {
        return $this->attachmentRelationshipType;
    }

    /**
     * Set the type of relationship for the XML attachment to "Data"
     *
     * @return static
     */
    public function setAttachmentRelationshipTypeToData()
    {
        return $this->setAttachmentRelationshipType(static::AF_RELATIONSHIP_DATA);
    }

    /**
     * Set the type of relationship for the XML attachment to "Alternative"
     *
     * @return static
     */
    public function setAttachmentRelationshipTypeToAlternative()
    {
        return $this->setAttachmentRelationshipType(static::AF_RELATIONSHIP_ALTERNATIVE);
    }

    /**
     * Set the type of relationship for the XML attachment to "Source"
     *
     * @return static
     */
    public function setAttachmentRelationshipTypeToSource()
    {
        return $this->setAttachmentRelationshipType(static::AF_RELATIONSHIP_SOURCE);
    }

    /**
     * Attach an additional file to PDF. The file that is specified in $fullFilename
     * must exists
     *
     * @param  string $fullFilename
     * @param  string $displayName
     * @param  string $relationshipType
     * @return static
     * @throws ZugferdInvalidArgumentException
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownMimetype
     */
    public function attachAdditionalFileByRealFile(string $fullFilename, string $displayName = "", string $relationshipType = "")
    {
        // Checks that the file really exists

        if ($fullFilename === '') {
            throw new ZugferdInvalidArgumentException("You must specify a filename for the content to attach");
        }

        if (!file_exists($fullFilename)) {
            throw new ZugferdFileNotFoundException($fullFilename);
        }

        // Load content

        $content = file_get_contents($fullFilename);

        if ($content === false) {
            throw new ZugferdFileNotReadableException($fullFilename);
        }

        // Add attachment

        $this->attachAdditionalFileByContent(
            $content,
            $fullFilename,
            $displayName,
            $relationshipType,
        );

        return $this;
    }

    /**
     * Attach an additional file to PDF by a content string
     *
     * @param  string $content
     * @param  string $filename
     * @param  string $displayName
     * @param  string $relationshipType
     * @return static
     * @throws ZugferdInvalidArgumentException
     * @throws ZugferdUnknownMimetype
     */
    public function attachAdditionalFileByContent(string $content, string $filename, string $displayName = "", string $relationshipType = "")
    {
        // Check content. The content must not be empty

        if ($content === '') {
            throw new ZugferdInvalidArgumentException("You must specify a content to attach");
        }

        // Check filename. The filename must not be empty

        if ($filename === '') {
            throw new ZugferdInvalidArgumentException("You must specify a filename for the content to attach");
        }

        // Mimetype for the file must exist

        $mimeType = (new MimeDb())->findFirstMimeTypeByExtension(FileUtils::getFileExtension($filename));

        if (is_null($mimeType)) {
            throw new ZugferdUnknownMimetype();
        }

        // Sanatize relationship type

        if ($relationshipType === '') {
            $relationshipType = static::AF_RELATIONSHIP_SUPPLEMENT;
        }

        if (!in_array($relationshipType, [static::AF_RELATIONSHIP_DATA, static::AF_RELATIONSHIP_ALTERNATIVE, static::AF_RELATIONSHIP_SOURCE, static::AF_RELATIONSHIP_SUPPLEMENT, static::AF_RELATIONSHIP_UNSPECIFIED])) {
            $relationshipType = static::AF_RELATIONSHIP_SUPPLEMENT;
        }

        // Sanatize displayname

        if ($displayName === '') {
            $displayName = FileUtils::getFilenameWithExtension($filename);
        }

        // Add to attachment list

        $this->additionalFilesToAttach[] = [
            PdfStreamReader::createByString($content),
            FileUtils::getFilenameWithExtension($filename),
            $displayName,
            $relationshipType,
            str_replace('/', '#2F', $mimeType)
        ];

        return $this;
    }

    /**
     * Set the the deterministic mode. This mode should only be used
     * for testing purposes
     *
     * @param  bool $deterministicModeEnabled
     * @return static
     */
    public function setDeterministicModeEnabled(bool $deterministicModeEnabled)
    {
        $this->pdfWriter->setDeterministicModeEnabled($deterministicModeEnabled);

        return $this;
    }

    /**
     * Set the template for the author meta information
     *
     * @param  string $authorTemplate
     * @return static
     */
    public function setAuthorTemplate(string $authorTemplate)
    {
        $this->authorTemplate = $authorTemplate;

        return $this;
    }

    /**
     * Set the template for the keyword meta information
     *
     * @param  string $keywordTemplate
     * @return static
     */
    public function setKeywordTemplate(string $keywordTemplate)
    {
        $this->keywordTemplate = $keywordTemplate;

        return $this;
    }

    /**
     * Set the template for the title meta information
     *
     * @param  string $titleTemplate
     * @return static
     */
    public function setTitleTemplate(string $titleTemplate)
    {
        $this->titleTemplate = $titleTemplate;

        return $this;
    }

    /**
     * Set the template for the subject meta information
     *
     * @param  string $subjectTemplate
     * @return static
     */
    public function setSubjectTemplate(string $subjectTemplate)
    {
        $this->subjectTemplate = $subjectTemplate;

        return $this;
    }

    /**
     * Set the user defined callback for generating custom meta information
     *
     * @param  callable|null $callback
     * @return static
     */
    public function setMetaInformationCallback(?callable $callback = null)
    {
        $this->metaInformationCallback = is_callable($callback) ? $callback : null;

        return $this;
    }

    /**
     * Sets the flag that indicates, that the attachment pane should be visible on start (True)
     * or hidden (False)
     *
     * @param boolean $attachmentPaneVisibility Flag that indicates, that the attachment pane should be visible or hidden
     * @return static
     */
    public function setAttachmentPaneVisibility(bool $attachmentPaneVisibility)
    {
        $this->attachmentPaneVisibility = $attachmentPaneVisibility;

        return $this;
    }

    /**
     * Returns true if the attachment pane is visible, otherwise false
     *
     * @return boolean
     */
    public function getAttachmentPaneIsVisible(): bool
    {
        return $this->attachmentPaneVisibility;
    }

    /**
     * Show attachment pane on startup
     *
     * @return static
     */
    public function showAttachmentPane()
    {
        $this->setAttachmentPaneVisibility(true);

        return $this;
    }

    /**
     * Hide attachment pane on startup
     *
     * @return static
     */
    public function hideAttachmentPane()
    {
        $this->setAttachmentPaneVisibility(false);

        return $this;
    }

    /**
     * Get the content of XML to attach
     *
     * @return string
     */
    abstract protected function getXmlContent(): string;

    /**
     * Get the filename of the XML to attach
     *
     * @return string
     */
    abstract protected function getXmlAttachmentFilename(): string;

    /**
     * Get the XMP name for the XML to attach
     *
     * @return string
     */
    abstract protected function getXmlAttachmentXmpName(): string;

    /**
     * Get the XMP version for the XML to attach
     *
     * @return string
     */
    abstract protected function getXmlAttachmentXmpVersion(): string;

    /**
     * Internal function which sets up the PDF
     *
     * @return void
     */
    private function startCreatePdf(): void
    {
        // Get PDF data

        $pdfDataRef = null;

        if ($this->isFile($this->pdfData)) {
            $pdfDataRef = $this->pdfData;
        } elseif (is_string($this->pdfData)) {
            $pdfDataRef = PdfStreamReader::createByString($this->pdfData);
        }

        // Get XML data from Builder

        $documentBuilderXmlDataRef = PdfStreamReader::createByString($this->getXmlContent());

        // Start

        $this->pdfWriter->attach(
            $documentBuilderXmlDataRef,
            $this->getXmlAttachmentFilename(),
            'Factur-X Invoice',
            $this->getAttachmentRelationshipType(),
            'text#2Fxml'
        );

        // Add additional attachments

        foreach ($this->additionalFilesToAttach as $fileToAttach) {
            $this->pdfWriter->attach(
                $fileToAttach[0],
                $fileToAttach[1],
                $fileToAttach[2],
                $fileToAttach[3],
                $fileToAttach[4],
            );
        }

        // Set flag to always show the attachment pane

        if ($this->getAttachmentPaneIsVisible() === true) {
            $this->pdfWriter->openAttachmentPane();
        }

        // Copy pages from the original PDF

        $pageCount = $this->pdfWriter->setSourceFile($pdfDataRef);

        for ($pageNumber = 1; $pageNumber <= $pageCount; ++$pageNumber) {
            $pageContent = $this->pdfWriter->importPage($pageNumber, '/MediaBox', true, true);
            $this->pdfWriter->AddPage();
            $this->pdfWriter->useTemplate($pageContent, 0, 0, null, null, true);
        }

        // Set PDF version 1.7 according to PDF/A-3 ISO 32000-1

        $this->pdfWriter->setPdfVersion('1.7', true);

        // Update meta data (e.g. such as author, producer, title)

        $this->updatePdfMetadata();
    }

    /**
     * Update PDF metadata to according to FacturX/ZUGFeRD XML data.
     *
     * @return void
     */
    private function updatePdfMetadata(): void
    {
        $pdfCreatorToolInfos = $this->getCreatorToolName();

        $pdfMetadataInfos = $this->preparePdfMetadata();
        $this->pdfWriter->setPdfMetadataInfos($pdfMetadataInfos);

        $xmp = simplexml_load_file(ZugferdSettings::getFullXmpMetaDataFilename());
        $descriptionNodes = $xmp->xpath('rdf:Description');

        $descFx = $descriptionNodes[0];
        $descFx->children('fx', true)->{'ConformanceLevel'} = strtoupper($this->getXmlAttachmentXmpName());
        $descFx->children('fx', true)->{'Version'} = strtoupper($this->getXmlAttachmentXmpVersion());
        $descFx->children('fx', true)->{'DocumentFileName'} = $this->getXmlAttachmentFilename();
        $this->pdfWriter->addMetadataDescriptionNode($descFx->asXML());

        $this->pdfWriter->addMetadataDescriptionNode($descriptionNodes[1]->asXML());

        $descPdfAid = $descriptionNodes[2];
        $this->pdfWriter->addMetadataDescriptionNode($descPdfAid->asXML());

        $descDc = $descriptionNodes[3];
        $descNodes = $descDc->children('dc', true);
        $descNodes->title->children('rdf', true)->Alt->li = $pdfMetadataInfos['title'];
        $descNodes->creator->children('rdf', true)->Seq->li = $pdfMetadataInfos['author'];
        $descNodes->description->children('rdf', true)->Alt->li = $pdfMetadataInfos['subject'];

        $this->pdfWriter->addMetadataDescriptionNode($descDc->asXML());

        $descAdobe = $descriptionNodes[4];
        $descAdobe->children('pdf', true)->{'Producer'} = 'FPDF';
        $this->pdfWriter->addMetadataDescriptionNode($descAdobe->asXML());

        $descXmp = $descriptionNodes[5];
        $xmpNodes = $descXmp->children('xmp', true);
        $xmpNodes->{'CreatorTool'} = $pdfCreatorToolInfos;
        $xmpNodes->{'CreateDate'} = $pdfMetadataInfos['createdDate'];
        $xmpNodes->{'ModifyDate'} = $pdfMetadataInfos['modifiedDate'];

        $this->pdfWriter->addMetadataDescriptionNode($descXmp->asXML());

        $this->pdfWriter->SetAuthor($pdfMetadataInfos['author'], true);
        $this->pdfWriter->SetKeywords($pdfMetadataInfos['keywords'], true);
        $this->pdfWriter->SetTitle($pdfMetadataInfos['title'], true);
        $this->pdfWriter->SetSubject($pdfMetadataInfos['subject'], true);
        $this->pdfWriter->SetCreator($pdfCreatorToolInfos, true);
    }

    /**
     * Prepare PDF Metadata informations from FacturX/ZUGFeRD XML.
     *
     * @return array
     */
    private function preparePdfMetadata(): array
    {
        $invoiceInformations = $this->extractInvoiceInformations();

        $dateString = date('Y-m-d', strtotime($invoiceInformations['date']));

        $author = $invoiceInformations['seller'];
        $keywords = sprintf('%s, FacturX/ZUGFeRD', $invoiceInformations['docTypeName']);
        $title = sprintf('%s : %s %s', $invoiceInformations['seller'], $invoiceInformations['docTypeName'], $invoiceInformations['invoiceId']);
        $subject = sprintf('FacturX/ZUGFeRD %s %s dated %s issued by %s', $invoiceInformations['docTypeName'], $invoiceInformations['invoiceId'], $dateString, $invoiceInformations['seller']);

        return [
            'author' => $this->buildMetadataField('author', $author, $invoiceInformations),
            'keywords' => $this->buildMetadataField('keywords', $keywords, $invoiceInformations),
            'title' => $this->buildMetadataField('title', $title, $invoiceInformations),
            'subject' => $this->buildMetadataField('subject', $subject, $invoiceInformations),
            'createdDate' => $invoiceInformations['date'],
            'modifiedDate' => (new DateTime())->format('Y-m-d\TH:i:sP'),
        ];
    }

    /**
     * Extract major invoice information from FacturX/ZUGFeRD XML.
     *
     * @return array
     */
    protected function extractInvoiceInformations(): array
    {
        $domDocument = new DOMDocument();
        $domDocument->loadXML($this->getXmlContent());

        $xpath = new DOMXPath($domDocument);

        $dateXpath = $xpath->query('//rsm:ExchangedDocument/ram:IssueDateTime/udt:DateTimeString');
        $date = $dateXpath->item(0)->nodeValue;
        $dateReformatted = (new DateTime())->setTimestamp(strtotime($date))->format('Y-m-d\TH:i:sP');

        $invoiceIdXpath = $xpath->query('//rsm:ExchangedDocument/ram:ID');
        $invoiceId = $invoiceIdXpath->item(0)->nodeValue;

        $sellerXpath = $xpath->query('//ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:Name');
        $sellerName = $sellerXpath->item(0)->nodeValue;

        $docTypeXpath = $xpath->query('//rsm:ExchangedDocument/ram:TypeCode');
        $docTypeCode = $docTypeXpath->item(0)->nodeValue;

        switch ($docTypeCode) {
            case ZugferdInvoiceType::CREDITNOTE:
                $docTypeName = 'Credit Note';
                break;
            default:
                $docTypeName = 'Invoice';
                break;
        }

        return [
            'invoiceId' => $invoiceId,
            'docTypeName' => $docTypeName,
            'seller' => $sellerName,
            'date' => $dateReformatted,
        ];
    }

    /**
     * Returns true if the submittet parameter $pdfData is a valid file.
     * Otherwise it will return false
     *
     * @param  string $pdfData
     * @return boolean
     */
    protected function isFile($pdfData): bool
    {
        try {
            return @is_file($pdfData);
        } catch (Throwable $throwable) {
            return false;
        }
    }

    /**
     * Returns the parsed meta-field content
     *
     * @param  string $which
     * @param  string $default
     * @param  array  $invoiceInformation
     * @return string
     */
    private function buildMetadataField(string $which, string $default, array $invoiceInformation): string
    {
        $xmlContent = $this->getXmlContent();

        if (is_callable($this->metaInformationCallback)) {
            $callbackResult = call_user_func($this->metaInformationCallback, $which, $xmlContent, $invoiceInformation, $default);
            if (!StringUtils::stringIsNullOrEmpty($callbackResult)) {
                return $callbackResult;
            }
        }

        $templates = [
            'author' => $this->authorTemplate,
            'keywords' => $this->keywordTemplate,
            'title' => $this->titleTemplate,
            'subject' => $this->subjectTemplate,
        ];

        if (!isset($templates[$which])) {
            return $default;
        }

        if (StringUtils::stringIsNullOrEmpty($templates[$which])) {
            return $default;
        }

        return sprintf(
            $templates[$which],
            $invoiceInformation['invoiceId'],
            $invoiceInformation['docTypeName'],
            $invoiceInformation['seller'],
            $invoiceInformation['date']
        );
    }
}
