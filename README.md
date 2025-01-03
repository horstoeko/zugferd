# ZUGFeRD/XRechnung/Factur-X

## Status

[![Latest Stable Version](https://img.shields.io/packagist/v/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)
[![PHP version](https://img.shields.io/packagist/php-v/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)
[![License](https://img.shields.io/packagist/l/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)

[![CI](https://github.com/horstoeko/zugferd/actions/workflows/build.ci.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.ci.yml)
[![Release Status](https://github.com/horstoeko/zugferd/actions/workflows/build.release.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.release.yml)

<!--
[![CI (Ant, PHP 7.3)](https://github.com/horstoeko/zugferd/actions/workflows/build.php73.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php73.ant.yml)
[![CI (Ant, PHP 7.4)](https://github.com/horstoeko/zugferd/actions/workflows/build.php74.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php74.ant.yml)
[![CI (PHP 8.0)](https://github.com/horstoeko/zugferd/actions/workflows/build.php80.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php80.ant.yml)
[![CI (PHP 8.1)](https://github.com/horstoeko/zugferd/actions/workflows/build.php81.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php81.ant.yml)
[![CI (PHP 8.2)](https://github.com/horstoeko/zugferd/actions/workflows/build.php82.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php82.ant.yml)
[![CI (PHP 8.3)](https://github.com/horstoeko/zugferd/actions/workflows/build.php83.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php83.ant.yml)
[![CI (PHP 8.4)](https://github.com/horstoeko/zugferd/actions/workflows/build.php84.ant.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.php84.ant.yml)
-->

## Latest information

> [!TIP]
> I would like to thank you very much for the great encouragement and the fantastic contributions on your part. I wish you all a successful new year 2025 and hope that all the work on this library shows its positive results.

## Table of Contents

- [ZUGFeRD/XRechnung/Factur-X](#zugferdxrechnungfactur-x)
  - [Status](#status)
  - [Latest information](#latest-information)
  - [Table of Contents](#table-of-contents)
  - [License](#license)
  - [Overview](#overview)
  - [Supported profiles](#supported-profiles)
  - [Further information](#further-information)
  - [Related projects](#related-projects)
  - [Dependencies](#dependencies)
  - [Resources](#resources)
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
* [ZUGFeRD Mail](https://github.com/horstoeko/zugferdmail)
* [Order-X](https://github.com/horstoeko/orderx)

## Dependencies

This package makes use of

- [JMS Serializer](http://jmsyst.com/libs/serializer)
- [Xsd2Php](https://github.com/goetas-webservices/xsd2php)
- [FPDF](https://github.com/Setasign/FPDF)
- [FPDI](https://github.com/Setasign/FPDI).

## Resources

- [Official documentaries (Version Archive)](https://www.ferd-net.de/ueber-uns/ressourcen-1/veroeffentlichungen)

## Installation

Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Installation).

## Usage

For detailed explanation you may have a look in the [examples](https://github.com/horstoeko/zugferd/tree/master/examples)
of this package, the documentation attached to every release or our [wiki](https://github.com/horstoeko/zugferd/wiki).

### Configuration

Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Configuration).

### Read a xml file

Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Reading-XML-Documents).

### Read a pdf file with attached xml file

Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Reading-PDF-Documents).

### Write a xml file

Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Creating-XML-Documents).

### Write a pdf file with attached xml file

Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Creating-PDF-Documents).

### Merge existing PDF and XML

Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Merging-XML-and-PDF-Documents).

### Validation

Please visit the corresponding page in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Validation).
