<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentJsonExporter;
use horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType;
use horstoeko\zugferd\entities\extended\ram\TradeSettlementPaymentMeansType;
use horstoeko\zugferd\entities\extended\ram\HeaderTradeSettlementType;
use horstoeko\zugferd\entities\extended\ram\SupplyChainTradeTransactionType;
use horstoeko\zugferd\entities\extended\udt\TextType;
use horstoeko\zugferd\entities\extended\udt\IDType;
use TypeError;

class SetInvoiceObjectTest extends TestCase
{
    private const CARD_HOLDER_NAME = "Mr John Doe";
    private const CARD_ID = "9999";

    public function testSettingsInvoiceObject(): void
    {
        $document = $this->createDocumentWithFinancialCard();

        $this->assertDocumentProperties($document);
        $this->assertJsonExport($document);
    }

    public function testIncorrectProfileScenario()
    {
        try{

            $document = $this->createDocumentWithBadProfile();

        }      
        catch(\Throwable $th){

            $this->assertInstanceOf(TypeError::class, $th);
            
        }
    }


    private function createDocumentWithBadProfile()
    {

        $financialCard = $this->createFinancialCard();
        $paymentMeans = $this->createPaymentMeans($financialCard);
        $headerTradeSettlement = $this->createHeaderTradeSettlement($paymentMeans);
        $supplyChainTransaction = $this->createSupplyChainTransaction($headerTradeSettlement);

        $document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_BASIC);
        $cii = $document->getInvoiceObject();
        $cii->setSupplyChainTradeTransaction($supplyChainTransaction);
        $document->setInvoiceObject($cii);

    }

    private function createDocumentWithFinancialCard(): \horstoeko\zugferd\ZugferdDocument
    {

$financialCard = $this->createFinancialCard();
$paymentMeans = $this->createPaymentMeans($financialCard);
$headerTradeSettlement = $this->createHeaderTradeSettlement($paymentMeans);
$supplyChainTransaction = $this->createSupplyChainTransaction($headerTradeSettlement);

$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EXTENDED);
$cii = $document->getInvoiceObject();
$cii->setSupplyChainTradeTransaction($supplyChainTransaction);
$document->setInvoiceObject($cii);


        return $document;
    }

    private function createFinancialCard(): TradeSettlementFinancialCardType
    {
        return (new TradeSettlementFinancialCardType())
            ->setCardholderName(new TextType(self::CARD_HOLDER_NAME))
            ->setID(new IDType(self::CARD_ID));
    }

    private function createPaymentMeans(TradeSettlementFinancialCardType $financialCard): TradeSettlementPaymentMeansType
    {
        return (new TradeSettlementPaymentMeansType())
            ->setApplicableTradeSettlementFinancialCard($financialCard);
    }

    private function createHeaderTradeSettlement(TradeSettlementPaymentMeansType $paymentMeans): HeaderTradeSettlementType
    {
        return (new HeaderTradeSettlementType())
            ->addToSpecifiedTradeSettlementPaymentMeans($paymentMeans);
    }

    private function createSupplyChainTransaction(HeaderTradeSettlementType $headerTradeSettlement): SupplyChainTradeTransactionType
    {
        return (new SupplyChainTradeTransactionType())
            ->setApplicableHeaderTradeSettlement($headerTradeSettlement);
    }

    private function assertDocumentProperties(\horstoeko\zugferd\ZugferdDocument $document): void
    {
        $this->assertNotNull($document->getContent());
        $this->assertNotNull($document->getInvoiceObject());
        $this->assertNotNull($document->getSerializer());
        $this->assertNotNull($document->getObjectHelper());
        $this->assertEquals(ZugferdProfiles::PROFILE_EXTENDED, $document->getProfileId());
    }

    private function assertJsonExport(\horstoeko\zugferd\ZugferdDocument $document): void
    {
        $exporter = new ZugferdDocumentJsonExporter($document);
        $jsonObject = $exporter->toJsonObject();

        $this->assertInstanceOf("stdClass", $jsonObject);
        $this->assertTrue(isset($jsonObject->SupplyChainTradeTransaction));
        $this->assertEquals(self::CARD_ID, $jsonObject->SupplyChainTradeTransaction->ApplicableHeaderTradeSettlement->SpecifiedTradeSettlementPaymentMeans[0]->ApplicableTradeSettlementFinancialCard->ID->__value);
        $this->assertEquals(self::CARD_HOLDER_NAME, $jsonObject->SupplyChainTradeTransaction->ApplicableHeaderTradeSettlement->SpecifiedTradeSettlementPaymentMeans[0]->ApplicableTradeSettlementFinancialCard->CardholderName->__value);
    }
}
