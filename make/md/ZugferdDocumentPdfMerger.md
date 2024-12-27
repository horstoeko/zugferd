### Example for merging an existing PDF file with an existing XML file

```php
use horstoeko\zugferd\ZugferdDocumentPdfMerger;

$existingXmlFile = "/tmp/invoice_1.xml";
$existingPdfFile = "/tmp/emptypdf.pdf";
$mergeToPdf = "/tmp/fullpdf.pdf";

if (!file_exists($existingXmlFile) || !file_exists($existingPdfFile)) {
    throw new \Exception("XML and/or PDF does not exist");
}

(new ZugferdDocumentPdfMerger($existingXmlFile, $existingPdfFile))
    ->generateDocument()
    ->saveDocument($mergeToPdf);
```

### Example for merging an existing PDF file with a string which contains the XML

```php
use horstoeko\zugferd\ZugferdDocumentPdfMerger;

$xmlString= "<xml>...</xml>";
$existingPdfFile = "/tmp/emptypdf.pdf";
$mergeToPdf = "/tmp/fullpdf.pdf";

if (!file_exists($existingPdfFile)) {
    throw new \Exception("XML and/or PDF does not exist");
}

(new ZugferdDocumentPdfMerger($xmlString, $existingPdfFile))
    ->generateDocument()
    ->saveDocument($mergeToPdf);
```

### Example for merging a string which contains a PDF with an existing XML file

```php
use horstoeko\zugferd\ZugferdDocumentPdfMerger;

$existingXmlFile = "/tmp/invoice_1.xml";
$pdfString = "%PDF-1.4.....";
$mergeToPdf = "/tmp/fullpdf.pdf";

if (!file_exists($existingXmlFile)) {
    throw new \Exception("XML and/or PDF does not exist");
}

(new ZugferdDocumentPdfMerger($existingXmlFile, $pdfString))
    ->generateDocument()
    ->saveDocument($mergeToPdf);
```

### Example for merging a string which contains a PDF with a string which contains the XML

```php
use horstoeko\zugferd\ZugferdDocumentPdfMerger;

$xmlString= "<xml>...</xml>";
$pdfString = "%PDF-1.4.....";
$mergeToPdf = "/tmp/fullpdf.pdf";

(new ZugferdDocumentPdfMerger($xmlString, $pdfString))
    ->generateDocument()
    ->saveDocument($mergeToPdf);
```
