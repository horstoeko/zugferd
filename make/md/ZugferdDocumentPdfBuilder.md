```php

use horstoeko\zugferd\codelists\ZugferdCurrencyCodes;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentPdfBuilderAbstract;
use horstoeko\zugferd\ZugferdDocumentPdfBuilder;
use horstoeko\zugferd\ZugferdProfiles;

// Build the XML using ZugferdDocumentBuilder

$zugferdDocumentBuilder = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);
$zugferdDocumentBuilder
    ->setDocumentInformation('R-2024/00001', ZugferdInvoiceType::INVOICE, DateTime::createFromFormat('Ymd', '20241231'), ZugferdCurrencyCodes::EURO)
    ->......

// Create a PDF using the XML content from ZugferdDocumentBuilder and an existing print-output file

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

// Create a PDF using the XML content from ZugferdDocumentBuilder and a print-content stream (string)

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfString($documentBuilder, '%PDF-1.5...........');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

// Alternatively, you can also return the merged output as a content stream (string)

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->generateDocument();
$pdfBinaryString = $zugferdDocumentPdfBuilder->generateDocument()->downloadString();

// If you would like to brand the merged PDF with the name of you own solution you can call
// the method setAdditionalCreatorTool. Before calling this method the creator of the PDF is identified as 'Factur-X library 1.x.x by HorstOeko'.
// After calling this method you get 'MyERPSolution 1.0 / Factur-X PHP library 1.x.x by HorstOeko' as the creator

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->setAdditionalCreatorTool('MyERPSolution 1.0');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

// It is also possible to add additional attachments to the merged PDF. These can be any files that can help the invoice
// recipient with processing. For example, a time sheet as an Excel file would be conceivable.

// The method attachAdditionalFileByRealFile has 3 parameters:
// - The file to attach which must exist and must be readable
// - (Optional) A name to display in the attachments of the PDF
// - (Optional) The type of the relationship of the attachment. Valid values are defined in the class
// ZugferdDocumentPdfBuilderAbstract. The constants are starting with AF_
//
// If you omit the last 2 parameters the following will happen:
// - The displayname is calculated from the filename you specified
// - The type of the relationship of the attachment will be AF_RELATIONSHIP_SUPPLEMENT (Supplement)

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->attachAdditionalFileByRealFile('/path/to/existing.file', "Some display Name", ZugferdDocumentPdfBuilderAbstract::AF_RELATIONSHIP_SUPPLEMENT);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

// You can also add an attachment to the PDF as an stream (string). The conditions are the same as above for the attachAdditionalFileByRealFile method
// The only difference to attachAdditionalFileByRealFile is that the attachAdditionalFileByContent method accepts 4 parameters, whereby here (as with attachAdditionalFileByRealFile)
// the last two can be omitted. You only need to specify a file name under which the file is to be embedded

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->attachAdditionalFileByContent('<xml>....</xml>', 'additionalDocument.csv', "Some other display Name", ZugferdDocumentPdfBuilderAbstract::AF_RELATIONSHIP_SUPPLEMENT);
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

// We can change some meta information such as the title, the subject, the author and the keywords. This library essentially provides 4 methods for this:
// - setAuthorTemplate
// - setTitleTemplate
// - setSubjectTemplate
// - setKeywordTemplate
// The 4 methods just mentioned accept a free text that can accept the following placeholders:
// - %1$s .... contains the invoice number (is extracted from the XML data)
// - %2$s .... contains the type of XML document, such as ‘Invoice’ (is extracted from the XML data)
// - %3$s .... contains the name of the seller (extracted from the XML data)
// - %4$s .... contains the invoice date (extracted from the XML data)
// The following example would generate...
// - the author:  .... Issued by seller with name Lieferant GmbH
// - the title    .... Lieferant GmbH : Invoice R-2024/00001
// - the subject  .... Invoice-Document, Issued by Lieferant GmbH
// - the keywords .... R-2024/00001, Invoice, Lieferant GmbH, 2024-12-31

$zugferdDocumentPdfBuilder = ZugferdDocumentPdfBuilder::fromPdfFile($zugferdDocumentBuilder, '/tmp/existingprintlayout.pdf');
$zugferdDocumentPdfBuilder->setAuthorTemplate('Issued by seller with name %3$s');
$zugferdDocumentPdfBuilder->setTitleTemplate('%3$s : %2$s %1$s');
$zugferdDocumentPdfBuilder->setSubjectTemplate('%2$s-Document, Issued by %3$s');
$zugferdDocumentPdfBuilder->setKeywordTemplate('%1$s, %2$s, %3$s, %4$s');
$zugferdDocumentPdfBuilder->generateDocument();
$zugferdDocumentPdfBuilder->saveDocument('/tmp/merged.pdf');

// If the previously mentioned options for manipulating the meta information are not sufficient,
// you can also use a callback function. The following 4 parameters are passed to the callback
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
