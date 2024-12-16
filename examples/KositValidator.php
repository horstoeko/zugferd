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

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_en16931_5.xml");

$kositValidator = new ZugferdKositValidator($document);
$kositValidator->setDocument($document)->disableCleanup()->validate();

showValidationResult($kositValidator);

/* ----------------------------------------------------------------------------------
   - Validation of a document read by ZugferdDocumentPdfReader (Remote, using running daemon)
   ---------------------------------------------------------------------------------- */

$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/invoice_1.pdf");
$kositValidator->setDocument($document)->enableRemoteMode()->setRemoteModeHost("127.0.0.1")->setRemoteModePort(8081)->validate();

showValidationResult($kositValidator);

/* ----------------------------------------------------------------------------------
   - Validation of a document read by ZugferdDocumentReader (Remote, using running daemon)
   ---------------------------------------------------------------------------------- */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_en16931_5.xml");

$kositValidator->setDocument($document)->enableRemoteMode()->setRemoteModeHost("127.0.0.1")->setRemoteModePort(8081)->validate();

showValidationResult($kositValidator);

/* ----------------------------------------------------------------------------------
   - Validation of a document read by content string (Remote, using running daemon)
   ---------------------------------------------------------------------------------- */

$kositValidator->setDocument(file_get_contents(dirname(__FILE__) . "/../tests/assets/xml_en16931_5.xml"))->enableRemoteMode()->setRemoteModeHost("127.0.0.1")->setRemoteModePort(8081)->validate();

showValidationResult($kositValidator);
