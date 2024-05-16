<?php

use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\codelists\ZugferdPaymentMeans;

require dirname(__FILE__) . "/../vendor/autoload.php";

/*
    Example 1: No discounts or surcharges at all
*/

$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);
$document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->addDocumentNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, null, 'REG')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->addDocumentPaymentMean(ZugferdPaymentMeans::UNTDID_4461_58, null, null, null, null, null, "DE12500105170648489890", null, null, null)
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentSellerContact("Heinz Mükker", "Buchhaltung", "+49-111-2222222", "+49-111-3333333","info@lieferant.de")
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerReference("34676-342323")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Hosting", "", "HST0000")
    ->setDocumentPositionGrossPrice(10.0)
    ->setDocumentPositionNetPrice(10.0)
    ->setDocumentPositionQuantity(1, "XPP")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(10)
    ->addDocumentTax("S", "VAT", 10, 1.90, 19.0)
    ->setDocumentSummation(11.90, 11.90, 10.00, 0.0, 0.0, 10.0, 1.90, 0.0, 0.0)
    ->writeFile(dirname(__FILE__) . "/discount_1.xml");

/*
    Example 2: Reduction of the net unit price (from item level)
*/

$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);
$document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->addDocumentNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, null, 'REG')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->addDocumentPaymentMean(ZugferdPaymentMeans::UNTDID_4461_58, null, null, null, null, null, "DE12500105170648489890", null, null, null)
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentSellerContact("Heinz Mükker", "Buchhaltung", "+49-111-2222222", "+49-111-3333333","info@lieferant.de")
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerReference("34676-342323")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Hosting", "", "HST0000")
    ->setDocumentPositionGrossPrice(14.0)
    ->addDocumentPositionGrossPriceAllowanceCharge(4.00, false)
    ->setDocumentPositionNetPrice(10.0)
    ->setDocumentPositionQuantity(1, "XPP")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(10)
    ->addDocumentTax("S", "VAT", 10, 1.90, 19.0)
    ->setDocumentSummation(11.90, 11.90, 10.00, 0.0, 0.0, 10.0, 1.90, 0.0, 0.0)
    ->writeFile(dirname(__FILE__) . "/discount_2.xml");

/*
    Example 3: Row discount (on the total net amount of the row, NetPriceProductTradePrice * BilledQuantity)
*/

$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);
$document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->addDocumentNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, null, 'REG')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->addDocumentPaymentMean(ZugferdPaymentMeans::UNTDID_4461_58, null, null, null, null, null, "DE12500105170648489890", null, null, null)
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentSellerContact("Heinz Mükker", "Buchhaltung", "+49-111-2222222", "+49-111-3333333","info@lieferant.de")
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerReference("34676-342323")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Hosting", "", "HST0000")
    ->setDocumentPositionGrossPrice(10.0)
    ->setDocumentPositionNetPrice(10.0)
    ->setDocumentPositionQuantity(1, "XPP")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->addDocumentPositionAllowanceCharge(1.00, false, null, null, null, "Discount")
    ->setDocumentPositionLineSummation(9)
    ->addDocumentTax("S", "VAT", 9.00, 1.71, 19.0)
    ->setDocumentSummation(10.71, 10.71, 9.00, 0.0, 0.0, 9.0, 1.71, 0.0, 0.0)
    ->writeFile(dirname(__FILE__) . "/discount_3.xml");

/*
    Example 4: Discount at document level (e.g. invoice discount)
*/

$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);
$document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->addDocumentNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, null, 'REG')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->addDocumentPaymentMean(ZugferdPaymentMeans::UNTDID_4461_58, null, null, null, null, null, "DE12500105170648489890", null, null, null)
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentSellerContact("Heinz Mükker", "Buchhaltung", "+49-111-2222222", "+49-111-3333333","info@lieferant.de")
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerReference("34676-342323")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Hosting", "", "HST0000")
    ->setDocumentPositionGrossPrice(10.0)
    ->setDocumentPositionNetPrice(10.0)
    ->setDocumentPositionQuantity(1, "XPP")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(10)
    ->addDocumentAllowanceCharge(1.00, false, "S", "VAT", 19.0, null, null, null, null, null, null, "Discount")
    ->addDocumentTax("S", "VAT", 9, 1.71, 19.0)
    ->setDocumentSummation(10.71, 10.71, 10.00, 0.0, 1.0, 9.0, 1.71, 0.0, 0.0)
    ->writeFile(dirname(__FILE__) . "/discount_4.xml");
