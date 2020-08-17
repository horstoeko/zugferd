<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing HeaderTradeDeliveryType
 *
 *
 * XSD Type: HeaderTradeDeliveryType
 */
class HeaderTradeDeliveryType
{

    /**
     * @var \horstoeko\zugferd\ram\LogisticsTransportMovementType[] $relatedSupplyChainConsignment
     */
    private $relatedSupplyChainConsignment = null;

    /**
     * @var \horstoeko\zugferd\ram\TradePartyType $shipToTradeParty
     */
    private $shipToTradeParty = null;

    /**
     * @var \horstoeko\zugferd\ram\TradePartyType $ultimateShipToTradeParty
     */
    private $ultimateShipToTradeParty = null;

    /**
     * @var \horstoeko\zugferd\ram\TradePartyType $shipFromTradeParty
     */
    private $shipFromTradeParty = null;

    /**
     * @var \horstoeko\zugferd\ram\SupplyChainEventType $actualDeliverySupplyChainEvent
     */
    private $actualDeliverySupplyChainEvent = null;

    /**
     * @var \horstoeko\zugferd\ram\ReferencedDocumentType $despatchAdviceReferencedDocument
     */
    private $despatchAdviceReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\ram\ReferencedDocumentType $receivingAdviceReferencedDocument
     */
    private $receivingAdviceReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\ram\ReferencedDocumentType $deliveryNoteReferencedDocument
     */
    private $deliveryNoteReferencedDocument = null;

    /**
     * Adds as specifiedLogisticsTransportMovement
     *
     * @return self
     * @param \horstoeko\zugferd\ram\LogisticsTransportMovementType $specifiedLogisticsTransportMovement
     */
    public function addToRelatedSupplyChainConsignment(\horstoeko\zugferd\ram\LogisticsTransportMovementType $specifiedLogisticsTransportMovement)
    {
        $this->relatedSupplyChainConsignment[] = $specifiedLogisticsTransportMovement;
        return $this;
    }

    /**
     * isset relatedSupplyChainConsignment
     *
     * @param int|string $index
     * @return bool
     */
    public function issetRelatedSupplyChainConsignment($index)
    {
        return isset($this->relatedSupplyChainConsignment[$index]);
    }

    /**
     * unset relatedSupplyChainConsignment
     *
     * @param int|string $index
     * @return void
     */
    public function unsetRelatedSupplyChainConsignment($index)
    {
        unset($this->relatedSupplyChainConsignment[$index]);
    }

    /**
     * Gets as relatedSupplyChainConsignment
     *
     * @return \horstoeko\zugferd\ram\LogisticsTransportMovementType[]
     */
    public function getRelatedSupplyChainConsignment()
    {
        return $this->relatedSupplyChainConsignment;
    }

    /**
     * Sets a new relatedSupplyChainConsignment
     *
     * @param \horstoeko\zugferd\ram\LogisticsTransportMovementType[] $relatedSupplyChainConsignment
     * @return self
     */
    public function setRelatedSupplyChainConsignment(array $relatedSupplyChainConsignment)
    {
        $this->relatedSupplyChainConsignment = $relatedSupplyChainConsignment;
        return $this;
    }

    /**
     * Gets as shipToTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getShipToTradeParty()
    {
        return $this->shipToTradeParty;
    }

    /**
     * Sets a new shipToTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $shipToTradeParty
     * @return self
     */
    public function setShipToTradeParty(\horstoeko\zugferd\ram\TradePartyType $shipToTradeParty)
    {
        $this->shipToTradeParty = $shipToTradeParty;
        return $this;
    }

    /**
     * Gets as ultimateShipToTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getUltimateShipToTradeParty()
    {
        return $this->ultimateShipToTradeParty;
    }

    /**
     * Sets a new ultimateShipToTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $ultimateShipToTradeParty
     * @return self
     */
    public function setUltimateShipToTradeParty(\horstoeko\zugferd\ram\TradePartyType $ultimateShipToTradeParty)
    {
        $this->ultimateShipToTradeParty = $ultimateShipToTradeParty;
        return $this;
    }

    /**
     * Gets as shipFromTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getShipFromTradeParty()
    {
        return $this->shipFromTradeParty;
    }

    /**
     * Sets a new shipFromTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $shipFromTradeParty
     * @return self
     */
    public function setShipFromTradeParty(\horstoeko\zugferd\ram\TradePartyType $shipFromTradeParty)
    {
        $this->shipFromTradeParty = $shipFromTradeParty;
        return $this;
    }

    /**
     * Gets as actualDeliverySupplyChainEvent
     *
     * @return \horstoeko\zugferd\ram\SupplyChainEventType
     */
    public function getActualDeliverySupplyChainEvent()
    {
        return $this->actualDeliverySupplyChainEvent;
    }

    /**
     * Sets a new actualDeliverySupplyChainEvent
     *
     * @param \horstoeko\zugferd\ram\SupplyChainEventType $actualDeliverySupplyChainEvent
     * @return self
     */
    public function setActualDeliverySupplyChainEvent(\horstoeko\zugferd\ram\SupplyChainEventType $actualDeliverySupplyChainEvent)
    {
        $this->actualDeliverySupplyChainEvent = $actualDeliverySupplyChainEvent;
        return $this;
    }

    /**
     * Gets as despatchAdviceReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType
     */
    public function getDespatchAdviceReferencedDocument()
    {
        return $this->despatchAdviceReferencedDocument;
    }

    /**
     * Sets a new despatchAdviceReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType $despatchAdviceReferencedDocument
     * @return self
     */
    public function setDespatchAdviceReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $despatchAdviceReferencedDocument)
    {
        $this->despatchAdviceReferencedDocument = $despatchAdviceReferencedDocument;
        return $this;
    }

    /**
     * Gets as receivingAdviceReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType
     */
    public function getReceivingAdviceReferencedDocument()
    {
        return $this->receivingAdviceReferencedDocument;
    }

    /**
     * Sets a new receivingAdviceReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType $receivingAdviceReferencedDocument
     * @return self
     */
    public function setReceivingAdviceReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $receivingAdviceReferencedDocument)
    {
        $this->receivingAdviceReferencedDocument = $receivingAdviceReferencedDocument;
        return $this;
    }

    /**
     * Gets as deliveryNoteReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType
     */
    public function getDeliveryNoteReferencedDocument()
    {
        return $this->deliveryNoteReferencedDocument;
    }

    /**
     * Sets a new deliveryNoteReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType $deliveryNoteReferencedDocument
     * @return self
     */
    public function setDeliveryNoteReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $deliveryNoteReferencedDocument)
    {
        $this->deliveryNoteReferencedDocument = $deliveryNoteReferencedDocument;
        return $this;
    }


}

