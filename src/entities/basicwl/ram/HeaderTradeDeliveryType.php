<?php

namespace horstoeko\zugferd\entities\basicwl\ram;

/**
 * Class representing HeaderTradeDeliveryType
 *
 * XSD Type: HeaderTradeDeliveryType
 */
class HeaderTradeDeliveryType
{

    /**
     * @var \horstoeko\zugferd\entities\basicwl\ram\TradePartyType|null $shipToTradeParty
     */
    private $shipToTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\ram\SupplyChainEventType|null $actualDeliverySupplyChainEvent
     */
    private $actualDeliverySupplyChainEvent = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\ram\ReferencedDocumentType|null $despatchAdviceReferencedDocument
     */
    private $despatchAdviceReferencedDocument = null;

    /**
     * Gets as shipToTradeParty
     *
     * @return \horstoeko\zugferd\entities\basicwl\ram\TradePartyType|null
     */
    public function getShipToTradeParty()
    {
        return $this->shipToTradeParty;
    }

    /**
     * Sets a new shipToTradeParty
     *
     * @param  \horstoeko\zugferd\entities\basicwl\ram\TradePartyType|null $shipToTradeParty
     * @return self
     */
    public function setShipToTradeParty(?\horstoeko\zugferd\entities\basicwl\ram\TradePartyType $shipToTradeParty = null)
    {
        $this->shipToTradeParty = $shipToTradeParty;
        return $this;
    }

    /**
     * Gets as actualDeliverySupplyChainEvent
     *
     * @return \horstoeko\zugferd\entities\basicwl\ram\SupplyChainEventType|null
     */
    public function getActualDeliverySupplyChainEvent()
    {
        return $this->actualDeliverySupplyChainEvent;
    }

    /**
     * Sets a new actualDeliverySupplyChainEvent
     *
     * @param  \horstoeko\zugferd\entities\basicwl\ram\SupplyChainEventType|null $actualDeliverySupplyChainEvent
     * @return self
     */
    public function setActualDeliverySupplyChainEvent(?\horstoeko\zugferd\entities\basicwl\ram\SupplyChainEventType $actualDeliverySupplyChainEvent = null)
    {
        $this->actualDeliverySupplyChainEvent = $actualDeliverySupplyChainEvent;
        return $this;
    }

    /**
     * Gets as despatchAdviceReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\basicwl\ram\ReferencedDocumentType|null
     */
    public function getDespatchAdviceReferencedDocument()
    {
        return $this->despatchAdviceReferencedDocument;
    }

    /**
     * Sets a new despatchAdviceReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\basicwl\ram\ReferencedDocumentType|null $despatchAdviceReferencedDocument
     * @return self
     */
    public function setDespatchAdviceReferencedDocument(?\horstoeko\zugferd\entities\basicwl\ram\ReferencedDocumentType $despatchAdviceReferencedDocument = null)
    {
        $this->despatchAdviceReferencedDocument = $despatchAdviceReferencedDocument;
        return $this;
    }
}
