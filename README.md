<!-- omit in toc -->
# ZUGFeRD/XRechnung/Factur-X

<!-- omit in toc -->
## Status

[![Latest Stable Version](https://img.shields.io/packagist/v/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)
[![PHP version](https://img.shields.io/packagist/php-v/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)
[![License](https://img.shields.io/packagist/l/horstoeko/zugferd.svg?style=plastic)](https://packagist.org/packages/horstoeko/zugferd)

[![Continuous Integration](https://github.com/horstoeko/zugferd/actions/workflows/build.ci.yml/badge.svg?branch=master)](https://github.com/horstoeko/zugferd/actions/workflows/build.ci.yml)
[![Release Status](https://github.com/horstoeko/zugferd/actions/workflows/build.release.yml/badge.svg)](https://github.com/horstoeko/zugferd/actions/workflows/build.release.yml)

> [!IMPORTANT]
> ## Zukunft / Nachfolger-Projekt
> Dieses Projekt hat lange gute Dienste geleistet, aber die Codebasis ist inzwischen in die Jahre gekommen – es ist Zeit für eine grundlegende Modernisierung.
>
> **Keine Sorge:** `horstoeko/zugferd` wird weiterhin betreut. Ich werde bestmöglich Bugfixes liefern und Pull Requests prüfen, sodass bestehende Anwender sich weiterhin darauf verlassen können.
>
> Parallel entsteht eine neue, modernere Codebasis. Sie wird einen **Legacy-Support** erhalten, damit die Migration für bestehende Nutzer so reibungslos wie möglich abläuft.
>
> Ich suche einfach **helfende Hände**, die mich wegen **Zeitmangels** bei der Weiterentwicklung und Pflege unterstützen können – ganz egal ob Code, Tests, Doku, Reviews, Beispiele, Issue-Triage oder einfach Feedback.
>
> **Kontakt (gern auch unverbindlich):** horstoeko-invoicesuite@erling.com.de
> Schreib kurz, wobei du unterstützen möchtest und wie viel Zeit du grob hast.

> [!IMPORTANT]
> ## Future / Successor project
> This project has served well for a long time, but the codebase is getting old and it’s time for a major modernization.
>
> **No worries:** `horstoeko/zugferd` will continue to be maintained. I will keep providing best-effort bugfixes and reviewing PRs so existing users can continue to rely on it.
>
> In parallel, a new, modern codebase is being built. It will include **legacy support** to make migration as smooth as possible for current users.
>
> I’m simply looking for **helping hands** because my time is limited — whether it’s code, tests, docs, reviews, examples, issue triage, or just feedback.
>
> **Contact (also just for an informal chat):** horstoeko-invoicesuite@erling.com.de
> Please share what you’d like to help with and roughly how much time you have.

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
