<?php

namespace horstoeko\zugferd;

use \setasign\Fpdi\PdfParser\StreamReader as PdfStreamReader;
use \horstoeko\zugferd\ZugferdPdfWriter;

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
     * @param string $pdfData
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
        // Get PDF data

        $pdfDataRef = null;

        if (@is_file($this->pdfData)) {
            $pdfDataRef = $this->pdfData;
        } elseif (is_string($this->pdfData)) {
            $pdfDataRef = PdfStreamReader::createByString($this->pdfData);
        }

        // Get XML data from Builder

        $xmlData = $this->documentBuiler->getContent();
        $xmlDataRef = PdfStreamReader::createByString($xmlData);

        // Get profile definition for later use

        $profileDef = $this->documentBuiler->profiledef;

        // Start

        $this->pdfWriter->Attach($xmlDataRef, $profileDef['attachmentfilename'], 'Factur-X Invoice', 'Data', 'text#2Fxml');
        $this->pdfWriter->OpenAttachmentPane();
        $this->pdfWriter->setSourceFile($pdfDataRef);
        $this->pdfWriter->setPdfVersion('1.7', true);

        $this->updatePdfMetaData();

        return $this;
    }

    /**
     * Saves the document generated with generateDocument to a file
     *
     * @param string $toFilename
     * @return ZugferdDocumentPdfBuilder
     */
    public function saveDocument(string $toFilename): ZugferdDocumentPdfBuilder
    {
        $this->pdfWriter->Output($toFilename, 'F');

        return $this;
    }

    /**
     * Update PDF metadata to according to Factur-X XML data.
     *
     * @return void
     */
    private function updatePdfMetadata(): void
    {
        $pdf_metadata_infos = $this->preparePdfMetadata($this->xmlData);
        $this->pdfWriter->set_pdf_metadata_infos($pdf_metadata_infos);

        $xmp = simplexml_load_file(dirname(__FILE__) . "/assets/facturx_extension_schema.xmp");
        $description_nodes = $xmp->xpath('rdf:Description');

        $desc_fx = $description_nodes[0];
        $desc_fx->children('fx', true)->ConformanceLevel = strtoupper($this->documentBuiler->profiledef["xmpname"]);
        $this->pdfWriter->AddMetadataDescriptionNode($desc_fx->asXML());

        $this->pdfWriter->AddMetadataDescriptionNode($description_nodes[1]->asXML());

        $desc_pdfaid = $description_nodes[2];
        $this->pdfWriter->AddMetadataDescriptionNode($desc_pdfaid->asXML());

        $desc_dc = $description_nodes[3];
        $desc_nodes = $desc_dc->children('dc', true);
        $desc_nodes->title->children('rdf', true)->Alt->li = $pdf_metadata_infos['title'];
        $desc_nodes->creator->children('rdf', true)->Seq->li = $pdf_metadata_infos['author'];
        $desc_nodes->description->children('rdf', true)->Alt->li = $pdf_metadata_infos['subject'];
        $this->pdfWriter->AddMetadataDescriptionNode($desc_dc->asXML());

        $desc_adobe = $description_nodes[4];
        $desc_adobe->children('pdf', true)->Producer = 'FPDF';
        $this->pdfWriter->AddMetadataDescriptionNode($desc_adobe->asXML());

        $desc_xmp = $description_nodes[5];
        $xmp_nodes = $desc_xmp->children('xmp', true);
        $xmp_nodes->CreatorTool = sprintf('Factur-X PHP library v%s by HorstOeko', "1.0");
        $xmp_nodes->CreateDate = $pdf_metadata_infos['createdDate'];
        $xmp_nodes->ModifyDate = $pdf_metadata_infos['modifiedDate'];
        $this->pdfWriter->AddMetadataDescriptionNode($desc_xmp->asXML());
    }

    /**
     * Prepare PDF Metadata informations from Factur-X XML.
     *
     * @return array
     */
    private function preparePdfMetadata()
    {
        $invoiceInformations = $this->extractInvoiceInformations($this->xmlData);
        $dateString = date('Y-m-d', strtotime($invoiceInformations['date']));
        $title = sprintf('%s : %s %s', $invoiceInformations['seller'], $invoiceInformations['docTypeName'], $invoiceInformations['invoiceId']);
        $subject = sprintf('Factur-X %s %s dated %s issued by %s', $invoiceInformations['docTypeName'], $invoiceInformations['invoiceId'], $dateString, $invoiceInformations['seller']);
        $pdf_metadata = array(
            'author' => $invoiceInformations['seller'],
            'keywords' => sprintf('%s, Factur-X', $invoiceInformations['docTypeName']),
            'title' => $title,
            'subject' => $subject,
            'createdDate' => $invoiceInformations['date'],
            'modifiedDate' => date('Y-m-d\TH:i:s').'+00:00',
        );

        return $pdf_metadata;
    }

    /**
     * Extract major invoice information from Factur-X XML.
     *
     * @return array
     */
    protected function extractInvoiceInformations()
    {
        $xpath = new \DOMXpath($this->xmlData);
        $dateXpath = $xpath->query('//rsm:ExchangedDocument/ram:IssueDateTime/udt:DateTimeString');
        $date = $dateXpath->item(0)->nodeValue;
        $dateReformatted = date('Y-m-d\TH:i:s', strtotime($date)).'+00:00';
        $invoiceIdXpath = $xpath->query('//rsm:ExchangedDocument/ram:ID');
        $invoiceId = $invoiceIdXpath->item(0)->nodeValue;
        $sellerXpath = $xpath->query('//ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:Name');
        $seller = $sellerXpath->item(0)->nodeValue;
        $docTypeXpath = $xpath->query('//rsm:ExchangedDocument/ram:TypeCode');
        $docType = $docTypeXpath->item(0)->nodeValue;
        switch ($docType) {
            case '381':
                $docTypeName = 'Refund';
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
