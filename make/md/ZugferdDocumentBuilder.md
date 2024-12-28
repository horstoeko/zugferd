```php
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\codelists\ZugferdPaymentMeans;

require dirname(__FILE__) . "/../vendor/autoload.php";

$document = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EN16931);
$document
    ->setDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
    ->setDocumentBusinessProcess('urn:fdc:peppol.eu:2017:poacc:billing:01:1.0')
    ->addDocumentNote('Rechnung gemäß Bestellung vom 01.03.2018.')
    ->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', '20180305'))
    ->setDocumentSeller("Lieferant GmbH", "549910")
    ->addDocumentSellerGlobalId("4000001123452", "0088")
    ->addDocumentSellerTaxRegistration("FC", "201/113/40209")
    ->addDocumentSellerTaxRegistration("VA", "DE123456789")
    ->setDocumentSellerAddress("Lieferantenstraße 20", "", "", "80333", "München", "DE")
    ->setDocumentSellerCommunication('EM', 'info@seller.com')
    ->setDocumentSellerContact('Horst Oeko', 'Financials', '0800-5726252', '0800-5726252', 'oeko@seller.com')
    ->setDocumentBuyer("Kunden AG Mitte", "GE2020211")
    ->setDocumentBuyerAddress("Kundenstraße 15", "", "", "69876", "Frankfurt", "DE")
    ->setDocumentBuyerCommunication('EM', 'info@buyer.com')
    ->addDocumentPaymentMeanToDirectDebit('DE02120300000000202051', '471102')
    ->setDocumentBuyerReference('04011000-12345ABCXYZ-86')
    ->addDocumentTax("S", "VAT", 275.0, 19.25, 7.0)
    ->addDocumentTax("S", "VAT", 198.0, 37.62, 19.0)
    ->setDocumentSummation(529.87, 529.87, 473.00, 0.0, 0.0, 473.00, 56.87, null, 0.0)
    ->addDocumentPaymentTerm("Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018", null, '549910')
    ->addNewPosition("1")
    ->setDocumentPositionProductDetails("Trennblätter A4", "", "TB100A4", null, "0160", "4012345001235")
    ->setDocumentPositionNetPrice(9.9000)
    ->setDocumentPositionQuantity(20, "H87")
    ->addDocumentPositionTax('S', 'VAT', 19)
    ->setDocumentPositionLineSummation(198.0)
    ->addNewPosition("2")
    ->setDocumentPositionProductDetails("Joghurt Banane", "", "ARNR2", null, "0160", "4000050986428")
    ->SetDocumentPositionNetPrice(5.5000)
    ->SetDocumentPositionQuantity(50, "H87")
    ->AddDocumentPositionTax('S', 'VAT', 7)
    ->SetDocumentPositionLineSummation(275.0)
    ->writeFile(dirname(__FILE__) . "/factur-x.xml");
```