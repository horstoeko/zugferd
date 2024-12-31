```php

// Change the keywords of the generated (merged) PDF

// This method accepts a free text that can accept the following placeholders:
// - %1$s .... contains the invoice number (is extracted from the XML data)
// - %2$s .... contains the type of XML document, such as ‘Invoice’ (is extracted from the XML data)
// - %3$s .... contains the name of the seller (extracted from the XML data)
// - %4$s .... contains the invoice date (extracted from the XML data)

// The follwing example will generate: R-2024/00001, Invoice, Lieferant GmbH, 2024-12-31

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->setKeywordTemplate('%1$s, %2$s, %3$s, %4$s');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

```