<?php

use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilderWithCalculator;

require getcwd() . "/vendor/autoload.php";

$document = ZugferdDocumentBuilderWithCalculator::CreateNew(ZugferdProfiles::PROFILE_EN16931);
$document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->AddDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->AddDocumentNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, null, 'REG')
    ->SetDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->SetDocumentSeller("Lieferant GmbH", "549910")
    ->AddDocumentSellerGlobalId("4000001123452", "0088")
    ->AddDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->AddDocumentSellerTaxRegistration("VA", "DE123456789")
    ->SetDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->SetDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->SetDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->AddDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
    ->AddNewPosition("1")
    ->SetDocumentPositionProductDetails("Trennblätter A4", "", "TB100A4", null, "0160", "4012345001235")
    ->SetDocumentPositionGrossPrice(9.9000)
    ->SetDocumentPositionQuantity(20, "H87")
    ->AddDocumentPositionTax('S', 'VAT', 19)
    ->AddNewPosition("2")
    ->SetDocumentPositionProductDetails("Joghurt Banane", "", "ARNR2", null, "0160", "4000050986428")
    ->SetDocumentPositionGrossPrice(5.5000)
    ->SetDocumentPositionNetPrice(5.5000)
    ->SetDocumentPositionQuantity(50, "H87")
    ->AddDocumentPositionTax('S', 'VAT', 7)
    ->writeFile(getcwd() . "/factur-x.xml");
