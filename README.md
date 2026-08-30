<!-- omit in toc -->
# ZUGFeRD/XRechnung/Factur-X

<!-- omit in toc -->
## Status

[![Latest Stable Version](https://img.shields.io/packagist/v/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)
[![PHP version](https://img.shields.io/packagist/php-v/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)
[![License](https://img.shields.io/packagist/l/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)

[![Continuous Integration](https://github.com/horstoeko/zugferd/actions/workflows/build.ci.yml/badge.svg?branch=master)](https://github.com/horstoeko/zugferd/actions/workflows/build.ci.yml)
[![Release Status](https://github.com/horstoeko/zugferd/actions/workflows/build.release.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.release.yml)

<!-- omit in toc -->
## Searching for contributors

<!-- omit in toc -->
## Projektstatus und offizieller Nachfolger

> [!IMPORTANT]
> `horstoeko/zugferd` wurde technisch umfassend modernisiert. Die Entwicklungsinfrastruktur, CI- und Release-Workflows, Nightly-Builds, Tests sowie die automatisierten Qualitätsprüfungen mit PHPStan, PHP-CS-Fixer und Rector wurden aktualisiert und vereinheitlicht. Die Bibliothek bleibt für bestehende Projekte verfügbar und wird weiterhin gepflegt.
>
> **Diese Modernisierung ändert nichts an der strategischen Ausrichtung: Der offizielle Nachfolger und Schwerpunkt der zukünftigen Weiterentwicklung ist [horstoeko/invoicesuite](https://github.com/horstoeko/invoicesuite). Für neue Projekte wird ausdrücklich InvoiceSuite empfohlen.**
>
> InvoiceSuite bietet eine moderne, erweiterbare Architektur für verschiedene Formate und Syntaxen elektronischer Rechnungen – darunter ZUGFeRD, Factur-X und XRechnung in CII und UBL. Die enthaltene [Legacy-Kompatibilität](https://github.com/horstoeko/invoicesuite/wiki/Legacy-support) erleichtert die Migration bestehender Anwendungen von `horstoeko/zugferd`.
>
> Bestehende Anwendungen müssen nicht sofort migriert werden. Bei neuen Implementierungen oder größeren Weiterentwicklungen sollte jedoch InvoiceSuite als Grundlage verwendet werden.

<!-- omit in toc -->
## Project status and official successor

> [!IMPORTANT]
> `horstoeko/zugferd` has undergone extensive technical modernization. The development infrastructure, CI and release workflows, nightly builds, tests, and automated quality checks using PHPStan, PHP-CS-Fixer, and Rector have been updated and standardized. The library remains available and maintained for existing projects.
>
> **This modernization does not change the strategic direction: The official successor and primary focus of future development is [horstoeko/invoicesuite](https://github.com/horstoeko/invoicesuite). InvoiceSuite is strongly recommended for all new projects.**
>
> InvoiceSuite provides a modern, extensible architecture for different electronic invoice formats and syntaxes, including ZUGFeRD, Factur-X, and XRechnung in both CII and UBL. Its [legacy compatibility layer](https://github.com/horstoeko/invoicesuite/wiki/Legacy-support) facilitates the migration of existing applications from `horstoeko/zugferd`.
>
> Existing applications do not need to migrate immediately. However, InvoiceSuite should be used as the foundation for new implementations and major future developments.

<!-- omit in toc -->
## Table of Contents

- [License](#license)
- [Overview](#overview)
- [Supported profiles](#supported-profiles)
- [Further information](#further-information)
- [Related projects](#related-projects)
- [Dependencies](#dependencies)
- [Resources](#resources)
- [Guide](#guide)

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
* [Awesome e-Invoicing](https://github.com/facturxapi/awesome-einvoicing) (EN 16931 / Factur-X / ZUGFeRD)

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

## Guide

For detailed explanation you may have a look in the [examples](https://github.com/horstoeko/zugferd/tree/master/examples)
of this package, the documentation attached to every release or our [wiki](https://github.com/horstoeko/zugferd/wiki).

The following parts are documentated in our [Wiki](https://github.com/horstoeko/zugferd/wiki/Configuration):

- [Installation](https://github.com/horstoeko/zugferd/wiki/Installation)
- [Configuration](https://github.com/horstoeko/zugferd/wiki/Configuration)
- [Read a xml file](https://github.com/horstoeko/zugferd/wiki/Reading-XML-Documents)
- [Read a pdf file with attached xml file](https://github.com/horstoeko/zugferd/wiki/Reading-PDF-Documents)
- [Write a xml file](https://github.com/horstoeko/zugferd/wiki/Creating-XML-Documents)
- [Write a pdf file with attached xml file file](https://github.com/horstoeko/zugferd/wiki/Creating-PDF-Documents)
- [Merge existing PDF and XML](https://github.com/horstoeko/zugferd/wiki/Merging-XML-and-PDF-Documents)
- [Validation](https://github.com/horstoeko/zugferd/wiki/Validation)
