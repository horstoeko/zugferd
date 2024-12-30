<?php

use horstoeko\zugferd\codelists\ZugferdCountryCodes;
use horstoeko\zugferd\codelists\ZugferdCurrencyCodes;
use horstoeko\zugferd\codelists\ZugferdElectronicAddressScheme;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\codelists\ZugferdReferenceCodeQualifiers;
use horstoeko\zugferd\codelists\ZugferdUnitCodes;
use horstoeko\zugferd\codelists\ZugferdVatCategoryCodes;
use horstoeko\zugferd\codelists\ZugferdVatTypeCodes;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentPdfBuilder;
use horstoeko\zugferd\ZugferdDocumentPdfBuilderAbstract;
use horstoeko\zugferd\ZugferdProfiles;

require __DIR__ . "/../vendor/autoload.php";

require __DIR__ . "/00_ExampleHelpers.php";

// First we create a new valid document in XRECHNUNG-Profile Version 3.x
// See examples/01_ZugferdDocumentBuilder_XRECHNUNG.php for detailed explanations

$documentBuilder = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_XRECHNUNG_3);

$documentBuilder->setDocumentInformation(
    'R-2024/00001',                                     // Invoice Number (BT-1)
    ZugferdInvoiceType::INVOICE,                        // Type "Invoice" (BT-3)
    DateTime::createFromFormat("Ymd", "20241231"),      // Invoice Date (BT-2)
    ZugferdCurrencyCodes::EURO                          // Invoice currency is EUR (Euro) (BT-5)
);

$documentBuilder->addDocumentNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, null, 'REG');
$documentBuilder->setDocumentBillingPeriod(DateTime::createFromFormat("Ymd", "20250101"), DateTime::createFromFormat("Ymd", "20250131"), "01.01.2025 - 31.01.2025");
$documentBuilder->addDocumentInvoiceSupportingDocumentWithUri('REFDOC-2024/00001-1', 'http.//some.url', 'Inhaltsstoffe Joghurt');
$documentBuilder->addDocumentInvoiceSupportingDocumentWithFile('REFDOC-2024/00001-2', __DIR__ . '/assets/00_AdditionalDocument.csv', 'Herkunftsnachweis Trennblätter');
$documentBuilder->addDocumentTenderOrLotReferenceDocument('LOS 738625');
$documentBuilder->addDocumentInvoicedObjectReferenceDocument('125', ZugferdReferenceCodeQualifiers::SALE_PERS_NUMB); // Sales person number
$documentBuilder->setDocumentContractReferencedDocument('CON-2024/2025-001');
$documentBuilder->setDocumentProcuringProject('PROJ-2025-001-1', 'Allgemeine Dienstleistungen');
$documentBuilder->addDocumentPaymentMeanToDirectDebit("DE12500105170648489890", "R-2024/00001");
$documentBuilder->addDocumentPaymentTerm('Wird von Konto DE12500105170648489890 abgebucht', DateTime::createFromFormat("Ymd", "20250131"), 'MANDATE-2024/000001');
$documentBuilder->setDocumentSeller("Lieferant GmbH", "549910");
$documentBuilder->addDocumentSellerGlobalId("4000001123452", "0088");
$documentBuilder->addDocumentSellerTaxNumber("201/113/40209");
$documentBuilder->addDocumentSellerVATRegistrationNumber("DE123456789");
$documentBuilder->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", ZugferdCountryCodes::GERMANY);
$documentBuilder->setDocumentSellerContact("H. Müller", "Verkauf", "+49-111-2222222", "+49-111-3333333", "hm@lieferant.de");
$documentBuilder->setDocumentSellerCommunication(ZugferdElectronicAddressScheme::UNECE3155_EM, 'sales@lieferant.de');
$documentBuilder->setDocumentBuyer("Kunden AG Mitte", "GE2020211");
$documentBuilder->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", ZugferdCountryCodes::GERMANY);
$documentBuilder->setDocumentBuyerContact("H. Meier", "Einkauf", "+49-333-4444444", "+49-333-5555555", "hm@kunde.de");
$documentBuilder->setDocumentBuyerCommunication(ZugferdElectronicAddressScheme::UNECE3155_EM, 'purchase@kunde.de');
$documentBuilder->setDocumentPayee('Kunden AG Zahlungsdienstleistung');
$documentBuilder->setDocumentBuyerOrderReferencedDocument("PO-2024-0003324");
$documentBuilder->setDocumentSellerOrderReferencedDocument('SO-2024-000993337');
$documentBuilder->setDocumentShipTo("Kunden AG Ost");
$documentBuilder->setDocumentShipToAddress("Lieferstraße 1", "", "", "04109", "Leipzig", ZugferdCountryCodes::GERMANY);
$documentBuilder->setDocumentSupplyChainEvent(DateTime::createFromFormat("Ymd", "20250115"));
$documentBuilder->addNewPosition("1");
$documentBuilder->setDocumentPositionProductDetails("Trennblätter A4", "50er Pack", "TB100A4");
$documentBuilder->setDocumentPositionNetPrice(9.9000);
$documentBuilder->setDocumentPositionQuantity(20, ZugferdUnitCodes::REC20_PIECE);
$documentBuilder->addDocumentPositionTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 19);
$documentBuilder->setDocumentPositionLineSummation(198.0);
$documentBuilder->addNewPosition("2");
$documentBuilder->setDocumentPositionProductDetails("Joghurt Banane", "B-Ware", "ARNR2");
$documentBuilder->SetDocumentPositionNetPrice(5.5000);
$documentBuilder->SetDocumentPositionQuantity(50, ZugferdUnitCodes::REC20_PIECE);
$documentBuilder->AddDocumentPositionTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 7);
$documentBuilder->SetDocumentPositionLineSummation(275.0);
$documentBuilder->addNewPosition("3");
$documentBuilder->setDocumentPositionProductDetails("Joghurt Erdbeer", "", "ARNR3");
$documentBuilder->SetDocumentPositionNetPrice(4.0000);
$documentBuilder->SetDocumentPositionQuantity(100, ZugferdUnitCodes::REC20_PIECE);
$documentBuilder->AddDocumentPositionTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 7);
$documentBuilder->SetDocumentPositionLineSummation(400.0);
$documentBuilder->addDocumentTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 198.0, 37.62, 19.0);
$documentBuilder->addDocumentTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 675.0, 47.25, 7.0);
$documentBuilder->setDocumentSummation(957.87, 957.87, 873.00, 0.0, 0.0, 873.00, 84.87);

// Next let's do the ZugferddocumentPdfBuilder it's job - let's attach the XML to the PDF. The attachment filename will be xrechnung.xml
// since whe choosed the profile XRECHNUNG 3.x in the ZugferdDocumentBuilder (see above)
// In the following there are multiple methods how you can build a conform PDF from an existing print layout

$existingPdfFilename = __DIR__ . "/assets/00_ZugferdDocumentPdfBuilder_PrintLayout.pdf";
$newPdfFilename = __DIR__ . "/02_ZugferdDocumentPdfBuilder_PrintLayout_Merged.pdf";

// First method: Merge the generated XML from ZugferdDocumentBuilder with an existing print layout file to a new PDF file

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($documentBuilder, $existingPdfFilename);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);

// Second method: Merge the generated XML from ZugferdDocumentBuilder with an stream (string) which contains the PDF to a new PDF file
// Note: We simulate the PDF stream (string) by calling file_get_contents.

$pdfContent = file_get_contents($existingPdfFilename);

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfString($documentBuilder, $pdfContent);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);

// There is not only the saveDocument method of the ZugferdDocumentPdfBuilder. It is also possible to receive the merged
// content (PDF with embedded XML) as a stream (string)

$mergedPdfContent = $zugferdDocumentPdfBuilder->downloadString('dummy.pdf');

// If you would like to brand the merged PDF with the name of you own solution you can call
// the method setAdditionalCreatorTool. Before calling this method the creator of the PDF is identified as 'Factur-X library 1.x.x by HorstOeko'.
// After calling this method you get 'MyERPSolution 1.0 / Factur-X PHP library 1.x.x by HorstOeko' as the creator

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfString($documentBuilder, $pdfContent);
$zugferdDocumentPdfBuilder->setAdditionalCreatorTool('MyERPSolution 1.0');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);

// And last but not least, it is also possible to add additional attachments to the merged PDF. These can be any files that can help the invoice
// recipient with processing. For example, a time sheet as an Excel file would be conceivable.
// The method attachAdditionalFileByRealFile has 3 parameters:
// - The file to attach which must exist and must be readable
// - (Optional) A name to display in the attachments of the PDF
// - (Optional) The type of the relationship of the attachment. Valid values are defined in the class ZugferdDocumentPdfBuilderAbstract. The constants are starting with AF_
// If you omit the last 2 parameters the following will happen:
// - The displayname is calculated from the filename you specified
// - The type of the relationship of the attachment will be AF_RELATIONSHIP_SUPPLEMENT (Supplement)

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfString($documentBuilder, $pdfContent);
$zugferdDocumentPdfBuilder->attachAdditionalFileByRealFile(__DIR__ . '/assets/00_AdditionalDocument.csv', "Some display Name", ZugferdDocumentPdfBuilderAbstract::AF_RELATIONSHIP_SUPPLEMENT);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);

// You can also add an attachment to the PDF as an stream (string). The conditions are the same as above for the attachAdditionalFileByRealFile method
// The only difference to attachAdditionalFileByRealFile is that the attachAdditionalFileByContent method accepts 4 parameters, whereby here (as with attachAdditionalFileByRealFile)
// the last two can be omitted. You only need to specify a file name under which the file is to be embedded
// Note: We simulate the attachment stream (string) by calling file_get_contents.

$attachmentContent = file_get_contents(__DIR__ . '/assets/00_AdditionalDocument.csv');

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfString($documentBuilder, $pdfContent);
$zugferdDocumentPdfBuilder->attachAdditionalFileByContent($attachmentContent, 'additionalDocument.csv', "Some other display Name", ZugferdDocumentPdfBuilderAbstract::AF_RELATIONSHIP_SUPPLEMENT);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);

// Set values for metadata-fields
// We can change some meta information such as the title, the subject, the author and the keywords.  This library essentially provides 4 methods for this.
// These methods use so-called templates. These methods are:

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($documentBuilder, $existingPdfFilename);
$zugferdDocumentPdfBuilder->setAuthorTemplate('.....');
$zugferdDocumentPdfBuilder->setTitleTemplate('.....');
$zugferdDocumentPdfBuilder->setSubjectTemplate('.....');
$zugferdDocumentPdfBuilder->setKeywordTemplate('.....');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);

// The 4 methods just mentioned accept a free text that can accept the following placeholders:
// - %1$s .... contains the invoice number (is extracted from the XML data)
// - %2$s .... contains the type of XML document, such as ‘Invoice’ (is extracted from the XML data)
// - %3$s .... contains the name of the seller (extracted from the XML data)
// - %4$s .... contains the invoice date (extracted from the XML data)
// The following example generates...
// - the author:  .... Issued by seller with name Lieferant GmbH
// - the title    .... Lieferant GmbH : Invoice R-2024/00001
// - the subject  .... Invoice-Document, Issued by Lieferant GmbH
// - the keywords .... R-2024/00001, Invoice, Lieferant GmbH, 2024-12-31

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($documentBuilder, $existingPdfFilename);
$zugferdDocumentPdfBuilder->setAuthorTemplate('Issued by seller with name %3$s');
$zugferdDocumentPdfBuilder->setTitleTemplate('%3$s : %2$s %1$s');
$zugferdDocumentPdfBuilder->setSubjectTemplate('%2$s-Document, Issued by %3$s');
$zugferdDocumentPdfBuilder->setKeywordTemplate('%1$s, %2$s, %3$s, %4$s');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);

// If the previously mentioned options for manipulating the meta information are not sufficient,
// you can also use a callback function. The following 4 parameters are passed to the callback
// function in the specified order:
// - $which               .... one of "author", "title", "subject" and "keywords"
// - $xmlContent          .... the content of the xml as a string
// - $invoiceInformation  .... an array with some information about the invoice
// - $default             .... The default value for the specified field (see $which

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($documentBuilder, $existingPdfFilename);
$zugferdDocumentPdfBuilder->setMetaInformationCallback(
    function ($which) {
        if ($which === 'title') {
            return "DummyTitle";
        }
        if ($which === 'author') {
            return "DummyAuthor";
        }
        if ($which === 'subject') {
            return "DummySubject";
        }
        if ($which === 'keywords') {
            return "DummyKeywords";
        }
    }
);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);

// To remove the callback you can call the setMetaInformationCallback
// method with a null value

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($documentBuilder, $existingPdfFilename);
$zugferdDocumentPdfBuilder->setMetaInformationCallback(null);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument($newPdfFilename);
