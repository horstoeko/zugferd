<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing HeaderTradeDeliveryType
 *
 *
 * XSD Type: HeaderTradeDeliveryType
 */
class HeaderTradeDeliveryType
{

    /**
     * @var \horstoeko\zugferd\basicwl\ram\TradePartyType $shipToTradeParty
     */
    private $shipToTradeParty = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\SupplyChainEventType $actualDeliverySupplyChainEvent
     */
    private $actualDeliverySupplyChainEvent = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $despatchAdviceReferencedDocument
     */
    private $despatchAdviceReferencedDocument = null;

    /**
     * Gets as shipToTradeParty
     *
     * @return \horstoeko\zugferd\basicwl\ram\TradePartyType
     */
    public function getShipToTradeParty()
    {
        return $this->shipToTradeParty;
    }

    /**
     * Sets a new shipToTradeParty
     *
     * @param \horstoeko\zugferd\basicwl\ram\TradePartyType $shipToTradeParty
     * @return self
     */
    public function setShipToTradeParty(\horstoeko\zugferd\basicwl\ram\TradePartyType $shipToTradeParty)
    {
        $this->shipToTradeParty = $shipToTradeParty;
        return $this;
    }

    /**
     * Gets as actualDeliverySupplyChainEvent
     *
     * @return \horstoeko\zugferd\basicwl\ram\SupplyChainEventType
     */
    public function getActualDeliverySupplyChainEvent()
    {
        return $this->actualDeliverySupplyChainEvent;
    }

    /**
     * Sets a new actualDeliverySupplyChainEvent
     *
     * @param \horstoeko\zugferd\basicwl\ram\SupplyChainEventType $actualDeliverySupplyChainEvent
     * @return self
     */
    public function setActualDeliverySupplyChainEvent(\horstoeko\zugferd\basicwl\ram\SupplyChainEventType $actualDeliverySupplyChainEvent)
    {
        $this->actualDeliverySupplyChainEvent = $actualDeliverySupplyChainEvent;
        return $this;
    }

    /**
     * Gets as despatchAdviceReferencedDocument
     *
     * @return \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType
     */
    public function getDespatchAdviceReferencedDocument()
    {
        return $this->despatchAdviceReferencedDocument;
    }

    /**
     * Sets a new despatchAdviceReferencedDocument
     *
     * @param \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $despatchAdviceReferencedDocument
     * @return self
     */
    public function setDespatchAdviceReferencedDocument(\horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $despatchAdviceReferencedDocument)
    {
        $this->despatchAdviceReferencedDocument = $despatchAdviceReferencedDocument;
        return $this;
    }


}

