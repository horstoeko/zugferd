# ZUGFeRD/XRechnung/Factur-X

> [!NOTE]
> Dear Community!
>
> I would be delighted to hear from you where you use this library. If you would like to, please specify the company and the specific purpose. Send your messages to iusezugferd@erling.com.de. I would be happy to learn more about the type of use from you.

## Status

[![Latest Stable Version](https://img.shields.io/packagist/v/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)
[![PHP version](https://img.shields.io/packagist/php-v/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)
[![License](https://img.shields.io/packagist/l/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)

<!--
[![CI](https://github.com/horstoeko/zugferd/actions/workflows/build.ci.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.ci.yml)
-->

[![CI (Ant, PHP 7.3)](https://github.com/horstoeko/zugferd/actions/workflows/build.php73.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php73.ant.yml)
[![CI (Ant, PHP 7.4)](https://github.com/horstoeko/zugferd/actions/workflows/build.php74.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php74.ant.yml)
[![CI (PHP 8.0)](https://github.com/horstoeko/zugferd/actions/workflows/build.php80.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php80.ant.yml)
[![CI (PHP 8.1)](https://github.com/horstoeko/zugferd/actions/workflows/build.php81.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php81.ant.yml)
[![CI (PHP 8.2)](https://github.com/horstoeko/zugferd/actions/workflows/build.php82.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php82.ant.yml)
[![CI (PHP 8.3)](https://github.com/horstoeko/zugferd/actions/workflows/build.php83.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php83.ant.yml)


## Table of Contents

- [ZUGFeRD/XRechnung/Factur-X](#zugferdxrechnungfactur-x)
  - [Table of Contents](#table-of-contents)
  - [License](#license)
  - [Overview](#overview)
  - [Supported profiles](#supported-profiles)
  - [Further information](#further-information)
  - [Related projects](#related-projects)
  - [Dependencies](#dependencies)
  - [Our Wiki](#our-wiki)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Configuration](#configuration)
    - [Reading a xml file](#reading-a-xml-file)
    - [Reading a pdf file with xml attachment](#reading-a-pdf-file-with-xml-attachment)
    - [Writing a xml file](#writing-a-xml-file)
    - [Writing a pdf file with attached xml file](#writing-a-pdf-file-with-attached-xml-file)
    - [Merge existing PDF and XML](#merge-existing-pdf-and-xml)
    - [Validation](#validation)

## License

The code in this project is provided under the [MIT](https://opensource.org/licenses/MIT) license.

## Overview

With `horstoeko/zugferd` you can read and write xml files containing electronic invoice data in the Minimum-, Basic-, EN16931-, Extended- and XRechnung Profile. In addition, it is possible to attach the XML data to an existing PDF file, which was created from an ERP system, for example. If both an XML file (or XML string) and a PDF file (or a PDF in the form of a string) exist, then a compliant PDF file with attachment can be created using the `ZugferdDocumentPdfMerger` class.

**The advantage of this library is that you don't have to worry about whether a particular XML element exists in a desired profile - you can use the same program code for all supported profiles.**

## Supported profiles

- EN16931 Minimum
- EN16931 Basic
- EN16931 Basic WL
- EN16931 Comfort
- EN16931 Extended
- EN16931 XRechnung 1.x
- EN16931 XRechnung 2.x
- EN16931 XRechnung 3.x

> [!IMPORTANT]
> This package provides only support for CII-Syntax - not UBL-Syntax

## Further information

* [ZUGFeRD](https://de.wikipedia.org/wiki/ZUGFeRD) (German)
* [XRechnung](https://de.wikipedia.org/wiki/XRechnung) (German)
* [Factur-X](http://fnfe-mpe.org/factur-x/factur-x_en) (France)

## Related projects

* [ZUGFeRD Visualizer](https://github.com/horstoeko/zugferdvisualizer)
* [ZUGFeRD Laravel](https://github.com/horstoeko/zugferd-laravel)
* [ZUGFeRD UBL Bridge](https://github.com/horstoeko/zugferdublbridge)
* [Order-X](https://github.com/horstoeko/orderx)

## Dependencies

This package makes use of

- [JMS Serializer](http://jmsyst.com/libs/serializer)
- [Xsd2Php](https://github.com/goetas-webservices/xsd2php)
- [FPDF](https://github.com/Setasign/FPDF)
- [FPDI](https://github.com/Setasign/FPDI).

## Our Wiki

We offer you a wiki that is currently under construction. This wiki lives from your questions, but also from your cooperation. If you find that something is unclear or not described at all during your work with this library, please let us know.

[You can find our Wiki here...](https://github.com/horstoeko/zugferd/wiki)

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

For detailed eplanation you may have a look in the [examples](https://github.com/horstoeko/zugferd/tree/master/examples) of this package and the documentation attached to every release.

### Configuration

This library can be configured in various ways. For more information please visit our [Wiki](https://github.com/horstoeko/zugferd/wiki/Configuration).

### Reading a xml file

The central entry point to read XML data is the class `ZugferdDocumentReader`. Among other things, this provides methods for reading header and line information, as can be seen in the following example:

```php
use horstoeko\zugferd\ZugferdDocumentReader;

$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/xml/factur-x.xml");

$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);

echo "\r\nGeneral document information\r\n";
echo "----------------------------------------------------------------------\r\n";
echo "Profile:               {$document->getProfileDefinitionParameter("name")}\r\n";
echo "Profile:               {$document->getProfileDefinitionParameter("altname")}\r\n";
echo "Document No:           {$documentno}\r\n";
echo "Document Type:         {$documenttypecode}\r\n";
echo "Document Date:         {$documentdate->format("Y-m-d")}\r\n";
echo "Invoice currency:      {$invoiceCurrency}\r\n";
echo "Tax currency:          {$taxCurrency}\r\n";

if ($document->firstDocumentPosition()) {
    echo "\r\nDocument positions\r\n";
    echo "----------------------------------------------------------------------\r\n";
    do {
        $document->getDocumentPositionGenerals($lineid, $linestatuscode, $linestatusreasoncode);
        $document->getDocumentPositionProductDetails($prodname, $proddesc, $prodsellerid, $prodbuyerid, $prodglobalidtype, $prodglobalid);
        $document->getDocumentPositionGrossPrice($grosspriceamount, $grosspricebasisquantity, $grosspricebasisquantityunitcode);
        $document->getDocumentPositionNetPrice($netpriceamount, $netpricebasisquantity, $netpricebasisquantityunitcode);
        $document->getDocumentPositionLineSummation($lineTotalAmount, $totalAllowanceChargeAmount);
        $document->getDocumentPositionQuantity($billedquantity, $billedquantityunitcode, $chargeFreeQuantity, $chargeFreeQuantityunitcode, $packageQuantity, $packageQuantityunitcode);

        echo " - Line Id:                        {$lineid}\r\n";
        echo " - Product Name:                   {$prodname}\r\n";
        echo " - Product Description:            {$proddesc}\r\n";
        echo " - Product Buyer ID:               {$prodbuyerid}\r\n";
        echo " - Product Gross Price:            {$grosspriceamount}\r\n";
        echo " - Product Gross Price Basis Qty.: {$grosspricebasisquantity} {$grosspricebasisquantityunitcode}\r\n";
        echo " - Product Net Price:              {$netpriceamount}\r\n";
        echo " - Product Net Price Basis Qty.:   {$netpricebasisquantity} {$netpricebasisquantityunitcode}\r\n";
        echo " - Quantity:                       {$billedquantity} {$billedquantityunitcode}\r\n";
        echo " - Line amount:                    {$lineTotalAmount}\r\n";

        if ($document->firstDocumentPositionTax()) {
            echo " - Position Tax(es)\r\n";
            do {
                $document->getDocumentPositionTax($categoryCode, $typeCode, $rateApplicablePercent, $calculatedAmount, $exemptionReason, $exemptionReasonCode);
                echo "   - Tax category code:            {$categoryCode}\r\n";
                echo "   - Tax type code:                {$typeCode}\r\n";
                echo "   - Tax percent:                  {$rateApplicablePercent}\r\n";
                echo "   - Tax amount:                   {$calculatedAmount}\r\n";
            } while ($document->nextDocumentPositionTax());
        }

        if ($document->firstDocumentPositionAllowanceCharge()) {
            echo " - Position Allowance(s)/Charge(s)\r\n";
            do {
                $document->getDocumentPositionAllowanceCharge($actualAmount, $isCharge, $calculationPercent, $basisAmount, $reason, $taxTypeCode, $taxCategoryCode, $rateApplicablePercent, $sequence, $basisQuantity, $basisQuantityUnitCode, $reasonCode);
                echo "   - Information\r\n";
                echo "     - Actual Amount:                {$actualAmount}\r\n";
                echo "     - Type:                         " . ($isCharge ? "Charge" : "Allowance") . "\r\n";
                echo "     - Tax category code:            {$taxCategoryCode}\r\n";
                echo "     - Tax type code:                {$taxTypeCode}\r\n";
                echo "     - Tax percent:                  {$rateApplicablePercent}\r\n";
                echo "     - Calculated percent:           {$calculationPercent}\r\n";
                echo "     - Basis amount:                 {$basisAmount}\r\n";
                echo "     - Basis qty.:                   {$basisQuantity} {$basisQuantityUnitCode}\r\n";
            } while ($document->nextDocumentPositionAllowanceCharge());
        }

        echo "\r\n";
    } while ($document->nextDocumentPosition());
}

if ($document->firstDocumentAllowanceCharge()) {
    echo "\r\nDocument allowance(s)/charge(s)\r\n";
    echo "----------------------------------------------------------------------\r\n";
    do {
        $document->getDocumentAllowanceCharge($actualAmount, $isCharge, $taxCategoryCode, $taxTypeCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        echo "   - Information\r\n";
        echo "     - Actual Amount:                {$actualAmount}\r\n";
        echo "     - Type:                         " . ($isCharge ? "Charge" : "Allowance") . "\r\n";
        echo "     - Tax category code:            {$taxCategoryCode}\r\n";
        echo "     - Tax type code:                {$taxTypeCode}\r\n";
        echo "     - Tax percent:                  {$rateApplicablePercent}\r\n";
        echo "     - Calculated percent:           {$calculationPercent}\r\n";
        echo "     - Basis amount:                 {$basisAmount}\r\n";
        echo "     - Basis qty.:                   {$basisQuantity} {$basisQuantityUnitCode}\r\n";
    } while ($document->nextDocumentAllowanceCharge());
}

if ($document->firstDocumentTax()) {
    echo "\r\nDocument tax\r\n";
    echo "----------------------------------------------------------------------\r\n";
    do {
        $document->getDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        echo "   - Information\r\n";
        echo "     - Tax category code:            {$categoryCode}\r\n";
        echo "     - Tax type code:                {$typeCode}\r\n";
        echo "     - Basis amount:                 {$basisAmount}\r\n";
        echo "     - Line total Basis amount:      {$lineTotalBasisAmount}\r\n";
        echo "     - Tax percent:                  {$rateApplicablePercent}\r\n";
        echo "     - Tax amount:                   {$calculatedAmount}\r\n";
    } while ($document->nextDocumentTax());
}

$document->getDocumentSummation($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);

echo "\r\nDocument summation\r\n";
echo "----------------------------------------------------------------------\r\n";

echo "  - Line total amount                {$lineTotalAmount}\r\n";
echo "  - Charge total amount              {$chargeTotalAmount}\r\n";
echo "  - Allowance total amount           {$allowanceTotalAmount}\r\n";
echo "  - Tax basis total amount           {$taxBasisTotalAmount}\r\n";
echo "  - Tax total amount                 {$taxTotalAmount}\r\n";
echo "  - Grant total amount               {$grandTotalAmount}\r\n";
echo "  - Due payable amount               {$duePayableAmount}\r\n";
```

### Reading a pdf file with xml attachment

Reading invoice data from a PDF is similar: you just need to use the `ZugferdDocumentPdfReader` class instead of `ZugferdDocumentReader`:

```php
  use horstoeko\zugferd\ZugferdDocumentPdfReader;

  $document = ZugferdDocumentPdfReader::readAndGuessFromFile(dirname(__FILE__) . "/xml/factur-x.pdf");
```

The further reading of the invoice data is then identical with [Reading a xml file](#reading-a-xml-file)

### Writing a xml file

The `ZugferdDocumentBuilder` class is again the central entry point to generate compliant XML data:

```php
  use horstoeko\zugferd\ZugferdDocumentBuilder;
  use horstoeko\zugferd\ZugferdProfiles;

  // Create an empty invoice document in the EN16931 profile
  $document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);

  // Add invoice and position information
  $document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->setDocumentBusinessProcess('urn:fdc:peppol.eu:2017:poacc:billing:01:1.0')
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentSellerCommunication('EM', 'info@seller.com')
    ->setDocumentSellerContact('Horst Oeko', 'Financials', '0800-5726252', '0800-5726252', 'oeko@seller.com')
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->setDocumentBuyerCommunication('EM', 'info@buyer.com')
    ->addDocumentPaymentMeanToDirectDebit('DE02120300000000202051', '471102')
    ->setDocumentBuyerReference('04011000-12345ABCXYZ-86')
    ->addDocumentTax("S", "VAT", 275.0, 19.25, 7.0)
    ->addDocumentTax("S", "VAT", 198.0, 37.62, 19.0)
    ->setDocumentSummation(529.87, 529.87, 473.00, 0.0, 0.0, 473.00, 56.87, null, 0.0)
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018", null, '549910')
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Trennblätter A4", "", "TB100A4", null, "0160", "4012345001235")
    ->setDocumentPositionNetPrice(9.9000)
    ->setDocumentPositionQuantity(20, "H87")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(198.0)
    ->addNewPosition("2")
    ->setDocumentPositionProductDetails("Joghurt Banane", "", "ARNR2", null, "0160", "4000050986428")
    ->SetDocumentPositionNetPrice(5.5000)
    ->SetDocumentPositionQuantity(50, "H87")
    ->AddDocumentPositionTax('S', 'VAT', 7)
    ->SetDocumentPositionLineSummation(275.0)
    ->writeFile(dirname(__FILE__) . "/factur-x.xml");
```

### Writing a pdf file with attached xml file

Use the class ```ZugferdDocumentPdfBuilder``` if you already have an existing print output of the invoice (for example from an ERP system) and want to add an XML data stream to the existing PDF:


```php
  use horstoeko\zugferd\ZugferdDocumentBuilder;
  use horstoeko\zugferd\ZugferdDocumentPdfBuilder;
  use horstoeko\zugferd\ZugferdProfiles;

  // Create an empty invoice document in the EN16931 profile
  $document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);

  // Add invoice and position information
  $document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->setDocumentBusinessProcess('urn:fdc:peppol.eu:2017:poacc:billing:01:1.0')
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentSellerCommunication('EM', 'info@seller.com')
    ->setDocumentSellerContact('Horst Oeko', 'Financials', '0800-5726252', '0800-5726252', 'oeko@seller.com')
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->setDocumentBuyerCommunication('EM', 'info@buyer.com')
    ->addDocumentPaymentMeanToDirectDebit('DE02120300000000202051', '471102')
    ->setDocumentBuyerReference('04011000-12345ABCXYZ-86')
    ->addDocumentTax("S", "VAT", 275.0, 19.25, 7.0)
    ->addDocumentTax("S", "VAT", 198.0, 37.62, 19.0)
    ->setDocumentSummation(529.87, 529.87, 473.00, 0.0, 0.0, 473.00, 56.87, null, 0.0)
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018", null, '549910')
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Trennblätter A4", "", "TB100A4", null, "0160", "4012345001235")
    ->setDocumentPositionNetPrice(9.9000)
    ->setDocumentPositionQuantity(20, "H87")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(198.0)
    ->addNewPosition("2")
    ->setDocumentPositionProductDetails("Joghurt Banane", "", "ARNR2", null, "0160", "4000050986428")
    ->SetDocumentPositionNetPrice(5.5000)
    ->SetDocumentPositionQuantity(50, "H87")
    ->AddDocumentPositionTax('S', 'VAT', 7)
    ->SetDocumentPositionLineSummation(275.0);

  // Save merged PDF (existing original and XML) to a file
  $pdfBuilder = new ZugferdDocumentPdfBuilder($document, "/tmp/existingprintlayout.pdf");
  $pdfBuilder->generateDocument()->saveDocument("/tmp/merged.pdf");

  // Alternatively, you can also return the merged output (existing original and XML) as a binary string
  $pdfBuilder = new ZugferdDocumentPdfBuilder($document, "/tmp/existingprintlayout.pdf");
  $pdfBinaryString = $pdfBuilder->generateDocument()->downloadString("merged.pdf");
```

### Merge existing PDF and XML

Let's assume we already have a compliant XML (for example in the Comfort profile) and a PDF that already contains the print layout. Then it is possible to merge these two files into a compliant PDF (with XML attachment) using the class ```ZugferdDocumentPdfMerger```.

```php
use horstoeko\zugferd\ZugferdDocumentPdfMerger;

require dirname(__FILE__) . "/../vendor/autoload.php";

$existingXml = dirname(__FILE__) . "/invoice_1.xml";
$existingPdf = dirname(__FILE__) . "/emptypdf.pdf";
$mergeToPdf = dirname(__FILE__) . "/fullpdf.pdf";

if (!file_exists($existingXml) || !file_exists($existingPdf)) {
    throw new \Exception("XML and/or PDF does not exist");
}

(new ZugferdDocumentPdfMerger($existingXml, $existingPdf))->generateDocument()->saveDocument($mergeToPdf);
```

XML and/or PDF do not have to be available as a file. Strings containing the corresponding data can also be passed to the ZugferdDocumentPdfMerger class.

```php
use horstoeko\zugferd\ZugferdDocumentPdfMerger;

require dirname(__FILE__) . "/../vendor/autoload.php";

$existingXml = "<xml>,,,,,</xml>";
$existingPdf = "%PDF-1.5...........";
$mergeToPdf = dirname(__FILE__) . "/fullpdf.pdf";

(new ZugferdDocumentPdfMerger($existingXml, $existingPdf))->generateDocument()->saveDocument($mergeToPdf);
```

### Validation

This library offers several options for checking and validating a document. Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Validation).
