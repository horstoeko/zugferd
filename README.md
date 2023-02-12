# ZUGFeRD/XRechnung/Factur-X

[![Latest Stable Version](https://poser.pugx.org/horstoeko/zugferd/v/stable.png)](https://packagist.org/packages/horstoeko/zugferd) [![Total Downloads](https://poser.pugx.org/horstoeko/zugferd/downloads.png)](https://packagist.org/packages/horstoeko/zugferd) [![Latest Unstable Version](https://poser.pugx.org/horstoeko/zugferd/v/unstable.png)](https://packagist.org/packages/horstoeko/zugferd) [![License](https://poser.pugx.org/horstoeko/zugferd/license.png)](https://packagist.org/packages/horstoeko/zugferd) [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/horstoeko/zugferd)

A simple ZUGFeRD/XRechnung/Factur-X Library

With `horstoeko/zugferd` you can read and write xml files containing electronic invoice data in the basic-, EN16931- and Extended-Profile.

Information about...
* [ZUGFeRD](https://de.wikipedia.org/wiki/ZUGFeRD) (German)
* [XRechnung](https://de.wikipedia.org/wiki/XRechnung) (German)
* [Factur-X](http://fnfe-mpe.org/factur-x/factur-x_en) (France)

This package makes use of [JMS Serializer](http://jmsyst.com/libs/serializer), [Xsd2Php](https://github.com/goetas-webservices/xsd2php), [FPDF](https://github.com/Setasign/FPDF) and  [FPDI](https://github.com/Setasign/FPDI).

## Installation

There is one recommended way to install `horstoeko/zugferd` via [Composer](https://getcomposer.org/):

* adding the dependency to your ``composer.json`` file:

```js
  "require": {
      ..
      "horstoeko/zugferd":"^1",
      ..
  },
```

## Usage

For detailed eplanation you may have a look in the `examples` of this package and the documentation attached to every release.

### Reading a xml file

```php
  use horstoeko\zugferd\ZugferdDocumentReader;

  $document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/xml/factur-x.xml");

  $document ->getDocumentInformation($documentno,
     $documenttypecode, 
     $documentdate, 
     $duedate, 
     $invoiceCurrency, 
     $taxCurrency, 
     $documentname, 
     $documentlanguage,
     $effectiveSpecifiedPeriod)

  echo "The Invoice No. is {$documentno}" . PHP_EOL;
```

### Reading a pdf file with xml attachment

```php
  use horstoeko\zugferd\ZugferdDocumentPdfReader;

  $document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/xml/factur-x.pdf");

  $document ->getDocumentInformation($documentno,
     $documenttypecode, 
     $documentdate, 
     $duedate, 
     $invoiceCurrency, 
     $taxCurrency, 
     $documentname, 
     $documentlanguage,
     $effectiveSpecifiedPeriod)

  echo "The Invoice No. is {$documentno}" . PHP_EOL;
```

### Writing a xml file

```php
  use horstoeko\zugferd\ZugferdDocumentBuilder;
  use horstoeko\zugferd\ZugferdProfiles;

  // Create an empty invoice document in the EN16931 profile
  $document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);

  // Add invoice and position information
  $document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->addDocumentTax("S", "VAT", 275.0, 19.25, 7.0)
    ->addDocumentTax("S", "VAT", 198.0, 37.02, 19.0)
    ->setDocumentSummation(529.87, 529.87, 473.00, 0.0, 0.0, 473.00, 56.87, null, 0.0)
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Trennblätter A4", "", "TB100A4", null, "0160", "4012345001235")
    ->setDocumentPositionGrossPrice(9.9000)
    ->setDocumentPositionNetPrice(9.9000)
    ->setDocumentPositionQuantity(20, "H87")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(198.0)
    ->addNewPosition("2")
    ->setDocumentPositionProductDetails("Joghurt Banane", "", "ARNR2", null, "0160", "4000050986428")
    ->SetDocumentPositionGrossPrice(5.5000)
    ->SetDocumentPositionNetPrice(5.5000)
    ->SetDocumentPositionQuantity(50, "H87")
    ->AddDocumentPositionTax('S', 'VAT', 7)
    ->SetDocumentPositionLineSummation(275.0)
    ->writeFile(getcwd() . "/factur-x.xml");
```

### Writing a pdf file with attached xml file

```php
  use horstoeko\zugferd\ZugferdDocumentBuilder;
  use horstoeko\zugferd\ZugferdDocumentPdfBuilder;
  use horstoeko\zugferd\ZugferdProfiles;

  // Create an empty invoice document in the EN16931 profile
  $document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);

  // Add invoice and position information
  $document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->addDocumentTax("S", "VAT", 275.0, 19.25, 7.0)
    ->addDocumentTax("S", "VAT", 198.0, 37.02, 19.0)
    ->setDocumentSummation(529.87, 529.87, 473.00, 0.0, 0.0, 473.00, 56.87, null, 0.0)
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018")
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Trennblätter A4", "", "TB100A4", null, "0160", "4012345001235")
    ->setDocumentPositionGrossPrice(9.9000)
    ->setDocumentPositionNetPrice(9.9000)
    ->setDocumentPositionQuantity(20, "H87")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(198.0)
    ->addNewPosition("2")
    ->setDocumentPositionProductDetails("Joghurt Banane", "", "ARNR2", null, "0160", "4000050986428")
    ->SetDocumentPositionGrossPrice(5.5000)
    ->SetDocumentPositionNetPrice(5.5000)
    ->SetDocumentPositionQuantity(50, "H87")
    ->AddDocumentPositionTax('S', 'VAT', 7)
    ->SetDocumentPositionLineSummation(275.0)
    ->writeFile(getcwd() . "/factur-x.xml");

  $pdfBuilder = new ZugferdDocumentPdfBuilder($document, "/tmp/original.pdf");
  $pdfBuilder->generateDocument();
  $pdfBuilder->saveDocument("/tmp/new.pdf");
```

## Note 

The code in this project is provided under the [MIT](https://opensource.org/licenses/MIT) license. 
