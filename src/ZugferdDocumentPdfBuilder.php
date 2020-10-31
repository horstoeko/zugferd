<?php

namespace horstoeko\zugferd;

class ZugferdDocumentPdfBuilder
{
    /**
     * Internal reference to the xml builder instance
     *
     * @var ZugferdDocumentBuilder
     */
    private $documentBuiler = null;

    /**
     * Contains the filename or the string with PDF data
     *
     * @var string
     */
    private $pdfData = "";

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
    }

    /**
     * Generates the final document
     *
     * @return ZugferdDocumentPdfBuilder
     */
    public function generateDocument(): ZugferdDocumentPdfBuilder
    {
        // Get XML data from Builder

        $xmlContent = $this->documentBuiler->getContent();

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
        return $this;
    }
}
