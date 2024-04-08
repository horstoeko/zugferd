<?php

use horstoeko\zugferd\ZugferdDocumentPdfReader;
use horstoeko\zugferd\ZugferdKositValidator;

require dirname(__FILE__) . "/../vendor/autoload.php";

function showValidationResult($kositValidator)
{
    if ($kositValidator->validationFailed()) {
        echo "\033[01;31mValidation failed\e[0m\n";
        foreach ($kositValidator->validationErrors() as $validationError) {
            echo $validationError . PHP_EOL;
        }
    } else {
        echo "\033[01;32mValidation passed\e[0m\n";
    }
}

$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/invoice_1.pdf");

$kositValidator = new ZugferdKositValidator($document);
$kositValidator->validate();

showValidationResult($kositValidator);
