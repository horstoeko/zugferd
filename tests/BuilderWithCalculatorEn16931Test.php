<?php

namespace horstoeko\zugferd\tests;

use horstoeko\zugferd\tests\BuilderBaseTest;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilderWithCalculator;

class BuilderWithCalculatorEn16931Test extends BuilderBaseTest
{
    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentBuilderWithCalculator::CreateNew(ZugferdProfiles::PROFILE_EN16931);
    }

    public function testSimple()
    {
        self::$document->SetDocumentInformation("471102", "380", \DateTime::createFromFormat("Ymd", "20180305"), "EUR");
        self::$document->AddNewPosition("1");
        self::$document->SetDocumentPositionGrossPrice(9.9);
        self::$document->SetDocumentPositionQuantity(20.0, "H87");
        self::$document->AddDocumentPositionTax("S", "VAT", 19.0);
        self::$document->AddNewPosition("2");
        self::$document->SetDocumentPositionGrossPrice(5.5);
        self::$document->SetDocumentPositionQuantity(50.0, "H87");
        self::$document->AddDocumentPositionTax("S", "VAT", 7.0);

        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:LineTotalAmount', "473.0");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:ChargeTotalAmount', "0.0");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:AllowanceTotalAmount', "0.0");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxBasisTotalAmount', "473.0");
        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxTotalAmount', "56.87", "currencyID", "EUR");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:GrandTotalAmount', "529.87");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TotalPrepaidAmount', "0.0");
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:DuePayableAmount', "529.87");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocumentBuilderWithCalculator::writeFile
     */
    public function testWriteFile()
    {
        (self::$document)->writeFile(getcwd() . "/myfile.xml");
        $this->assertTrue(file_exists(getcwd() . "/myfile.xml"));
        @unlink(getcwd() . "/myfile.xml");
    }
}
