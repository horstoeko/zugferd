<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\codelists\ZugferdUnitCodes;
use horstoeko\zugferd\quick\ZugferdQuickDescriptor;
use horstoeko\zugferd\quick\ZugferdQuickDescriptorEn16931;
use horstoeko\zugferd\quick\ZugferdQuickDescriptorExtended;
use horstoeko\zugferd\quick\ZugferdQuickDescriptorXRechnung;
use horstoeko\zugferd\quick\ZugferdQuickDescriptorXRechnung2;
use horstoeko\zugferd\quick\ZugferdQuickDescriptorXRechnung3;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\tests\traits\HandlesXmlTests;

class QuickDescriptorTest extends TestCase
{
    use HandlesXmlTests;

    public function testCreateEn16931Instance(): void
    {
        $descriptor = ZugferdQuickDescriptorEn16931::doCreateNew();
        self::assertInstanceOf(ZugferdQuickDescriptor::class, $descriptor);
        self::assertInstanceOf(ZugferdQuickDescriptorEn16931::class, $descriptor);
    }

    public function testCreateExtendedInstance(): void
    {
        $descriptor = ZugferdQuickDescriptorExtended::doCreateNew();
        self::assertInstanceOf(ZugferdQuickDescriptor::class, $descriptor);
        self::assertInstanceOf(ZugferdQuickDescriptorExtended::class, $descriptor);
    }

    public function testCreateXRechnungInstance(): void
    {
        $descriptor = ZugferdQuickDescriptorXRechnung::doCreateNew();
        self::assertInstanceOf(ZugferdQuickDescriptor::class, $descriptor);
        self::assertInstanceOf(ZugferdQuickDescriptorXRechnung::class, $descriptor);
    }

    public function testCreateXRechnung2Instance(): void
    {
        $descriptor = ZugferdQuickDescriptorXRechnung2::doCreateNew();
        self::assertInstanceOf(ZugferdQuickDescriptor::class, $descriptor);
        self::assertInstanceOf(ZugferdQuickDescriptorXRechnung2::class, $descriptor);
    }

    public function testCreateXRechnung3Instance(): void
    {
        $descriptor = ZugferdQuickDescriptorXRechnung3::doCreateNew();
        self::assertInstanceOf(ZugferdQuickDescriptor::class, $descriptor);
        self::assertInstanceOf(ZugferdQuickDescriptorXRechnung3::class, $descriptor);
    }

    public function testCreateInvoice(): void
    {
        self::$document = ZugferdQuickDescriptorEn16931::doCreateNew();
        self::$document
            ->doCreateInvoice('INV-001', \DateTime::createFromFormat('Ymd', '20240101'), 'EUR')
            ->doSetSeller('Seller GmbH', '12345', 'Berlin', 'Main Street 1', 'DE')
            ->doAddSellerTaxRegistration('VA', 'DE123456789')
            ->doSetBuyer('Buyer AG', '54321', 'Munich', 'Side Street 2', 'DE')
            ->doAddTradeLineItem('1', 'Product A', 100.00, 2.0, ZugferdUnitCodes::REC20_PIECE, 0.0, '', 'S', 'VAT', 19.0);

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:ID', 'INV-001');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:TypeCode', '380');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:SellerTradeParty/ram:Name', 'Seller GmbH');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeAgreement/ram:BuyerTradeParty/ram:Name', 'Buyer AG');
    }

    public function testCreateCreditMemo(): void
    {
        self::$document = ZugferdQuickDescriptorEn16931::doCreateNew();
        self::$document
            ->doCreateCreditMemo('CM-001', \DateTime::createFromFormat('Ymd', '20240101'), 'EUR')
            ->doSetSeller('Seller GmbH', '12345', 'Berlin', 'Main Street 1', 'DE')
            ->doAddSellerTaxRegistration('VA', 'DE123456789')
            ->doSetBuyer('Buyer AG', '54321', 'Munich', 'Side Street 2', 'DE')
            ->doAddTradeLineItem('1', 'Returned Product', 50.00, 1.0, ZugferdUnitCodes::REC20_PIECE, 0.0, '', 'S', 'VAT', 19.0);

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:ID', 'CM-001');
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:TypeCode', '381');
    }

    public function testInvoiceCalculation(): void
    {
        self::$document = ZugferdQuickDescriptorEn16931::doCreateNew();
        self::$document
            ->doCreateInvoice('CALC-001', \DateTime::createFromFormat('Ymd', '20240101'), 'EUR')
            ->doSetSeller('Seller GmbH', '12345', 'Berlin', 'Main Street 1', 'DE')
            ->doAddSellerTaxRegistration('VA', 'DE123456789')
            ->doSetBuyer('Buyer AG', '54321', 'Munich', 'Side Street 2', 'DE')
            ->doAddTradeLineItem('1', 'Item A', 100.00, 2.0, ZugferdUnitCodes::REC20_PIECE, 0.0, '', 'S', 'VAT', 19.0)
            ->doAddTradeLineItem('2', 'Item B', 50.00, 3.0, ZugferdUnitCodes::REC20_PIECE, 0.0, '', 'S', 'VAT', 19.0);

        $this->disableRenderXmlContent();

        // Line total: (100*2) + (50*3) = 350
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:LineTotalAmount', 0, '350.0');
        // Tax basis: 350
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxBasisTotalAmount', 0, '350.0');
        // Tax: 350 * 0.19 = 66.5
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TaxTotalAmount', 0, '66.5', 'currencyID', 'EUR');
        // Grand total: 350 + 66.5 = 416.5
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:GrandTotalAmount', 0, '416.5');
    }

    public function testPaymentTerms(): void
    {
        self::$document = ZugferdQuickDescriptorEn16931::doCreateNew();
        self::$document
            ->doCreateInvoice('PAY-001', \DateTime::createFromFormat('Ymd', '20240101'), 'EUR')
            ->doSetPaymentTerms('Net 30 days', \DateTime::createFromFormat('Ymd', '20240131'))
            ->doSetSeller('Seller GmbH', '12345', 'Berlin', 'Main Street 1', 'DE')
            ->doAddSellerTaxRegistration('VA', 'DE123456789')
            ->doSetBuyer('Buyer AG', '54321', 'Munich', 'Side Street 2', 'DE')
            ->doAddTradeLineItem('1', 'Item', 100.00, 1.0, ZugferdUnitCodes::REC20_PIECE, 0.0, '', 'S', 'VAT', 19.0);

        $this->disableRenderXmlContent();
        $this->assertXPathValue('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:Description', 'Net 30 days');
    }

    public function testSetPrepaidAmount(): void
    {
        self::$document = ZugferdQuickDescriptorEn16931::doCreateNew();
        self::$document
            ->doCreateInvoice('PREP-001', \DateTime::createFromFormat('Ymd', '20240101'), 'EUR')
            ->doSetSeller('Seller GmbH', '12345', 'Berlin', 'Main Street 1', 'DE')
            ->doAddSellerTaxRegistration('VA', 'DE123456789')
            ->doSetBuyer('Buyer AG', '54321', 'Munich', 'Side Street 2', 'DE')
            ->doAddTradeLineItem('1', 'Item', 100.00, 1.0, ZugferdUnitCodes::REC20_PIECE, 0.0, '', 'S', 'VAT', 19.0)
            ->doSetPrepaidAmount(50.0);

        $this->disableRenderXmlContent();
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:TotalPrepaidAmount', 0, '50.0');
        // Due payable = Grand total - Prepaid = 119 - 50 = 69
        $this->assertXPathValueWithIndex('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradeSettlementHeaderMonetarySummation/ram:DuePayableAmount', 0, '69.0');
    }

    public function testFluentInterface(): void
    {
        $descriptor = ZugferdQuickDescriptorEn16931::doCreateNew();

        $result = $descriptor->doCreateInvoice('FL-001', new \DateTime(), 'EUR');
        self::assertSame($descriptor, $result);

        $result = $descriptor->doSetPaymentTerms('Net 30');
        self::assertSame($descriptor, $result);

        $result = $descriptor->doSetSeller('Seller', '12345', 'City', 'Street', 'DE');
        self::assertSame($descriptor, $result);

        $result = $descriptor->doSetBuyer('Buyer', '54321', 'City', 'Street', 'DE');
        self::assertSame($descriptor, $result);

        $result = $descriptor->doAddNote('Test note');
        self::assertSame($descriptor, $result);
    }
}
