<?php

use horstoeko\zugferd\ZugferdDocumentJsonExporter;
use horstoeko\zugferd\ZugferdDocumentPdfReader;

require dirname(__FILE__) . "/../vendor/autoload.php";

$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/invoice_1.pdf");

$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);

$documentJsonExporter = new ZugferdDocumentJsonExporter($document);

echo $documentJsonExporter->toPrettyJsonString();
echo "\r\n\r\n";

$jsonObject = $documentJsonExporter->toJsonObject();

var_dump($jsonObject);

echo "\r\n\r\n";
