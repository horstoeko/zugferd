<?php

use horstoeko\zugferd\ZugferdXsdValidator;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdDocumentPdfReader;

require dirname(__FILE__) . "/../vendor/autoload.php";

function showValidationResult($xsdValidator)
{
    if ($xsdValidator->validationFailed()) {
        echo "\033[01;31mValidation failed\e[0m\n";
        foreach ($xsdValidator->validationErrors() as $validationError) {
            echo $validationError . PHP_EOL;
        }
    } else {
        echo "\033[01;32mValidation passed\e[0m\n";
    }
}

/**
 * Invalid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/InvoiceXsdInvalid.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/invoice_1.pdf");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_extended_1.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_extended_2.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_en16931_1.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_en16931_2.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_en16931_3.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_en16931_4.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_xrechnung_1.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);

/**
 * Valid XML
 */

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../tests/assets/xml_xrechnung_2.xml");

$xsdValidator = new ZugferdXsdValidator($document);
$xsdValidator->validate();

showValidationResult($xsdValidator);
