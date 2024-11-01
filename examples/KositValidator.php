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
    foreach ($kositValidator->getProcessOutput() as $output) {
        echo $output . PHP_EOL;
    }

    if ($kositValidator->hasProcessErrors()) {
        echo "\033[01;31mProcess failed\e[0m\n";
        foreach ($kositValidator->getProcessErrors() as $processError) {
            echo " - " . $processError . PHP_EOL;
        }
    } elseif ($kositValidator->hasValidationErrors()) {
        echo "\033[01;31mValidation failed\e[0m\n";
        foreach ($kositValidator->getValidationErrors() as $validationError) {
            echo " - " . $validationError . PHP_EOL;
        }
    } else {
        echo "\033[01;32mValidation passed\e[0m\n";
    }
}

/* ----------------------------------------------------------------------------------
   - Validation of a document read by ZugferdDocumentPdfReader
   - The direct call of the constructor is deprecated
   ---------------------------------------------------------------------------------- */

$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/invoice_1.pdf");

$kositValidator = new ZugferdKositValidator($document);
$kositValidator->disableCleanup()->validate();

showValidationResult($kositValidator);

/* ----------------------------------------------------------------------------------
   - Validation of a document read by ZugferdDocumentPdfReader
   ---------------------------------------------------------------------------------- */

$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/invoice_1.pdf");

$kositValidator = ZugferdKositValidator::fromDocument($document)->disableCleanup()->validate();

showValidationResult($kositValidator);

/* ----------------------------------------------------------------------------------
   - Validation of a document read by ZugferdDocumentReader
   ---------------------------------------------------------------------------------- */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_en16931_5.xml");

$kositValidator = ZugferdKositValidator::fromDocument($document)->disableCleanup()->validate();

showValidationResult($kositValidator);

/* ----------------------------------------------------------------------------------
   - Validation of a document read by content
   ---------------------------------------------------------------------------------- */

$content = file_get_contents(dirname(__FILE__) . "/../tests/assets/xml_en16931_4.xml");

$kositValidator = ZugferdKositValidator::fromString($content)->disableCleanup()->validate();

showValidationResult($kositValidator);
