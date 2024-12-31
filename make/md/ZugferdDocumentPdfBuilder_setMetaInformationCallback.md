```php

// Use a callback function to manipulate the meta information.

// The following 4 parameters are passed to the callback
// function in the specified order:
// - $which               .... one of "author", "title", "subject" and "keywords"
// - $xmlContent          .... the content of the xml as a string
// - $invoiceInformation  .... an array with some information about the invoice
// - $default             .... The default value for the specified field (see $which

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->setMetaInformationCallback(
    function ($which) {
        if ($which === 'title') {
            return "DummyTitle";
        }
        if ($which === 'author') {
            return "DummyAuthor";
        }
        if ($which === 'subject') {
            return "DummySubject";
        }
        if ($which === 'keywords') {
            return "DummyKeywords";
        }
    }
);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

```