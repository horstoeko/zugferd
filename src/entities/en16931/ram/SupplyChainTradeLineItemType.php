<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing SupplyChainTradeLineItemType
 *
 * XSD Type: SupplyChainTradeLineItemType
 */
class SupplyChainTradeLineItemType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\DocumentLineDocumentType|null $associatedDocumentLineDocument
     */
    private $associatedDocumentLineDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradeProductType|null $specifiedTradeProduct
     */
    private $specifiedTradeProduct = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\LineTradeAgreementType|null $specifiedLineTradeAgreement
     */
    private $specifiedLineTradeAgreement = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\LineTradeDeliveryType|null $specifiedLineTradeDelivery
     */
    private $specifiedLineTradeDelivery = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\LineTradeSettlementType|null $specifiedLineTradeSettlement
     */
    private $specifiedLineTradeSettlement = null;

    /**
     * Gets as associatedDocumentLineDocument
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\DocumentLineDocumentType|null
     */
    public function getAssociatedDocumentLineDocument()
    {
        return $this->associatedDocumentLineDocument;
    }

    /**
     * Sets a new associatedDocumentLineDocument
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\DocumentLineDocumentType $associatedDocumentLineDocument
     * @return self
     */
    public function setAssociatedDocumentLineDocument(\horstoeko\zugferd\entities\en16931\ram\DocumentLineDocumentType $associatedDocumentLineDocument)
    {
        $this->associatedDocumentLineDocument = $associatedDocumentLineDocument;
        return $this;
    }

    /**
     * Gets as specifiedTradeProduct
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradeProductType|null
     */
    public function getSpecifiedTradeProduct()
    {
        return $this->specifiedTradeProduct;
    }

    /**
     * Sets a new specifiedTradeProduct
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeProductType $specifiedTradeProduct
     * @return self
     */
    public function setSpecifiedTradeProduct(\horstoeko\zugferd\entities\en16931\ram\TradeProductType $specifiedTradeProduct)
    {
        $this->specifiedTradeProduct = $specifiedTradeProduct;
        return $this;
    }

    /**
     * Gets as specifiedLineTradeAgreement
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\LineTradeAgreementType|null
     */
    public function getSpecifiedLineTradeAgreement()
    {
        return $this->specifiedLineTradeAgreement;
    }

    /**
     * Sets a new specifiedLineTradeAgreement
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\LineTradeAgreementType $specifiedLineTradeAgreement
     * @return self
     */
    public function setSpecifiedLineTradeAgreement(\horstoeko\zugferd\entities\en16931\ram\LineTradeAgreementType $specifiedLineTradeAgreement)
    {
        $this->specifiedLineTradeAgreement = $specifiedLineTradeAgreement;
        return $this;
    }

    /**
     * Gets as specifiedLineTradeDelivery
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\LineTradeDeliveryType|null
     */
    public function getSpecifiedLineTradeDelivery()
    {
        return $this->specifiedLineTradeDelivery;
    }

    /**
     * Sets a new specifiedLineTradeDelivery
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\LineTradeDeliveryType $specifiedLineTradeDelivery
     * @return self
     */
    public function setSpecifiedLineTradeDelivery(\horstoeko\zugferd\entities\en16931\ram\LineTradeDeliveryType $specifiedLineTradeDelivery)
    {
        $this->specifiedLineTradeDelivery = $specifiedLineTradeDelivery;
        return $this;
    }

    /**
     * Gets as specifiedLineTradeSettlement
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\LineTradeSettlementType|null
     */
    public function getSpecifiedLineTradeSettlement()
    {
        return $this->specifiedLineTradeSettlement;
    }

    /**
     * Sets a new specifiedLineTradeSettlement
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\LineTradeSettlementType $specifiedLineTradeSettlement
     * @return self
     */
    public function setSpecifiedLineTradeSettlement(\horstoeko\zugferd\entities\en16931\ram\LineTradeSettlementType $specifiedLineTradeSettlement)
    {
        $this->specifiedLineTradeSettlement = $specifiedLineTradeSettlement;
        return $this;
    }
}
