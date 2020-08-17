<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing LineTradeDeliveryType
 *
 *
 * XSD Type: LineTradeDeliveryType
 */
class LineTradeDeliveryType
{

    /**
     * @var \horstoeko\zugferd\udt\QuantityType $billedQuantity
     */
    private $billedQuantity = null;

    /**
     * @var \horstoeko\zugferd\udt\QuantityType $chargeFreeQuantity
     */
    private $chargeFreeQuantity = null;

    /**
     * @var \horstoeko\zugferd\udt\QuantityType $packageQuantity
     */
    private $packageQuantity = null;

    /**
     * @var \horstoeko\zugferd\ram\TradePartyType $shipToTradeParty
     */
    private $shipToTradeParty = null;

    /**
     * @var \horstoeko\zugferd\ram\TradePartyType $ultimateShipToTradeParty
     */
    private $ultimateShipToTradeParty = null;

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
     * Gets as billedQuantity
     *
     * @return \horstoeko\zugferd\udt\QuantityType
     */
    public function getBilledQuantity()
    {
        return $this->billedQuantity;
    }

    /**
     * Sets a new billedQuantity
     *
     * @param \horstoeko\zugferd\udt\QuantityType $billedQuantity
     * @return self
     */
    public function setBilledQuantity(\horstoeko\zugferd\udt\QuantityType $billedQuantity)
    {
        $this->billedQuantity = $billedQuantity;
        return $this;
    }

    /**
     * Gets as chargeFreeQuantity
     *
     * @return \horstoeko\zugferd\udt\QuantityType
     */
    public function getChargeFreeQuantity()
    {
        return $this->chargeFreeQuantity;
    }

    /**
     * Sets a new chargeFreeQuantity
     *
     * @param \horstoeko\zugferd\udt\QuantityType $chargeFreeQuantity
     * @return self
     */
    public function setChargeFreeQuantity(\horstoeko\zugferd\udt\QuantityType $chargeFreeQuantity)
    {
        $this->chargeFreeQuantity = $chargeFreeQuantity;
        return $this;
    }

    /**
     * Gets as packageQuantity
     *
     * @return \horstoeko\zugferd\udt\QuantityType
     */
    public function getPackageQuantity()
    {
        return $this->packageQuantity;
    }

    /**
     * Sets a new packageQuantity
     *
     * @param \horstoeko\zugferd\udt\QuantityType $packageQuantity
     * @return self
     */
    public function setPackageQuantity(\horstoeko\zugferd\udt\QuantityType $packageQuantity)
    {
        $this->packageQuantity = $packageQuantity;
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

