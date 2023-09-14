<?php

use horstoeko\zugferd\ZugferdDocumentPdfMerger;

require dirname(__FILE__) . "/../vendor/autoload.php";

$pdfMerger = new ZugferdDocumentPdfMerger(dirname(__FILE__) . "/invoice_1.xml", dirname(__FILE__) . "/emptypdf.pdf");
$pdfMerger->generateDocument();
$pdfMerger->saveDocument(dirname(__FILE__) . "/fullpdf.pdf");
