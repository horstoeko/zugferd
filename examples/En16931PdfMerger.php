<?php

use horstoeko\zugferd\ZugferdDocumentPdfMerger;

require dirname(__FILE__) . "/../vendor/autoload.php";

$existingXml = dirname(__FILE__) . "/invoice_1.xml";
$existingPdf = dirname(__FILE__) . "/emptypdf.pdf";
$mergeToPdf = dirname(__FILE__) . "/fullpdf.pdf";

if (!file_exists($existingXml) || !file_exists($existingPdf)) {
    throw new \Exception("XML and/or PDF does not exist");
}

(new ZugferdDocumentPdfMerger($existingXml, $existingPdf))->setAdditionalCreatorTool('Contoso ERP 1.0')->generateDocument()->saveDocument($mergeToPdf);
