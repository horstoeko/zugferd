<?php

use horstoeko\zugferd\quick\ZugferdQuickDescriptorEn16931;
use horstoeko\zugferd\codelists\ZugferdTextSubjectCodeQualifiers;

require getcwd() . "/../vendor/autoload.php";

$document = (ZugferdQuickDescriptorEn16931::doCreateNew())
    ->doCreateInvoice("471102", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->doSetPaymentTerms("Zahlbar sofort", new \DateTime('+3 days'))
    ->doAddNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->doAddNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, ZugferdTextSubjectCodeQualifiers::UNTDID_4451_REG)
    ->doSetBuyer("Kunden AG Mitte", "69876", "Frankfurt", "Lieferantenstraße 20", "DE", null)
    ->doSetBuyerContact("Hans Miller")
    ->doSetSeller("Lieferant GmbH", "80333", "München", "Lieferantenstraße 20", "DE", null, "4000001123452", "0088")
    ->doAddSellerTaxRegistration("FC", "201/113/40209")
    ->doAddSellerTaxRegistration("VA", "DE123456789")
    ->doAddTradeLineItem("2", "Papier", 100.0, 10.0, "C62", 0.0, "", "S", "VAT", 19.0)
    ->doAddTradeLineItem("3", "Strift", 100.0, 10.0, "C62", 0.0, "", "S", "VAT", 7.0)
    ->doAddTradeLineItemWithSurcharge("4", "Unterlagen", 100.0, 10.0, "Zeilenzuschlag", 10.0, "C62", "S", "VAT", 7.0)
    ->doAddTradeLineItemWithDiscount("5", "Reinigungstuecher", 100.0, 10.0, "Zeilenrabatt", 10.0, "C62", "S", "VAT", 7.0)
    ->doSetPrepaidAmount(100)
    ->doSetTotals()
    ->writeFile(getcwd() . "/factur-x.xml");
