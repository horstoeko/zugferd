```php

// Change the author of the generated (merged) PDF

// This method accepts a free text that can accept the following placeholders:
// - %1$s .... contains the invoice number (is extracted from the XML data)
// - %2$s .... contains the type of XML document, such as ‘Invoice’ (is extracted from the XML data)
// - %3$s .... contains the name of the seller (extracted from the XML data)
// - %4$s .... contains the invoice date (extracted from the XML data)

// The follwing example will generate: Issued by seller with name Lieferant GmbH

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->setAuthorTemplate('Issued by seller with name %3$s');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

```