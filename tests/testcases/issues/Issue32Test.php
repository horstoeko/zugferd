<?php

namespace horstoeko\zugferd\tests\testcases\issues;

use horstoeko\zugferd\codelists\ZugferdTextSubjectCodeQualifiers;
use horstoeko\zugferd\codelists\ZugferdUnitCodes;
use horstoeko\zugferd\quick\ZugferdQuickDescriptorXRechnung3;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\tests\traits\HandlesXmlTests;

class Issue32Test extends TestCase
{
    use HandlesXmlTests;

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdQuickDescriptorXRechnung3::doCreateNew();
    }

    /**
     * @return void
     * @issue  #32
     */
    public function testIssue(): void
    {
        self::$document
            ->doCreateInvoice("471102", \DateTime::createFromFormat("Ymd", "20180305"), "EUR")
            ->doSetPaymentTerms("Zahlbar sofort", new \DateTime('+3 days'))
            ->doSetPaymentMeansForCreditTransfer(true, "DE12500105170648489890")
            ->doAddNote('Rechnung gemäß Bestellung vom 01.03.2018.')
            ->doAddNote('Lieferant GmbH' . PHP_EOL . 'Lieferantenstraße 20' . PHP_EOL . '80333 München' . PHP_EOL . 'Deutschland' . PHP_EOL . 'Geschäftsführer: Hans Muster' . PHP_EOL . 'Handelsregisternummer: H A 123' . PHP_EOL . PHP_EOL, ZugferdTextSubjectCodeQualifiers::UNTDID_4451_REG)
            ->doSetBuyer("Kunden AG Mitte", "69876", "Frankfurt", "Lieferantenstraße 20", "DE", "34676-342323")
            ->doSetBuyerContact("Hans Miller")
            ->doSetBuyerElectronicCommunication("kunde@kunde.de")
            ->doSetSeller("Lieferant GmbH", "80333", "München", "Lieferantenstraße 20", "DE", null, "4000001123452", "0088")
            ->doAddSellerTaxRegistration("FC", "201/113/40209")
            ->doAddSellerTaxRegistration("VA", "DE123456789")
            ->doSetSellerContact("Horst Meier", null, "horst@nowhere.all", "+49-0000-8888888")
            ->doSetSellerElectronicCommunication("lieferant@lieferant.de")
            ->doAddTradeLineItem(1, "PositionText", 31.67, 61.64, ZugferdUnitCodes::REC20_PIECE, 0.0, '', 'S', 'VAT', 19);

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:Name', "Kunden AG Mitte");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:LineTotalAmount', 0, "1952.14");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:ChargeTotalAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:AllowanceTotalAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxBasisTotalAmount', 0, "1952.14");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxTotalAmount', 0, "370.91", "currencyID", "EUR");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:RoundingAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:GrandTotalAmount', 0, "2323.05");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TotalPrepaidAmount', 0, "0.0");
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:DuePayableAmount', 0, "2323.05");
    }
}
