```php

// The method attachAdditionalFileByRealFile has 3 parameters:
// - The file to attach which must exist and must be readable
// - (Optional) A name to display in the attachments of the PDF
// - (Optional) The type of the relationship of the attachment. Valid values are defined in the class
//   ZugferdDocumentPdfBuilderAbstract. The constants are starting with AF_
//
// If you omit the last 2 parameters the following will happen:
// - The displayname is calculated from the filename you specified
// - The type of the relationship of the attachment will be AF_RELATIONSHIP_SUPPLEMENT (Supplement)

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->attachAdditionalFileByRealFile('/path/to/existing.file', "Some display Name", ZugferdDocumentPdfBuilderAbstract::AF_RELATIONSHIP_SUPPLEMENT);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

```