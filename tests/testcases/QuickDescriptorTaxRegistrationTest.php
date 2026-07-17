<?php

namespace horstoeko\zugferd\tests\testcases;

use DOMDocument;
use DOMXPath;
use horstoeko\zugferd\codelists\ZugferdUnitCodes;
use horstoeko\zugferd\quick\ZugferdQuickDescriptorEn16931;
use horstoeko\zugferd\tests\TestCase;

/**
 * Guards the argument order of the tax registration helpers in the quick descriptor.
 *
 * Both helpers take (type, number) - see doAddSellerTaxRegistration("FC", "201/113/40209")
 * in Issue32Test - and must emit the number as the element value and the type as the
 * schemeID attribute. The buyer variant used to pass its arguments to the builder in the
 * opposite order than the seller variant, which turned BT-48 into schemeID="DE999999999"
 * carrying the literal value "VA".
 */
class QuickDescriptorTaxRegistrationTest extends TestCase
{
    private const NS_RAM = 'urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100';

    /**
     * @return void
     */
    public function testSellerAndBuyerTaxRegistrationUseTheSameArgumentOrder(): void
    {
        $document = ZugferdQuickDescriptorEn16931::doCreateNew();
        $document
            ->doCreateInvoice("R-1", \DateTime::createFromFormat("Ymd", "20240101"), "EUR")
            ->doSetBuyer("Kunden AG Mitte", "69876", "Frankfurt", "Lieferantenstraße 20", "DE")
            ->doSetSeller("Lieferant GmbH", "80333", "München", "Lieferantenstraße 20", "DE")
            ->doAddSellerTaxRegistration("VA", "DE111111111")
            ->doAddBuyerTaxRegistration("VA", "DE999999999")
            ->doAddTradeLineItem(1, "PositionText", 10.0, 1.0, ZugferdUnitCodes::REC20_PIECE, 0.0, '', 'S', 'VAT', 19);

        $domDocument = new DOMDocument();
        $domDocument->loadXML($document->getContent());

        $domXpath = new DOMXPath($domDocument);
        $domXpath->registerNamespace('ram', self::NS_RAM);

        $this->assertTaxRegistration($domXpath, 'SellerTradeParty', 'DE111111111', 'VA');
        $this->assertTaxRegistration($domXpath, 'BuyerTradeParty', 'DE999999999', 'VA');
    }

    /**
     * Assert that the tax registration of $tradeParty carries $expectedId as its value
     * and $expectedSchemeId as its schemeID attribute
     *
     * @param  DOMXPath $domXpath
     * @param  string   $tradeParty
     * @param  string   $expectedId
     * @param  string   $expectedSchemeId
     * @return void
     */
    private function assertTaxRegistration(DOMXPath $domXpath, string $tradeParty, string $expectedId, string $expectedSchemeId): void
    {
        $nodeList = $domXpath->query(sprintf('//ram:%s/ram:SpecifiedTaxRegistration/ram:ID', $tradeParty));

        $this->assertNotFalse($nodeList);
        $this->assertSame(1, $nodeList->length, sprintf('Expected exactly one tax registration for %s', $tradeParty));

        $node = $nodeList->item(0);

        $this->assertNotNull($node);
        $this->assertSame($expectedId, $node->nodeValue, sprintf('Wrong tax number for %s', $tradeParty));
        $this->assertSame($expectedSchemeId, $node->attributes->getNamedItem('schemeID')->nodeValue, sprintf('Wrong schemeID for %s', $tradeParty));
    }
}
