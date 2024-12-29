<?php

use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\codelists\ZugferdCountryCodes;
use horstoeko\zugferd\codelists\ZugferdCurrencyCodes;
use horstoeko\zugferd\codelists\ZugferdElectronicAddressScheme;
use horstoeko\zugferd\codelists\ZugferdUnitCodes;

require __DIR__ . "/../vendor/autoload.php";

require __DIR__ . "/00_ExampleHelpers.php";

// Create a new document in XRECHNUNG-Profile Version 3.x

$documentBuilder = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_XRECHNUNG_3);

// General Invoice Information

$documentBuilder->setDocumentInformation(
    'R-2024/00001',                                     // Invoice Number (BT-1)
    ZugferdInvoiceType::INVOICE,                        // Type "Invoice" (BT-3)
    DateTime::createFromFormat("Ymd", "20241231"),      // Invoice Date (BT-2)
    ZugferdCurrencyCodes::EURO                          // Invoice currency is EUR (Euro) (BT-5)
);

// Indication of when the period covered by the invoice begins and when it ends. Also referred to as the delivery period

$documentBuilder->setDocumentBillingPeriod(DateTime::createFromFormat("Ymd", "20250101"), DateTime::createFromFormat("Ymd", "20250131"), "01.01.2025 - 31.01.2025");

// Add documents supporting the invoice
// Type code 916 is used without exception for invoice justifying documents
// First example: Specification of an external resource including the intended primary access method, e.g. http:// or ftp://
// Second example: Specification of a local file to be included in the document as a BASE64-encoded attachment

$documentBuilder->addDocumentAdditionalReferencedDocument('REFDOC-2024/00001-1', '916', 'http.//some.url', 'Inhaltsstoffe Joghurt');
$documentBuilder->addDocumentAdditionalReferencedDocument('REFDOC-2024/00001-2', '916', null, 'Herkunftsnachweis Trennblätter', null, null, __DIR__ . '/00_AdditionalDocument.csv');

// Add details to the tender or lot reference. In some countries, a reference to the tender that led to the contract must be provided.
// Type code 50 is used exclusively for the specification of the tender or lot reference

$documentBuilder->addDocumentAdditionalReferencedDocument('LOS 738625', '50');

// Add details of the invoiced object
// Only the type code 130 is used to transmit an object identifier. Depending on the application, an object identifier
// can be a subscription number, a telephone number, a meter reading, a vehicle, a person, etc.
// Note: Additional documents of type code 130 may only be specified once.

$documentBuilder->addDocumentAdditionalReferencedDocument('125', '130', null, null, 'SA'); // Sales person number

// Adding a detail to a project reference
// Enter the identifier of the project to which the invoice refers and the name of the project.

$documentBuilder->setDocumentProcuringProject('PROJ-2025-001-1', 'Allgemeine Dienstleistungen');

// We should also define how payments are handled. In our case we want to use
// a SEPA direct debit. We book from the IBAN DE12500105170648489890. We also provide a Creditor-Reference
// We also need a creditor reference as the second parameter which is required for direct debit

$documentBuilder->addDocumentPaymentMeanToDirectDebit("DE12500105170648489890", "R-2024/00001");

// Set the payment terms as a textual information
// The first parameter defines the textual description of our payment terms.
// The second parameter defines the due date of the invoice. As you have chosen a direct debit procedure, this is the date of the direct debit.
// The third parameter defines the mandant reference which is required for direct debit

$documentBuilder->addDocumentPaymentTerm('Wird von Konto DE12500105170648489890 abgebucht', DateTime::createFromFormat("Ymd", "20250131"), 'MANDATE-2024/000001');

// Add seller information

$documentBuilder->setDocumentSeller("Lieferant GmbH", "549910");
$documentBuilder->addDocumentSellerGlobalId("4000001123452", "0088");
$documentBuilder->addDocumentSellerTaxNumber("201/113/40209");
$documentBuilder->addDocumentSellerVATRegistrationNumber("DE123456789");
$documentBuilder->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", ZugferdCountryCodes::GERMANY);
$documentBuilder->setDocumentSellerContact("H. Müller", "Verkauf", "+49-111-2222222", "+49-111-3333333", "hm@lieferant.de");
$documentBuilder->setDocumentSellerCommunication(ZugferdElectronicAddressScheme::UNECE3155_EM, 'sales@lieferant.de');

// Add buyer information

$documentBuilder->setDocumentBuyer("Kunden AG Mitte", "GE2020211");
$documentBuilder->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", ZugferdCountryCodes::GERMANY);
$documentBuilder->setDocumentBuyerContact("H. Meier", "Einkauf", "+49-333-4444444", "+49-333-5555555", "hm@kunde.de");
$documentBuilder->setDocumentBuyerCommunication(ZugferdElectronicAddressScheme::UNECE3155_EM, 'purchase@kunde.de');

// Specify a different payee
// You can specify a different payee
// It is possible to enter a postal address and a contact, but some validators issue a warning.

$documentBuilder->setDocumentPayee('Kunden AG Zahlungsdienstleistung');

// Specify a Routing ID (German: Leitweg-ID)
// In the XRECHNUNG it is required to provide a routing ID ("Leitweg ID")

$documentBuilder->setDocumentBuyerReference("34676-342323");

// Add a buyer order reference
// Sometimes it happens that you want to refer to an order (order number) transmitted by the customer when issuing the invoice
// We enter the customer's order number here:

$documentBuilder->setDocumentBuyerOrderReferencedDocument("PO-2024-0003324");

// Add a reference to the seller's internal sales order
// Sometimes the seller wants to provide his customer (buyer) a reference to the sellers internal sales order number

$documentBuilder->setDocumentSellerOrderReferencedDocument('SO-2024-000993337');

// Add a different delivery location
// It is also possible to specify a different delivery address in the invoice document
// It is possible to specify a contact at the different delivery point, but some validators issue a warning

$documentBuilder->setDocumentShipTo("Kunden AG Ost");
$documentBuilder->setDocumentShipToAddress("Lieferstraße 1", "", "", "04109", "Leipzig", ZugferdCountryCodes::GERMANY);

// Specification of a delivery date
// Delivery date can also be specified within the document

$documentBuilder->setDocumentSupplyChainEvent(DateTime::createFromFormat("Ymd", "20250115"));

// Add a position
// - The invoiced item is named "Trennblätter A4" and has an seller assigned item no. "TB100A4" (setDocumentPositionProductDetails)
// - The Net unit price is 9.90 EUR (setDocumentPositionNetPrice)
// - The Invoiced quantity is 20 pieces (setDocumentPositionQuantity)
// - The sales tax is calculated with 19% (addDocumentPositionTax)
// - The Line Amount is 20 * 9.90 EUR = 198.00 EUR (setDocumentPositionLineSummation)

$documentBuilder->addNewPosition("1");
$documentBuilder->setDocumentPositionProductDetails("Trennblätter A4", "50er Pack", "TB100A4");
$documentBuilder->setDocumentPositionNetPrice(9.9000);
$documentBuilder->setDocumentPositionQuantity(20, ZugferdUnitCodes::REC20_PIECE);
$documentBuilder->addDocumentPositionTax('S', 'VAT', 19);
$documentBuilder->setDocumentPositionLineSummation(198.0);

// Add a second position
// - The invoiced item is named "Joghurt Banane" and has an seller assigned item no. "ARNR2" (setDocumentPositionProductDetails)
// - The Net unit price is 5.50 EUR (setDocumentPositionNetPrice)
// - The Invoiced quantity is 50 pieces (setDocumentPositionQuantity)
// - The sales tax is calculated with 7% (addDocumentPositionTax)
// - The Line Amount is 50 * 5.50 EUR = 275.00 EUR (setDocumentPositionLineSummation)

$documentBuilder->addNewPosition("2");
$documentBuilder->setDocumentPositionProductDetails("Joghurt Banane", "B-Ware", "ARNR2");
$documentBuilder->SetDocumentPositionNetPrice(5.5000);
$documentBuilder->SetDocumentPositionQuantity(50, ZugferdUnitCodes::REC20_PIECE);
$documentBuilder->AddDocumentPositionTax('S', 'VAT', 7);
$documentBuilder->SetDocumentPositionLineSummation(275.0);

// Write the VAT Summation
// You have to group the VAT base amounts by VAT-Category ("S"), VAT-Type ("VAT") and VAT percent (19%, 7%)
// The first VAT summation comes at least from position 1 - 19% VAT from 198.00 EUR (Net-Amount) = 37.62
// The second VAT summation comes at least from position 2 - 7% VAT from 275.00 EUR (Net-Amount) = 19.25

$documentBuilder->addDocumentTax("S", "VAT", 198.0, 37.62, 19.0);
$documentBuilder->addDocumentTax("S", "VAT", 275.0, 19.25, 7.0);

// Write document summation
// 1. Grand total amount = 198.00 EUR + 37.62 EUR (VAT) + 275.00 EUR + 19.25 EUR (VAT) = 529.87
// 2. Amount to pay = We assume that there was no pre-payment and set the amount to be paid equal to the grand total amount
// 3. Net total amount = 198.EUR (Position 1) + 275.00 EUR (Position 2) = 473.00 EUR
// 4. Charge total amount = 0.00 EUR since we don't have any charges in the document
// 5. Allowance total amount = 0.00 EUR since we don't have any discounts in the document
// 6. Tax basis total amount = As a rule, this amount corresponds to 3.
// 7. Tax total amount = 19 % from 198.00 EUR = 37.62 EUR + 7% from 275.00 EUR = 19.25 EUR is 56.87 EUR

$documentBuilder->setDocumentSummation(529.87, 529.87, 473.00, 0.0, 0.0, 473.00, 56.87);

// Write XML file

$documentBuilder->writeFile(__DIR__ . "/factur-x.xml");

// Optionally we can validate the document before sending it
// See 00_ExampleHelpers.php

$validationResult = validateUsingKositValidator($documentBuilder);

echo $validationResult === 0 ? "Validation is disabled\n\n" : ($validationResult == 1 ? "The document is valid\n\n" : "The document is not valid\n\n");
