```php
$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);
$document->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR");
```