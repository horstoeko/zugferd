<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing HeaderTradeAgreementType
 *
 *
 * XSD Type: HeaderTradeAgreementType
 */
class HeaderTradeAgreementType
{

    /**
     * @property string $buyerReference
     */
    private $buyerReference = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePartyType $sellerTradeParty
     */
    private $sellerTradeParty = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePartyType $buyerTradeParty
     */
    private $buyerTradeParty = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePartyType
     * $sellerTaxRepresentativeTradeParty
     */
    private $sellerTaxRepresentativeTradeParty = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePartyType $productEndUserTradeParty
     */
    private $productEndUserTradeParty = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeDeliveryTermsType
     * $applicableTradeDeliveryTerms
     */
    private $applicableTradeDeliveryTerms = null;

    /**
     * @property \horstoeko\zugferd\ram\ReferencedDocumentType
     * $sellerOrderReferencedDocument
     */
    private $sellerOrderReferencedDocument = null;

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
     * @property \horstoeko\zugferd\ram\ProcuringProjectType $specifiedProcuringProject
     */
    private $specifiedProcuringProject = null;

    /**
     * @property \horstoeko\zugferd\ram\ReferencedDocumentType[]
     * $ultimateCustomerOrderReferencedDocument
     */
    private $ultimateCustomerOrderReferencedDocument = null;

    /**
     * Gets as buyerReference
     *
     * @return string
     */
    public function getBuyerReference()
    {
        return $this->buyerReference;
    }

    /**
     * Sets a new buyerReference
     *
     * @param string $buyerReference
     * @return self
     */
    public function setBuyerReference($buyerReference)
    {
        $this->buyerReference = $buyerReference;
        return $this;
    }

    /**
     * Gets as sellerTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getSellerTradeParty()
    {
        return $this->sellerTradeParty;
    }

    /**
     * Sets a new sellerTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $sellerTradeParty
     * @return self
     */
    public function setSellerTradeParty(\horstoeko\zugferd\ram\TradePartyType $sellerTradeParty)
    {
        $this->sellerTradeParty = $sellerTradeParty;
        return $this;
    }

    /**
     * Gets as buyerTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getBuyerTradeParty()
    {
        return $this->buyerTradeParty;
    }

    /**
     * Sets a new buyerTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $buyerTradeParty
     * @return self
     */
    public function setBuyerTradeParty(\horstoeko\zugferd\ram\TradePartyType $buyerTradeParty)
    {
        $this->buyerTradeParty = $buyerTradeParty;
        return $this;
    }

    /**
     * Gets as sellerTaxRepresentativeTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getSellerTaxRepresentativeTradeParty()
    {
        return $this->sellerTaxRepresentativeTradeParty;
    }

    /**
     * Sets a new sellerTaxRepresentativeTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $sellerTaxRepresentativeTradeParty
     * @return self
     */
    public function setSellerTaxRepresentativeTradeParty(\horstoeko\zugferd\ram\TradePartyType $sellerTaxRepresentativeTradeParty)
    {
        $this->sellerTaxRepresentativeTradeParty = $sellerTaxRepresentativeTradeParty;
        return $this;
    }

    /**
     * Gets as productEndUserTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getProductEndUserTradeParty()
    {
        return $this->productEndUserTradeParty;
    }

    /**
     * Sets a new productEndUserTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $productEndUserTradeParty
     * @return self
     */
    public function setProductEndUserTradeParty(\horstoeko\zugferd\ram\TradePartyType $productEndUserTradeParty)
    {
        $this->productEndUserTradeParty = $productEndUserTradeParty;
        return $this;
    }

    /**
     * Gets as applicableTradeDeliveryTerms
     *
     * @return \horstoeko\zugferd\ram\TradeDeliveryTermsType
     */
    public function getApplicableTradeDeliveryTerms()
    {
        return $this->applicableTradeDeliveryTerms;
    }

    /**
     * Sets a new applicableTradeDeliveryTerms
     *
     * @param \horstoeko\zugferd\ram\TradeDeliveryTermsType
     * $applicableTradeDeliveryTerms
     * @return self
     */
    public function setApplicableTradeDeliveryTerms(\horstoeko\zugferd\ram\TradeDeliveryTermsType $applicableTradeDeliveryTerms)
    {
        $this->applicableTradeDeliveryTerms = $applicableTradeDeliveryTerms;
        return $this;
    }

    /**
     * Gets as sellerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType
     */
    public function getSellerOrderReferencedDocument()
    {
        return $this->sellerOrderReferencedDocument;
    }

    /**
     * Sets a new sellerOrderReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType
     * $sellerOrderReferencedDocument
     * @return self
     */
    public function setSellerOrderReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $sellerOrderReferencedDocument)
    {
        $this->sellerOrderReferencedDocument = $sellerOrderReferencedDocument;
        return $this;
    }

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
     * Gets as specifiedProcuringProject
     *
     * @return \horstoeko\zugferd\ram\ProcuringProjectType
     */
    public function getSpecifiedProcuringProject()
    {
        return $this->specifiedProcuringProject;
    }

    /**
     * Sets a new specifiedProcuringProject
     *
     * @param \horstoeko\zugferd\ram\ProcuringProjectType $specifiedProcuringProject
     * @return self
     */
    public function setSpecifiedProcuringProject(\horstoeko\zugferd\ram\ProcuringProjectType $specifiedProcuringProject)
    {
        $this->specifiedProcuringProject = $specifiedProcuringProject;
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

