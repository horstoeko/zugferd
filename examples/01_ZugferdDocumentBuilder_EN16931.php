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
use horstoeko\zugferd\ZugferdProfiles;

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/00_ExampleHelpers.php";

// First we create a new invoice in EN16931-Profile (== COMFORT-Profile)

$documentBuilder = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EN16931);

// General invoice Information

$documentBuilder->setDocumentInformation(
  'R-2024/00001',                                     // Invoice number (BT-1)
  ZugferdInvoiceType::INVOICE,                        // Type "Invoice" (BT-3)
  DateTime::createFromFormat('Ymd', '20241231'),      // Invoice fate (BT-2)
  ZugferdCurrencyCodes::EURO                          // Invoice currency is EUR (Euro) (BT-5)
);

// Not mandatory, but welcome are details such as managing director, commercial register entry or similar

$documentBuilder->addDocumentNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, null, 'REG');

// Indication of when the period covered by the invoice begins and when it ends. Also referred to as the delivery period

$documentBuilder->setDocumentBillingPeriod(DateTime::createFromFormat('Ymd', '20250101'), DateTime::createFromFormat('Ymd', '20250131'), '01.01.2025 - 31.01.2025');

// Add additional documents supporting the invoice
// Type code 916 is used without exception for invoice justifying documents
// First example: Specification of an external resource including the intended primary access method, e.g. http:// or ftp://
// Second example: Specification of a local file to be included in the document as a BASE64-encoded attachment

$documentBuilder->addDocumentInvoiceSupportingDocumentWithUri('REFDOC-2024/00001-1', 'http.//some.url', 'Inhaltsstoffe Joghurt');
$documentBuilder->addDocumentInvoiceSupportingDocumentWithFile('REFDOC-2024/00001-2', __DIR__ . '/assets/00_AdditionalDocument.csv', 'Herkunftsnachweis Trennblätter');

// Add details to the tender or lot reference. In some countries, a reference to the tender that led to the contract must be provided.
// Type code 50 is used exclusively for the specification of the tender or lot reference

$documentBuilder->addDocumentTenderOrLotReferenceDocument('LOS 738625');

// Add details of the calculated object. Only the type code 130 is used to transmit an object identifier. Depending on the application,
// an object identifier can be a subscription number, a telephone number, a meter reading, a vehicle, a person, etc.
// Note: Additional documents of type code 130 may only be specified once.

$documentBuilder->addDocumentInvoicedObjectReferenceDocument('125', ZugferdReferenceCodeQualifiers::SALE_PERS_NUMB); // Sales person number

// Adding details to the associated contract
// The contract reference should be assigned once in the context of the specific trading relationship and for a defined period of time.

$documentBuilder->setDocumentContractReferencedDocument('CON-2024/2025-001');

// Adding a detail to a project reference
// Enter the identifier of the project to which the invoice refers and the name of the project.

$documentBuilder->setDocumentProcuringProject('PROJ-2025-001-1', 'Allgemeine Dienstleistungen');

// We should also define how payments are handled. In our case we want to use
// a SEPA direct debit. We book from the IBAN DE12500105170648489890. We also provide a Creditor-Reference
// We also need a creditor reference as the second parameter which is required for direct debit

$documentBuilder->addDocumentPaymentMeanToDirectDebit('DE12500105170648489890', 'R-2024/00001');

// We should also define the payment terms as a textual information
// The first parameter defines the textual description of our payment terms.
// The second parameter defines the due date of the invoice. As you have chosen a direct debit procedure, this is the date of the direct debit.
// The third parameter defines the mandant reference which is required for direct debit

$documentBuilder->addDocumentPaymentTerm('Wird von Konto DE12500105170648489890 abgebucht', DateTime::createFromFormat('Ymd', '20250131'), 'MANDATE-2024/000001');

// An indispensable part of an invoice is the indication of the seller (supplier). Let's do that now.

$documentBuilder->setDocumentSeller('Lieferant GmbH', '549910');
$documentBuilder->addDocumentSellerGlobalId('4000001123452', '0088');
$documentBuilder->addDocumentSellerTaxNumber('201/113/40209');
$documentBuilder->addDocumentSellerVATRegistrationNumber('DE123456789');
$documentBuilder->setDocumentSellerAddress('Lieferantenstraße 20', '', '', '80333', 'München', ZugferdCountryCodes::GERMANY);
$documentBuilder->setDocumentSellerContact('H. Müller', 'Verkauf', '+49-111-2222222', '+49-111-3333333', 'hm@lieferant.de');
$documentBuilder->setDocumentSellerCommunication(ZugferdElectronicAddressScheme::UNECE3155_EM, 'sales@lieferant.de');

// The buyer (customer) details are also an important part of the invoice.

$documentBuilder->setDocumentBuyer('Kunden AG Mitte', 'GE2020211');
$documentBuilder->setDocumentBuyerAddress('Kundenstraße 15', '', '', '69876', 'Frankfurt', ZugferdCountryCodes::GERMANY);
$documentBuilder->setDocumentBuyerContact('H. Meier', 'Einkauf', '+49-333-4444444', '+49-333-5555555', 'hm@kunde.de');
$documentBuilder->setDocumentBuyerCommunication(ZugferdElectronicAddressScheme::UNECE3155_EM, 'purchase@kunde.de');

// You can specify a different payee. It is possible to enter a postal address and
// a contact, but some validators issue a warning.

$documentBuilder->setDocumentPayee('Kunden AG Zahlungsdienstleistung');

// Sometimes it happens that you want to refer to an order (order number) transmitted by the buyer (customer) when
// issuing the invoice. We enter the buyer (customer) order number here:

$documentBuilder->setDocumentBuyerOrderReferencedDocument('PO-2024-0003324');

// Sometimes the seller (supplier) wants to provide his buyer (customer) a reference to the internal sales order number

$documentBuilder->setDocumentSellerOrderReferencedDocument('SO-2024-000993337');

// It is also possible to specify a different delivery point in the invoice
// It is possible to specify a contact at the different delivery point, but some validators issue a warning

$documentBuilder->setDocumentShipTo('Kunden AG Ost');
$documentBuilder->setDocumentShipToAddress('Lieferstraße 1', '', '', '04109', 'Leipzig', ZugferdCountryCodes::GERMANY);

// A delivery date can also be specified within the invoice

$documentBuilder->setDocumentSupplyChainEvent(DateTime::createFromFormat('Ymd', '20250115'));

// It is now time to add our first invoice line. This is defined as follows
//  - The product name is "Trennblätter A4" and has a seller (supplier) assigned item number "TB100A4" (setDocumentPositionProductDetails)
//  - The unit price is 9.90 EUR (setDocumentPositionNetPrice)
//  - The quantity is 20 pieces (setDocumentPositionQuantity)
//  - The VAT is calculated with 19% (addDocumentPositionTax)
//  - The line amount is 20 * 9.90 EUR = 198.00 EUR (setDocumentPositionLineSummation)

$documentBuilder->addNewPosition('1');
$documentBuilder->setDocumentPositionProductDetails('Trennblätter A4', '50er Pack', 'TB100A4');
$documentBuilder->setDocumentPositionNetPrice(9.9000);
$documentBuilder->setDocumentPositionQuantity(20, ZugferdUnitCodes::REC20_PIECE);
$documentBuilder->addDocumentPositionTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 19);
$documentBuilder->setDocumentPositionLineSummation(198.0);

// We now add a second invoice line.
//  - The product name is "Joghurt Banane" and has a seller (supplier) assigned item number "ARNR2" (setDocumentPositionProductDetails)
//  - The unit price is 5.50 EUR (setDocumentPositionNetPrice)
//  - The quantity is 50 pieces (setDocumentPositionQuantity)
//  - The VAT is calculated with 7% (addDocumentPositionTax)
//  - The line amount is 50 * 5.50 EUR = 275.00 EUR (setDocumentPositionLineSummation)

$documentBuilder->addNewPosition('2');
$documentBuilder->setDocumentPositionProductDetails('Joghurt Banane', 'B-Ware', 'ARNR2');
$documentBuilder->setDocumentPositionNetPrice(5.5000);
$documentBuilder->setDocumentPositionQuantity(50, ZugferdUnitCodes::REC20_PIECE);
$documentBuilder->addDocumentPositionTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 7);
$documentBuilder->setDocumentPositionLineSummation(275.0);

// Last but not least, we add a third and final invoice line. This should essentially also serve to clarify the VAT calculation in the following
//  - The product name is "Joghurt Erdbeer" and has a seller (supplier) assigned item number "ARNR3" (setDocumentPositionProductDetails)
//  - The unit price is 4.00 EUR (setDocumentPositionNetPrice)
//  - The quantity is 100 pieces (setDocumentPositionQuantity)
//  - The VAT is calculated with 7% (addDocumentPositionTax)
//  - The line amount is 100 * 4.00 EUR = 400.00 EUR (setDocumentPositionLineSummation)

$documentBuilder->addNewPosition('3');
$documentBuilder->setDocumentPositionProductDetails('Joghurt Erdbeer', '', 'ARNR3');
$documentBuilder->setDocumentPositionNetPrice(4.0000);
$documentBuilder->setDocumentPositionQuantity(100, ZugferdUnitCodes::REC20_PIECE);
$documentBuilder->addDocumentPositionTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 7);
$documentBuilder->setDocumentPositionLineSummation(400.0);

// Now we need to generate the VAT breakdown. This is an essential part of the invoice.
// You have to group the VAT base amounts by VAT-Category ("S"), VAT-Type ("VAT") and VAT-Percent (19%, 7%)
// The calculation is as follows:
// - The first VAT summation comes at least from invoice line 1 - 19% VAT from 198.00 EUR (Net-Amount) = 37.62
// - The second VAT summation comes at least from invoice line 2 & 3 - 7% VAT from 275.00 EUR + 400.00 EUR = 675.00 EUR (Net-Amount) = 47.25

$documentBuilder->addDocumentTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 198.0, 37.62, 19.0);
$documentBuilder->addDocumentTax(ZugferdVatCategoryCodes::STAN_RATE, ZugferdVatTypeCodes::VALUE_ADDED_TAX, 675.0, 47.25, 7.0);

// Finally, there is an equally important part of the invoice - the totals.
//  1. Grand total amount = 198.00 EUR + 37.62 EUR (VAT) + 675.00 EUR + 47.25 EUR (VAT) = 957.87
//  2. Amount to pay = We assume that there was no pre-payment and set the amount to be paid equal to the grand total amount
//  3. Net total amount = 198.EUR (Position 1) + 675.00 EUR (Position 2 & 3) = 873.00 EUR
//  4. Charge total amount = 0.00 EUR since we don't have any charges in the invoice
//  5. Discount total amount = 0.00 EUR since we don't have any discounts in the invoice
//  6. VAT basis total amount = As a rule, this amount corresponds to 3.
//  7. VAT total amount = 19 % from 198.00 EUR = 37.62 EUR + 7% from 675.00 EUR = 47.28 EUR is 84.87 EUR

$documentBuilder->setDocumentSummation(957.87, 957.87, 873.00, 0.0, 0.0, 873.00, 84.87);

// We can now generate the invoice as a file...

$documentBuilder->writeFile(__DIR__ . '/factur-x.xml');

// ... or have the generated XML returned as a string

$someStringVariable = $documentBuilder->getContent();

// Optionally validate XML. For details see 00_ExampleHelpers.php

$validationResult = validateUsingKositValidator($documentBuilder);

echo $validationResult === 0 ? 'Validation is disabled' : ($validationResult == 1 ? 'The document is valid' : 'The document is not valid');

