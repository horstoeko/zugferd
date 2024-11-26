<?php

use horstoeko\zugferd\quick\ZugferdQuickDescriptorXRechnung3;
use horstoeko\zugferd\codelists\ZugferdTextSubjectCodeQualifiers;

require dirname(__FILE__) . "/../vendor/autoload.php";

$document = (ZugferdQuickDescriptorXRechnung3::doCreateNew())
    ->doCreateInvoice("471102", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->doSetSupplyChainEvent(new \DateTime())
    ->doSetPaymentTerms("Zahlbar sofort", new \DateTime('+3 days'))
    ->doAddNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->doAddNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, ZugferdTextSubjectCodeQualifiers::UNTDID_4451_REG)
    ->doSetBuyer("Kunden AG Mitte", "69876", "Frankfurt", "Lieferantenstraße 20", "DE", "34676-342323")
    ->doSetBuyerContact("Hans Miller")
    ->doSetBuyerElectronicCommunication("kunde@kunde.de")
    ->doSetSeller("Lieferant GmbH", "80333", "München", "Lieferantenstraße 20", "DE", null, "4000001123452", "0088")
    ->doAddSellerTaxRegistration("FC", "201/113/40209")
    ->doAddSellerTaxRegistration("VA", "DE123456789")
    ->doSetSellerContact("Horst Meier", null, "horst@nowhere.all", "+49-0000-8888888")
    ->doSetSellerElectronicCommunication("lieferant@lieferant.de")
    ->doAddTradeLineItem("1", "Zitronensäure 100ml", 1.0, 100.0, "H87", 0.0, "", "S", "VAT", 19.0)
    ->doAddTradeLineItem("2", "Gelierzucker Extra 250g", 1.45, 50.0, "H87", 0.0, "", "S", "VAT", 7.0)
    ->doAddTradeLineItem("3", "Gelierzucker Extra 250g", 0.0, 10.0, "H87", 0.0, "", "S", "VAT", 7.0)
    ->doSetDocumentPositionNote("Artikel wie vereinbart ohne Berechnung")
    ->doAddTradeLineItem("4", "Bierbrau Pils 20/0500", 12.0, 15.0, "XBC", 0.0, "", "S", "VAT", 19.0)
    ->doAddTradeLineItem("5", "Leergutpfand 20 x 0,5l", 3.10, 15.0, "C62", 0.0, "", "S", "VAT", 19.0)
    ->doAddTradeLineItem("6", "Mischpalette Joghurt Karton 3 x 20", 29.10, 2.0, "C62", 0.0, "", "S", "VAT", 7.0)
    ->doSetPaymentMeansForCreditTransfer(true, "DE12500105170648489890")
    ->doAddTradeAllowanceCharge(-5.60, "Rechnungsrabatt 1", "S", "VAT", 19.0)
    ->doAddTradeAllowanceCharge(-2.61, "Rechnungsrabatt 1", "S", "VAT", 7.0)
    ->doAddTradeAllowanceCharge(-2.50, "Rechnungsrabatt 2", "S", "VAT", 19.0)
    ->doAddTradeAllowanceCharge(-0.50, "Rechnungsrabatt 2", "S", "VAT", 7.0)
    ->writeFile(dirname(__FILE__) . "/factur-x.xml");
