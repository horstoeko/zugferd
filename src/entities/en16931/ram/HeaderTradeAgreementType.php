<?php

namespace horstoeko\zugferd\entities\en16931\ram;

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
     * @var \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null $sellerTradeParty
     */
    private $sellerTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null $buyerTradeParty
     */
    private $buyerTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null $sellerTaxRepresentativeTradeParty
     */
    private $sellerTaxRepresentativeTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null $sellerOrderReferencedDocument
     */
    private $sellerOrderReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null $buyerOrderReferencedDocument
     */
    private $buyerOrderReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null $contractReferencedDocument
     */
    private $contractReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType[] $additionalReferencedDocument
     */
    private $additionalReferencedDocument = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\ProcuringProjectType|null $specifiedProcuringProject
     */
    private $specifiedProcuringProject = null;

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
     * @return \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null
     */
    public function getSellerTradeParty()
    {
        return $this->sellerTradeParty;
    }

    /**
     * Sets a new sellerTradeParty
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradePartyType $sellerTradeParty
     * @return self
     */
    public function setSellerTradeParty(\horstoeko\zugferd\entities\en16931\ram\TradePartyType $sellerTradeParty)
    {
        $this->sellerTradeParty = $sellerTradeParty;
        return $this;
    }

    /**
     * Gets as buyerTradeParty
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null
     */
    public function getBuyerTradeParty()
    {
        return $this->buyerTradeParty;
    }

    /**
     * Sets a new buyerTradeParty
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradePartyType $buyerTradeParty
     * @return self
     */
    public function setBuyerTradeParty(\horstoeko\zugferd\entities\en16931\ram\TradePartyType $buyerTradeParty)
    {
        $this->buyerTradeParty = $buyerTradeParty;
        return $this;
    }

    /**
     * Gets as sellerTaxRepresentativeTradeParty
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null
     */
    public function getSellerTaxRepresentativeTradeParty()
    {
        return $this->sellerTaxRepresentativeTradeParty;
    }

    /**
     * Sets a new sellerTaxRepresentativeTradeParty
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null $sellerTaxRepresentativeTradeParty
     * @return self
     */
    public function setSellerTaxRepresentativeTradeParty(?\horstoeko\zugferd\entities\en16931\ram\TradePartyType $sellerTaxRepresentativeTradeParty = null)
    {
        $this->sellerTaxRepresentativeTradeParty = $sellerTaxRepresentativeTradeParty;
        return $this;
    }

    /**
     * Gets as sellerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null
     */
    public function getSellerOrderReferencedDocument()
    {
        return $this->sellerOrderReferencedDocument;
    }

    /**
     * Sets a new sellerOrderReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null $sellerOrderReferencedDocument
     * @return self
     */
    public function setSellerOrderReferencedDocument(?\horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType $sellerOrderReferencedDocument = null)
    {
        $this->sellerOrderReferencedDocument = $sellerOrderReferencedDocument;
        return $this;
    }

    /**
     * Gets as buyerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null
     */
    public function getBuyerOrderReferencedDocument()
    {
        return $this->buyerOrderReferencedDocument;
    }

    /**
     * Sets a new buyerOrderReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null $buyerOrderReferencedDocument
     * @return self
     */
    public function setBuyerOrderReferencedDocument(?\horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType $buyerOrderReferencedDocument = null)
    {
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;
        return $this;
    }

    /**
     * Gets as contractReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null
     */
    public function getContractReferencedDocument()
    {
        return $this->contractReferencedDocument;
    }

    /**
     * Sets a new contractReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType|null $contractReferencedDocument
     * @return self
     */
    public function setContractReferencedDocument(?\horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType $contractReferencedDocument = null)
    {
        $this->contractReferencedDocument = $contractReferencedDocument;
        return $this;
    }

    /**
     * Adds as additionalReferencedDocument
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType $additionalReferencedDocument
     */
    public function addToAdditionalReferencedDocument(\horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType $additionalReferencedDocument)
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
     * @return \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType[]
     */
    public function getAdditionalReferencedDocument()
    {
        return $this->additionalReferencedDocument;
    }

    /**
     * Sets a new additionalReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType[]|null $additionalReferencedDocument
     * @return self
     */
    public function setAdditionalReferencedDocument(?array $additionalReferencedDocument = null)
    {
        $this->additionalReferencedDocument = $additionalReferencedDocument;
        return $this;
    }

    /**
     * Gets as specifiedProcuringProject
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\ProcuringProjectType|null
     */
    public function getSpecifiedProcuringProject()
    {
        return $this->specifiedProcuringProject;
    }

    /**
     * Sets a new specifiedProcuringProject
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\ProcuringProjectType|null $specifiedProcuringProject
     * @return self
     */
    public function setSpecifiedProcuringProject(?\horstoeko\zugferd\entities\en16931\ram\ProcuringProjectType $specifiedProcuringProject = null)
    {
        $this->specifiedProcuringProject = $specifiedProcuringProject;
        return $this;
    }
}
