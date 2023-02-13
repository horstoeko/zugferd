<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use \horstoeko\zugferd\codelists\ZugferdInvoiceType;
use \horstoeko\zugferd\ZugferdPackageVersion;
use \horstoeko\zugferd\ZugferdPdfWriter;
use \setasign\Fpdi\PdfParser\StreamReader as PdfStreamReader;
use \horstoeko\stringmanagement\PathUtils;
use \horstoeko\zugferd\ZugferdSettings;

/**
 * Class representing the facillity adding XML data from ZugferdDocumentBuilder
 * to an existing PDF with conversion to PDF/A
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentPdfBuilder
{
    /**
     * Internal reference to the xml builder instance
     *
     * @var ZugferdDocumentBuilder
     */
    private $documentBuiler = null;

    /**
     * Instance of the pdfwriter
     *
     * @var ZugferdPdfWriter
     */
    private $pdfWriter = null;

    /**
     * Contains the data of the original PDF documjent
     *
     * @var string
     */
    private $pdfData = "";

    /**
     * Contains the XML data DOMDocument instance
     *
     * @var \DOMDocument
     */
    private $xmlData = null;

    /**
     * Constructor
     *
     * @param ZugferdDocumentBuilder $documentBuiler
     * The instance of the document builder. Needed to get the XML data
     * @param string $pdfData
     * The full filename or a string containing the binary pdf data. This
     * is the original PDF (e.g. created by a ERP system)
     */
    public function __construct(ZugferdDocumentBuilder $documentBuiler, string $pdfData)
    {
        $this->documentBuiler = $documentBuiler;
        $this->pdfData = $pdfData;
        $this->pdfWriter = new ZugferdPdfWriter();
        $this->xmlData = new \DOMDocument();
        $this->xmlData->loadXML($this->documentBuiler->getContent());
    }

    /**
     * Generates the final document
     *
     * @return ZugferdDocumentPdfBuilder
     */
    public function generateDocument(): ZugferdDocumentPdfBuilder
    {
        $this->startCreatePdf();

        return $this;
    }

    /**
     * Saves the document generated with generateDocument to a file
     *
     * @param string $toFilename
     * The full qualified filename to which the generated PDF (with attachment)
     * is stored
     * @return ZugferdDocumentPdfBuilder
     */
    public function saveDocument(string $toFilename): ZugferdDocumentPdfBuilder
    {
        $this->pdfWriter->Output($toFilename, 'F');

        return $this;
    }

    /**
     * Internal function which sets up the PDF
     *
     * @return void
     */
    private function startCreatePdf(): void
    {
        // Get PDF data

        $pdfDataRef = null;

        if (@is_file($this->pdfData)) {
            $pdfDataRef = $this->pdfData;
        } elseif (is_string($this->pdfData)) {
            $pdfDataRef = PdfStreamReader::createByString($this->pdfData);
        }

        // Get XML data from Builder

        $xmlDataRef = PdfStreamReader::createByString($this->xmlData->saveXML());

        // Get profile definition for later use

        $profileDef = $this->documentBuiler->profileDefinition;

        // Start

        $this->pdfWriter->attach($xmlDataRef, $profileDef['attachmentfilename'], 'Factur-X Invoice', 'Data', 'text#2Fxml');
        $this->pdfWriter->openAttachmentPane();

        // Copy pages from the original PDF

        $pageCount = $this->pdfWriter->setSourceFile($pdfDataRef);

        for ($pageNumber = 1; $pageNumber <= $pageCount; ++$pageNumber) {
            $pageContent = $this->pdfWriter->importPage($pageNumber, '/MediaBox');
            $this->pdfWriter->AddPage();
            $this->pdfWriter->useTemplate($pageContent);
        }

        // Set PDF version 1.7 according to PDF/A-3 ISO 32000-1

        $this->pdfWriter->setPdfVersion('1.7', true);

        // Update meta data (e.g. such as author, producer, title)

        $this->updatePdfMetaData();
    }

    /**
     * Update PDF metadata to according to FacturX/ZUGFeRD XML data.
     *
     * @return void
     */
    private function updatePdfMetadata(): void
    {
        $pdfMetadataInfos = $this->preparePdfMetadata();
        $this->pdfWriter->setPdfMetadataInfos($pdfMetadataInfos);

        $xmp = simplexml_load_file(PathUtils::combinePathWithFile(ZugferdSettings::getAssetDirectory(), 'facturx_extension_schema.xmp'));
        $descriptionNodes = $xmp->xpath('rdf:Description');

        $descFx = $descriptionNodes[0];
        $descFx->children('fx', true)->{'ConformanceLevel'} = strtoupper($this->documentBuiler->profileDefinition["xmpname"]);
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
        $xmpNodes->{'CreatorTool'} = sprintf('Factur-X PHP library v%s by HorstOeko', ZugferdPackageVersion::getInstalledVersion());
        $xmpNodes->{'CreateDate'} = $pdfMetadataInfos['createdDate'];
        $xmpNodes->{'ModifyDate'} = $pdfMetadataInfos['modifiedDate'];
        $this->pdfWriter->addMetadataDescriptionNode($descXmp->asXML());
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
        $title = sprintf('%s : %s %s', $invoiceInformations['seller'], $invoiceInformations['docTypeName'], $invoiceInformations['invoiceId']);
        $subject = sprintf('FacturX/ZUGFeRD %s %s dated %s issued by %s', $invoiceInformations['docTypeName'], $invoiceInformations['invoiceId'], $dateString, $invoiceInformations['seller']);
        $pdf_metadata = array(
            'author' => $invoiceInformations['seller'],
            'keywords' => sprintf('%s, FacturX/ZUGFeRD', $invoiceInformations['docTypeName']),
            'title' => $title,
            'subject' => $subject,
            'createdDate' => $invoiceInformations['date'],
            'modifiedDate' => date('Y-m-d\TH:i:s') . '+00:00',
        );

        return $pdf_metadata;
    }

    /**
     * Extract major invoice information from FacturX/ZUGFeRD XML.
     *
     * @return array
     */
    protected function extractInvoiceInformations(): array
    {
        $xpath = new \DOMXpath($this->xmlData);
        $dateXpath = $xpath->query('//rsm:ExchangedDocument/ram:IssueDateTime/udt:DateTimeString');
        $date = $dateXpath->item(0)->nodeValue;
        $dateReformatted = date('Y-m-d\TH:i:s', strtotime($date)) . '+00:00';
        $invoiceIdXpath = $xpath->query('//rsm:ExchangedDocument/ram:ID');
        $invoiceId = $invoiceIdXpath->item(0)->nodeValue;
        $sellerXpath = $xpath->query('//ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:Name');
        $seller = $sellerXpath->item(0)->nodeValue;
        $docTypeXpath = $xpath->query('//rsm:ExchangedDocument/ram:TypeCode');
        $docType = $docTypeXpath->item(0)->nodeValue;

        switch ($docType) {
            case ZugferdInvoiceType::CREDITNOTE:
                $docTypeName = 'Credit Note';
                break;
            default:
                $docTypeName = 'Invoice';
                break;
        }

        $base_info = array(
            'invoiceId' => $invoiceId,
            'docTypeName' => $docTypeName,
            'seller' => $seller,
            'date' => $dateReformatted,
        );

        return $base_info;
    }
}
