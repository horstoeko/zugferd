<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing LineTradeAgreementType
 *
 *
 * XSD Type: LineTradeAgreementType
 */
class LineTradeAgreementType
{

    /**
     * @property \horstoeko\zugferd\ram\ReferencedDocumentType
     * $buyerOrderReferencedDocument
     */
    private $buyerOrderReferencedDocument = null;

    /**
     * @property \horstoeko\zugferd\ram\ReferencedDocumentType
     * $contractReferencedDocument
     */
    private $contractReferencedDocument = null;

    /**
     * @property \horstoeko\zugferd\ram\ReferencedDocumentType[]
     * $additionalReferencedDocument
     */
    private $additionalReferencedDocument = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePriceType $grossPriceProductTradePrice
     */
    private $grossPriceProductTradePrice = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePriceType $netPriceProductTradePrice
     */
    private $netPriceProductTradePrice = null;

    /**
     * @property \horstoeko\zugferd\ram\ReferencedDocumentType[]
     * $ultimateCustomerOrderReferencedDocument
     */
    private $ultimateCustomerOrderReferencedDocument = null;

    /**
     * Gets as buyerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType
     */
    public function getBuyerOrderReferencedDocument()
    {
        return $this->buyerOrderReferencedDocument;
    }

    /**
     * Sets a new buyerOrderReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType
     * $buyerOrderReferencedDocument
     * @return self
     */
    public function setBuyerOrderReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $buyerOrderReferencedDocument)
    {
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;
        return $this;
    }

    /**
     * Gets as contractReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType
     */
    public function getContractReferencedDocument()
    {
        return $this->contractReferencedDocument;
    }

    /**
     * Sets a new contractReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType $contractReferencedDocument
     * @return self
     */
    public function setContractReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $contractReferencedDocument)
    {
        $this->contractReferencedDocument = $contractReferencedDocument;
        return $this;
    }

    /**
     * Adds as additionalReferencedDocument
     *
     * @return self
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType
     * $additionalReferencedDocument
     */
    public function addToAdditionalReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $additionalReferencedDocument)
    {
        $this->additionalReferencedDocument[] = $additionalReferencedDocument;
        return $this;
    }

    /**
     * isset additionalReferencedDocument
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAdditionalReferencedDocument($index)
    {
        return isset($this->additionalReferencedDocument[$index]);
    }

    /**
     * unset additionalReferencedDocument
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAdditionalReferencedDocument($index)
    {
        unset($this->additionalReferencedDocument[$index]);
    }

    /**
     * Gets as additionalReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType[]
     */
    public function getAdditionalReferencedDocument()
    {
        return $this->additionalReferencedDocument;
    }

    /**
     * Sets a new additionalReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType[]
     * $additionalReferencedDocument
     * @return self
     */
    public function setAdditionalReferencedDocument(array $additionalReferencedDocument)
    {
        $this->additionalReferencedDocument = $additionalReferencedDocument;
        return $this;
    }

    /**
     * Gets as grossPriceProductTradePrice
     *
     * @return \horstoeko\zugferd\ram\TradePriceType
     */
    public function getGrossPriceProductTradePrice()
    {
        return $this->grossPriceProductTradePrice;
    }

    /**
     * Sets a new grossPriceProductTradePrice
     *
     * @param \horstoeko\zugferd\ram\TradePriceType $grossPriceProductTradePrice
     * @return self
     */
    public function setGrossPriceProductTradePrice(\horstoeko\zugferd\ram\TradePriceType $grossPriceProductTradePrice)
    {
        $this->grossPriceProductTradePrice = $grossPriceProductTradePrice;
        return $this;
    }

    /**
     * Gets as netPriceProductTradePrice
     *
     * @return \horstoeko\zugferd\ram\TradePriceType
     */
    public function getNetPriceProductTradePrice()
    {
        return $this->netPriceProductTradePrice;
    }

    /**
     * Sets a new netPriceProductTradePrice
     *
     * @param \horstoeko\zugferd\ram\TradePriceType $netPriceProductTradePrice
     * @return self
     */
    public function setNetPriceProductTradePrice(\horstoeko\zugferd\ram\TradePriceType $netPriceProductTradePrice)
    {
        $this->netPriceProductTradePrice = $netPriceProductTradePrice;
        return $this;
    }

    /**
     * Adds as ultimateCustomerOrderReferencedDocument
     *
     * @return self
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType
     * $ultimateCustomerOrderReferencedDocument
     */
    public function addToUltimateCustomerOrderReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $ultimateCustomerOrderReferencedDocument)
    {
        $this->ultimateCustomerOrderReferencedDocument[] = $ultimateCustomerOrderReferencedDocument;
        return $this;
    }

    /**
     * isset ultimateCustomerOrderReferencedDocument
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetUltimateCustomerOrderReferencedDocument($index)
    {
        return isset($this->ultimateCustomerOrderReferencedDocument[$index]);
    }

    /**
     * unset ultimateCustomerOrderReferencedDocument
     *
     * @param scalar $index
     * @return void
     */
    public function unsetUltimateCustomerOrderReferencedDocument($index)
    {
        unset($this->ultimateCustomerOrderReferencedDocument[$index]);
    }

    /**
     * Gets as ultimateCustomerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType[]
     */
    public function getUltimateCustomerOrderReferencedDocument()
    {
        return $this->ultimateCustomerOrderReferencedDocument;
    }

    /**
     * Sets a new ultimateCustomerOrderReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType[]
     * $ultimateCustomerOrderReferencedDocument
     * @return self
     */
    public function setUltimateCustomerOrderReferencedDocument(array $ultimateCustomerOrderReferencedDocument)
    {
        $this->ultimateCustomerOrderReferencedDocument = $ultimateCustomerOrderReferencedDocument;
        return $this;
    }


}

