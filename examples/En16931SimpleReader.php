<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

use horstoeko\zugferd\exception\ZugferdValidationFailed;
use horstoeko\zugferd\ZugferdDocumentReader;

require getcwd() . "/../vendor/autoload.php";

try {

    $document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/data/en16931_simple.xml", true);

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

} catch (ZugferdValidationFailed $e) {

    var_dump($e->getValidationErrorList());

}
