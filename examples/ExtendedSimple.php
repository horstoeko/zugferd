<?php

use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdSettings;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\codelists\ZugferdPaymentMeans;

require dirname(__FILE__) . "/../vendor/autoload.php";

ZugferdSettings::addSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:ApplicableTradePaymentDiscountTerms/ram:BasisPeriodMeasure', 0);

$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EXTENDED);
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
    ->setDocumentSellerContact("Heinz Mükker", "Buchhaltung", "+49-111-2222222", "+49-111-3333333", "info@lieferant.de")
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerReference("34676-342323")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->addDocumentTax("S", "VAT", 275.0, 19.25, 7.0)
    ->addDocumentTax("S", "VAT", 198.0, 37.62, 19.0)
    ->setDocumentSummation(529.87, 529.87, 473.00, 0.0, 0.0, 473.00, 56.87, null, 0.0)
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
    ->addNewPosition("1")
    ->setDocumentPositionNote("Bemerkung zu Zeile 1")
    ->setDocumentPositionProductDetails("Trennblätter A4", "", "TB100A4", null, "0160", "4012345001235")
    ->addDocumentPositionProductCharacteristic("Farbe", "Gelb")
    ->addDocumentPositionProductClassification("ClassCode", "ClassName", "ListId", "ListVersionId")
    ->setDocumentPositionProductOriginTradeCountry("CN")
    ->setDocumentPositionGrossPrice(9.9000)
    ->setDocumentPositionNetPrice(9.9000)
    ->setDocumentPositionQuantity(20, "H87")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(198.0)
    ->addNewPosition("2")
    ->setDocumentPositionNote("Bemerkung zu Zeile 2")
    ->setDocumentPositionProductDetails("Joghurt Banane", "", "ARNR2", null, "0160", "4000050986428")
    ->addDocumentPositionProductCharacteristic("Suesstoff", "Nein")
    ->addDocumentPositionProductClassification("ClassCode", "ClassName", "ListId", "ListVersionId")
    ->SetDocumentPositionGrossPrice(5.5000)
    ->SetDocumentPositionNetPrice(5.5000)
    ->SetDocumentPositionQuantity(50, "H87")
    ->AddDocumentPositionTax('S', 'VAT', 7)
    ->SetDocumentPositionLineSummation(275.0)
    ->addDocumentPaymentTerm("Fälligkeitsdatum: 05.12.24 ; Skonto 3% bis zum 19.11.24", \DateTime::createFromFormat("d.m.y", "19.11.24"))
    ->addDiscountTermsToPaymentTerms(3, \DateTime::createFromFormat("d.m.y", "05.11.24"), 14, "DAY", 2123.53, 63.71)
    ->writeFile(dirname(__FILE__) . "/factur-x.xml");
