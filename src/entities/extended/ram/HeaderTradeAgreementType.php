<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing HeaderTradeAgreementType
 *
 * XSD Type: HeaderTradeAgreementType
 */
class HeaderTradeAgreementType
{

    /**
     * @var string|null $buyerReference
     */
    private $buyerReference = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $sellerTradeParty
     */
    private $sellerTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $buyerTradeParty
     */
    private $buyerTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $salesAgentTradeParty
     */
    private $salesAgentTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $buyerTaxRepresentativeTradeParty
     */
    private $buyerTaxRepresentativeTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $sellerTaxRepresentativeTradeParty
     */
    private $sellerTaxRepresentativeTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $productEndUserTradeParty
     */
    private $productEndUserTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType|null $applicableTradeDeliveryTerms
     */
    private $applicableTradeDeliveryTerms = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $sellerOrderReferencedDocument
     */
    private $sellerOrderReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $buyerOrderReferencedDocument
     */
    private $buyerOrderReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $quotationReferencedDocument
     */
    private $quotationReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $contractReferencedDocument
     */
    private $contractReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType[] $additionalReferencedDocument
     */
    private $additionalReferencedDocument = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $buyerAgentTradeParty
     */
    private $buyerAgentTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType|null $specifiedProcuringProject
     */
    private $specifiedProcuringProject = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType[] $ultimateCustomerOrderReferencedDocument
     */
    private $ultimateCustomerOrderReferencedDocument = [
        
    ];

    /**
     * Gets as buyerReference
     *
     * @return string|null
     */
    public function getBuyerReference()
    {
        return $this->buyerReference;
    }

    /**
     * Sets a new buyerReference
     *
     * @param  string $buyerReference
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
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getSellerTradeParty()
    {
        return $this->sellerTradeParty;
    }

    /**
     * Sets a new sellerTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType $sellerTradeParty
     * @return self
     */
    public function setSellerTradeParty(\horstoeko\zugferd\entities\extended\ram\TradePartyType $sellerTradeParty)
    {
        $this->sellerTradeParty = $sellerTradeParty;
        return $this;
    }

    /**
     * Gets as buyerTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getBuyerTradeParty()
    {
        return $this->buyerTradeParty;
    }

    /**
     * Sets a new buyerTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType $buyerTradeParty
     * @return self
     */
    public function setBuyerTradeParty(\horstoeko\zugferd\entities\extended\ram\TradePartyType $buyerTradeParty)
    {
        $this->buyerTradeParty = $buyerTradeParty;
        return $this;
    }

    /**
     * Gets as salesAgentTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getSalesAgentTradeParty()
    {
        return $this->salesAgentTradeParty;
    }

    /**
     * Sets a new salesAgentTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $salesAgentTradeParty
     * @return self
     */
    public function setSalesAgentTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $salesAgentTradeParty = null)
    {
        $this->salesAgentTradeParty = $salesAgentTradeParty;
        return $this;
    }

    /**
     * Gets as buyerTaxRepresentativeTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getBuyerTaxRepresentativeTradeParty()
    {
        return $this->buyerTaxRepresentativeTradeParty;
    }

    /**
     * Sets a new buyerTaxRepresentativeTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $buyerTaxRepresentativeTradeParty
     * @return self
     */
    public function setBuyerTaxRepresentativeTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $buyerTaxRepresentativeTradeParty = null)
    {
        $this->buyerTaxRepresentativeTradeParty = $buyerTaxRepresentativeTradeParty;
        return $this;
    }

    /**
     * Gets as sellerTaxRepresentativeTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getSellerTaxRepresentativeTradeParty()
    {
        return $this->sellerTaxRepresentativeTradeParty;
    }

    /**
     * Sets a new sellerTaxRepresentativeTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $sellerTaxRepresentativeTradeParty
     * @return self
     */
    public function setSellerTaxRepresentativeTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $sellerTaxRepresentativeTradeParty = null)
    {
        $this->sellerTaxRepresentativeTradeParty = $sellerTaxRepresentativeTradeParty;
        return $this;
    }

    /**
     * Gets as productEndUserTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getProductEndUserTradeParty()
    {
        return $this->productEndUserTradeParty;
    }

    /**
     * Sets a new productEndUserTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $productEndUserTradeParty
     * @return self
     */
    public function setProductEndUserTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $productEndUserTradeParty = null)
    {
        $this->productEndUserTradeParty = $productEndUserTradeParty;
        return $this;
    }

    /**
     * Gets as applicableTradeDeliveryTerms
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType|null
     */
    public function getApplicableTradeDeliveryTerms()
    {
        return $this->applicableTradeDeliveryTerms;
    }

    /**
     * Sets a new applicableTradeDeliveryTerms
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType|null $applicableTradeDeliveryTerms
     * @return self
     */
    public function setApplicableTradeDeliveryTerms(?\horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType $applicableTradeDeliveryTerms = null)
    {
        $this->applicableTradeDeliveryTerms = $applicableTradeDeliveryTerms;
        return $this;
    }

    /**
     * Gets as sellerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null
     */
    public function getSellerOrderReferencedDocument()
    {
        return $this->sellerOrderReferencedDocument;
    }

    /**
     * Sets a new sellerOrderReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $sellerOrderReferencedDocument
     * @return self
     */
    public function setSellerOrderReferencedDocument(?\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $sellerOrderReferencedDocument = null)
    {
        $this->sellerOrderReferencedDocument = $sellerOrderReferencedDocument;
        return $this;
    }

    /**
     * Gets as buyerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null
     */
    public function getBuyerOrderReferencedDocument()
    {
        return $this->buyerOrderReferencedDocument;
    }

    /**
     * Sets a new buyerOrderReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $buyerOrderReferencedDocument
     * @return self
     */
    public function setBuyerOrderReferencedDocument(?\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $buyerOrderReferencedDocument = null)
    {
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;
        return $this;
    }

    /**
     * Gets as quotationReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null
     */
    public function getQuotationReferencedDocument()
    {
        return $this->quotationReferencedDocument;
    }

    /**
     * Sets a new quotationReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $quotationReferencedDocument
     * @return self
     */
    public function setQuotationReferencedDocument(?\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $quotationReferencedDocument = null)
    {
        $this->quotationReferencedDocument = $quotationReferencedDocument;
        return $this;
    }

    /**
     * Gets as contractReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null
     */
    public function getContractReferencedDocument()
    {
        return $this->contractReferencedDocument;
    }

    /**
     * Sets a new contractReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType|null $contractReferencedDocument
     * @return self
     */
    public function setContractReferencedDocument(?\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $contractReferencedDocument = null)
    {
        $this->contractReferencedDocument = $contractReferencedDocument;
        return $this;
    }

    /**
     * Adds as additionalReferencedDocument
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $additionalReferencedDocument
     */
    public function addToAdditionalReferencedDocument(\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $additionalReferencedDocument)
    {
        $this->additionalReferencedDocument[] = $additionalReferencedDocument;
        return $this;
    }

    /**
     * isset additionalReferencedDocument
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetAdditionalReferencedDocument($index)
    {
        return isset($this->additionalReferencedDocument[$index]);
    }

    /**
     * unset additionalReferencedDocument
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetAdditionalReferencedDocument($index)
    {
        unset($this->additionalReferencedDocument[$index]);
    }

    /**
     * Gets as additionalReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType[]
     */
    public function getAdditionalReferencedDocument()
    {
        return $this->additionalReferencedDocument;
    }

    /**
     * Sets a new additionalReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType[]|null $additionalReferencedDocument
     * @return self
     */
    public function setAdditionalReferencedDocument(?array $additionalReferencedDocument = null)
    {
        $this->additionalReferencedDocument = $additionalReferencedDocument;
        return $this;
    }

    /**
     * Gets as buyerAgentTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getBuyerAgentTradeParty()
    {
        return $this->buyerAgentTradeParty;
    }

    /**
     * Sets a new buyerAgentTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $buyerAgentTradeParty
     * @return self
     */
    public function setBuyerAgentTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $buyerAgentTradeParty = null)
    {
        $this->buyerAgentTradeParty = $buyerAgentTradeParty;
        return $this;
    }

    /**
     * Gets as specifiedProcuringProject
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType|null
     */
    public function getSpecifiedProcuringProject()
    {
        return $this->specifiedProcuringProject;
    }

    /**
     * Sets a new specifiedProcuringProject
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType|null $specifiedProcuringProject
     * @return self
     */
    public function setSpecifiedProcuringProject(?\horstoeko\zugferd\entities\extended\ram\ProcuringProjectType $specifiedProcuringProject = null)
    {
        $this->specifiedProcuringProject = $specifiedProcuringProject;
        return $this;
    }

    /**
     * Adds as ultimateCustomerOrderReferencedDocument
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $ultimateCustomerOrderReferencedDocument
     */
    public function addToUltimateCustomerOrderReferencedDocument(\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $ultimateCustomerOrderReferencedDocument)
    {
        $this->ultimateCustomerOrderReferencedDocument[] = $ultimateCustomerOrderReferencedDocument;
        return $this;
    }

    /**
     * isset ultimateCustomerOrderReferencedDocument
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetUltimateCustomerOrderReferencedDocument($index)
    {
        return isset($this->ultimateCustomerOrderReferencedDocument[$index]);
    }

    /**
     * unset ultimateCustomerOrderReferencedDocument
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetUltimateCustomerOrderReferencedDocument($index)
    {
        unset($this->ultimateCustomerOrderReferencedDocument[$index]);
    }

    /**
     * Gets as ultimateCustomerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType[]
     */
    public function getUltimateCustomerOrderReferencedDocument()
    {
        return $this->ultimateCustomerOrderReferencedDocument;
    }

    /**
     * Sets a new ultimateCustomerOrderReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType[]|null $ultimateCustomerOrderReferencedDocument
     * @return self
     */
    public function setUltimateCustomerOrderReferencedDocument(?array $ultimateCustomerOrderReferencedDocument = null)
    {
        $this->ultimateCustomerOrderReferencedDocument = $ultimateCustomerOrderReferencedDocument;
        return $this;
    }
}
