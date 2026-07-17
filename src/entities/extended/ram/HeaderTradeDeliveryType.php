<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing HeaderTradeDeliveryType
 *
 * XSD Type: HeaderTradeDeliveryType
 */
class HeaderTradeDeliveryType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType[]|null $relatedSupplyChainConsignment
     */
    private $relatedSupplyChainConsignment = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $shipToTradeParty
     */
    private $shipToTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $ultimateShipToTradeParty
     */
    private $ultimateShipToTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $shipFromTradeParty
     */
    private $shipFromTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType|null $actualDeliverySupplyChainEvent
     */
    private $actualDeliverySupplyChainEvent = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $despatchAdviceReferencedDocument
     */
    private $despatchAdviceReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $receivingAdviceReferencedDocument
     */
    private $receivingAdviceReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $deliveryNoteReferencedDocument
     */
    private $deliveryNoteReferencedDocument = null;

    /**
     * Adds as specifiedLogisticsTransportMovement
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType $specifiedLogisticsTransportMovement
     */
    public function addToRelatedSupplyChainConsignment(\horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType $specifiedLogisticsTransportMovement)
    {
        $this->relatedSupplyChainConsignment[] = $specifiedLogisticsTransportMovement;
        return $this;
    }

    /**
     * isset relatedSupplyChainConsignment
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetRelatedSupplyChainConsignment($index)
    {
        return isset($this->relatedSupplyChainConsignment[$index]);
    }

    /**
     * unset relatedSupplyChainConsignment
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetRelatedSupplyChainConsignment($index)
    {
        unset($this->relatedSupplyChainConsignment[$index]);
    }

    /**
     * Gets as relatedSupplyChainConsignment
     *
     * @return \horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType[]|null
     */
    public function getRelatedSupplyChainConsignment()
    {
        return $this->relatedSupplyChainConsignment;
    }

    /**
     * Sets a new relatedSupplyChainConsignment
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType[]|null $relatedSupplyChainConsignment
     * @return self
     */
    public function setRelatedSupplyChainConsignment(?array $relatedSupplyChainConsignment = null)
    {
        $this->relatedSupplyChainConsignment = $relatedSupplyChainConsignment;
        return $this;
    }

    /**
     * Gets as shipToTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getShipToTradeParty()
    {
        return $this->shipToTradeParty;
    }

    /**
     * Sets a new shipToTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $shipToTradeParty
     * @return self
     */
    public function setShipToTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $shipToTradeParty = null)
    {
        $this->shipToTradeParty = $shipToTradeParty;
        return $this;
    }

    /**
     * Gets as ultimateShipToTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getUltimateShipToTradeParty()
    {
        return $this->ultimateShipToTradeParty;
    }

    /**
     * Sets a new ultimateShipToTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $ultimateShipToTradeParty
     * @return self
     */
    public function setUltimateShipToTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $ultimateShipToTradeParty = null)
    {
        $this->ultimateShipToTradeParty = $ultimateShipToTradeParty;
        return $this;
    }

    /**
     * Gets as shipFromTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getShipFromTradeParty()
    {
        return $this->shipFromTradeParty;
    }

    /**
     * Sets a new shipFromTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $shipFromTradeParty
     * @return self
     */
    public function setShipFromTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $shipFromTradeParty = null)
    {
        $this->shipFromTradeParty = $shipFromTradeParty;
        return $this;
    }

    /**
     * Gets as actualDeliverySupplyChainEvent
     *
     * @return \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType|null
     */
    public function getActualDeliverySupplyChainEvent()
    {
        return $this->actualDeliverySupplyChainEvent;
    }

    /**
     * Sets a new actualDeliverySupplyChainEvent
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType|null $actualDeliverySupplyChainEvent
     * @return self
     */
    public function setActualDeliverySupplyChainEvent(?\horstoeko\zugferd\entities\extended\ram\SupplyChainEventType $actualDeliverySupplyChainEvent = null)
    {
        $this->actualDeliverySupplyChainEvent = $actualDeliverySupplyChainEvent;
        return $this;
    }

    /**
     * Gets as despatchAdviceReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null
     */
    public function getDespatchAdviceReferencedDocument()
    {
        return $this->despatchAdviceReferencedDocument;
    }

    /**
     * Sets a new despatchAdviceReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $despatchAdviceReferencedDocument
     * @return self
     */
    public function setDespatchAdviceReferencedDocument(?\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $despatchAdviceReferencedDocument = null)
    {
        $this->despatchAdviceReferencedDocument = $despatchAdviceReferencedDocument;
        return $this;
    }

    /**
     * Gets as receivingAdviceReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null
     */
    public function getReceivingAdviceReferencedDocument()
    {
        return $this->receivingAdviceReferencedDocument;
    }

    /**
     * Sets a new receivingAdviceReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $receivingAdviceReferencedDocument
     * @return self
     */
    public function setReceivingAdviceReferencedDocument(?\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $receivingAdviceReferencedDocument = null)
    {
        $this->receivingAdviceReferencedDocument = $receivingAdviceReferencedDocument;
        return $this;
    }

    /**
     * Gets as deliveryNoteReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null
     */
    public function getDeliveryNoteReferencedDocument()
    {
        return $this->deliveryNoteReferencedDocument;
    }

    /**
     * Sets a new deliveryNoteReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $deliveryNoteReferencedDocument
     * @return self
     */
    public function setDeliveryNoteReferencedDocument(?\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $deliveryNoteReferencedDocument = null)
    {
        $this->deliveryNoteReferencedDocument = $deliveryNoteReferencedDocument;
        return $this;
    }
}
