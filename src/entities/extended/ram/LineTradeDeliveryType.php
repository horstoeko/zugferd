<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing LineTradeDeliveryType
 *
 * XSD Type: LineTradeDeliveryType
 */
class LineTradeDeliveryType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\QuantityType|null $billedQuantity
     */
    private $billedQuantity = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\QuantityType|null $chargeFreeQuantity
     */
    private $chargeFreeQuantity = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\QuantityType|null $packageQuantity
     */
    private $packageQuantity = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\QuantityType|null $perPackageUnitQuantity
     */
    private $perPackageUnitQuantity = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $shipToTradeParty
     */
    private $shipToTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $ultimateShipToTradeParty
     */
    private $ultimateShipToTradeParty = null;

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
     * Gets as billedQuantity
     *
     * @return \horstoeko\zugferd\entities\extended\udt\QuantityType|null
     */
    public function getBilledQuantity()
    {
        return $this->billedQuantity;
    }

    /**
     * Sets a new billedQuantity
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\QuantityType|null $billedQuantity
     * @return self
     */
    public function setBilledQuantity(?\horstoeko\zugferd\entities\extended\udt\QuantityType $billedQuantity = null)
    {
        $this->billedQuantity = $billedQuantity;
        return $this;
    }

    /**
     * Gets as chargeFreeQuantity
     *
     * @return \horstoeko\zugferd\entities\extended\udt\QuantityType|null
     */
    public function getChargeFreeQuantity()
    {
        return $this->chargeFreeQuantity;
    }

    /**
     * Sets a new chargeFreeQuantity
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\QuantityType|null $chargeFreeQuantity
     * @return self
     */
    public function setChargeFreeQuantity(?\horstoeko\zugferd\entities\extended\udt\QuantityType $chargeFreeQuantity = null)
    {
        $this->chargeFreeQuantity = $chargeFreeQuantity;
        return $this;
    }

    /**
     * Gets as packageQuantity
     *
     * @return \horstoeko\zugferd\entities\extended\udt\QuantityType|null
     */
    public function getPackageQuantity()
    {
        return $this->packageQuantity;
    }

    /**
     * Sets a new packageQuantity
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\QuantityType|null $packageQuantity
     * @return self
     */
    public function setPackageQuantity(?\horstoeko\zugferd\entities\extended\udt\QuantityType $packageQuantity = null)
    {
        $this->packageQuantity = $packageQuantity;
        return $this;
    }

    /**
     * Gets as perPackageUnitQuantity
     *
     * @return \horstoeko\zugferd\entities\extended\udt\QuantityType|null
     */
    public function getPerPackageUnitQuantity()
    {
        return $this->perPackageUnitQuantity;
    }

    /**
     * Sets a new perPackageUnitQuantity
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\QuantityType|null $perPackageUnitQuantity
     * @return self
     */
    public function setPerPackageUnitQuantity(?\horstoeko\zugferd\entities\extended\udt\QuantityType $perPackageUnitQuantity = null)
    {
        $this->perPackageUnitQuantity = $perPackageUnitQuantity;
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
