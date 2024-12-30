```php
$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EN16931);
$document->setDocumentInformation('R-2024/00001', ZugferdInvoiceType::INVOICE, DateTime::createFromFormat("Ymd", "20241231"), ZugferdCurrencyCodes::EURO)
```