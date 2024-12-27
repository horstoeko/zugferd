### Validation of a document read by ZugferdDocumentPdfReader

```php
$kositValidator = new ZugferdKositValidator();

$document = ZugferdDocumentPdfReader::readAndGuessFromFile("/tmp/invoice.pdf");
$kositValidator->setDocument($document)->disableCleanup()->validate();

if ($kositValidator->hasValidationErrors()) {
    echo "Validation failed";
    foreach ($kositValidator->getValidationErrors() as $validationError) {
        echo " - " . $validationError . PHP_EOL;
    }
} else {
    echo "mValidation passed";
}
```

### Validation of a document read by ZugferdDocumentReader

```php
$kositValidator = new ZugferdKositValidator();

$document = ZugferdDocumentReader::readAndGuessFromFile("/tmp/factur-x.xml");
$kositValidator->setDocument($document)->disableCleanup()->validate();

if ($kositValidator->hasValidationErrors()) {
    echo "Validation failed";
    foreach ($kositValidator->getValidationErrors() as $validationError) {
        echo " - " . $validationError . PHP_EOL;
    }
} else {
    echo "mValidation passed";
}
```
