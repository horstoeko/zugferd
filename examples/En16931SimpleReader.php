<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

use horstoeko\zugferd\ZugferdDocumentReader;

require dirname(__FILE__) . "/../vendor/autoload.php";

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/data/xml_en16931_1.xml", true);

$document->getDocumentInformation(
    $documentno,
    $documenttypecode,
    $documentdate,
    $duedate,
    $invoiceCurrency,
    $taxCurrency,
    $documentname,
    $documentlanguage,
    $effectiveSpecifiedPeriod
);

echo "The Invoice No. is {$documentno}" . PHP_EOL;
