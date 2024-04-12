<?php

use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdKositValidator;
use horstoeko\zugferd\ZugferdDocumentPdfReader;

require dirname(__FILE__) . "/../vendor/autoload.php";

/**
 * Helper function for outputting the errors
 *
 * @param ZugferdKositValidator $kositValidator
 * @return void
 */
function showValidationResult(ZugferdKositValidator $kositValidator)
{
    if ($kositValidator->hasProcessErrors()) {
        echo "\033[01;31mProcess failed\e[0m\n";
        foreach ($kositValidator->getProcessErrors() as $processError) {
            echo " - " . $processError["message"] . PHP_EOL;
        }
    } elseif ($kositValidator->hasValidationErrors()) {
        echo "\033[01;31mValidation failed\e[0m\n";
        foreach ($kositValidator->getValidationErrors() as $validationError) {
            echo " - " . $validationError["message"] . PHP_EOL;
        }
    } else {
        echo "\033[01;32mValidation passed\e[0m\n";
    }
}

/* ----------------------------------------------------------------------------------
   - Get instance of the Validator
   ---------------------------------------------------------------------------------- */

$kositValidator = new ZugferdKositValidator();

/* ----------------------------------------------------------------------------------
   - Validation of a document read by ZugferdDocumentPdfReader
   ---------------------------------------------------------------------------------- */

$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/invoice_1.pdf");
$kositValidator->setDocument($document)->disableCleanup()->validate();

showValidationResult($kositValidator);

/* ----------------------------------------------------------------------------------
   - Validation of a document read by ZugferdDocumentReader
   ---------------------------------------------------------------------------------- */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/en16931_simple_invalid.xml");

$kositValidator = new ZugferdKositValidator($document);
$kositValidator->setDocument($document)->disableCleanup()->validate();

showValidationResult($kositValidator);
