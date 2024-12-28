<?php

use horstoeko\zugferd\ZugferdPdfValidator;

require dirname(__FILE__) . "/../vendor/autoload.php";

/**
 * Helper function for outputting the errors
 *
 * @param ZugferdPdfValidator $pdfValidator
 * @return void
 */
function showValidationResult(ZugferdPdfValidator $pdfValidator): void
{
    foreach ($pdfValidator->getProcessOutput() as $output) {
        //echo $output . PHP_EOL;
    }

    if ($pdfValidator->hasProcessErrors()) {
        echo "\033[01;31mProcess failed\e[0m\n";
        foreach ($pdfValidator->getProcessErrors() as $processError) {
            echo " - " . $processError . PHP_EOL;
        }
    } elseif ($pdfValidator->hasValidationErrors()) {
        echo "\033[01;31mValidation failed\e[0m\n";
        foreach ($pdfValidator->getValidationErrors() as $validationError) {
            echo " - " . $validationError . PHP_EOL;
        }
    } else {
        echo "\033[01;32mValidation passed\e[0m\n";
    }
}


/* ----------------------------------------------------------------------------------
   - Perform validation
   ---------------------------------------------------------------------------------- */

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/invoice_1.pdf"))->disableCleanup()->validate();

showValidationResult($pdfValidator);

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/invoice_1.pdf"))->disableCleanup()->setValidatorRuleset(ZugferdPdfValidator::RULESET_PDF_A_3B)->validate();

showValidationResult($pdfValidator);

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/../tests/assets/pdf_plain.pdf"))->disableCleanup()->setValidatorRuleset(ZugferdPdfValidator::RULESET_PDF_A_0)->validate();

showValidationResult($pdfValidator);

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/../tests/assets/pdf_plain.pdf"))->disableCleanup()->setValidatorRuleset(ZugferdPdfValidator::RULESET_PDF_A_3B)->validate();

showValidationResult($pdfValidator);

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/../tests/assets/pdf_zf_en16931_1.pdf"))->disableCleanup()->setValidatorRuleset(ZugferdPdfValidator::RULESET_PDF_A_3B)->validate();

showValidationResult($pdfValidator);

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/../tests/assets/pdf_zf_en16931_2.pdf"))->disableCleanup()->setValidatorRuleset(ZugferdPdfValidator::RULESET_PDF_A_3B)->validate();

showValidationResult($pdfValidator);

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/../tests/assets/pdf_zf_en16931_3.pdf"))->disableCleanup()->setValidatorRuleset(ZugferdPdfValidator::RULESET_PDF_A_3B)->validate();

showValidationResult($pdfValidator);

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/../tests/assets/pdf_zf_extended_1.pdf"))->disableCleanup()->setValidatorRuleset(ZugferdPdfValidator::RULESET_PDF_A_3B)->validate();

showValidationResult($pdfValidator);

$pdfValidator = ZugferdPdfValidator::fromContent(file_get_contents(dirname(__FILE__) . "/../tests/assets/pdf_zf_xrechnung_1.pdf"))->disableCleanup()->setValidatorRuleset(ZugferdPdfValidator::RULESET_PDF_A_3B)->validate();

showValidationResult($pdfValidator);
