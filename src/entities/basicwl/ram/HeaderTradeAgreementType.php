<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing HeaderTradeAgreementType
 *
 *
 * XSD Type: HeaderTradeAgreementType
 */
class HeaderTradeAgreementType
{

    /**
     * @var string $buyerReference
     */
    private $buyerReference = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\TradePartyType $sellerTradeParty
     */
    private $sellerTradeParty = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\TradePartyType $buyerTradeParty
     */
    private $buyerTradeParty = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\TradePartyType $sellerTaxRepresentativeTradeParty
     */
    private $sellerTaxRepresentativeTradeParty = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $buyerOrderReferencedDocument
     */
    private $buyerOrderReferencedDocument = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $contractReferencedDocument
     */
    private $contractReferencedDocument = null;

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
     * @return \horstoeko\zugferd\basicwl\ram\TradePartyType
     */
    public function getSellerTradeParty()
    {
        return $this->sellerTradeParty;
    }

    /**
     * Sets a new sellerTradeParty
     *
     * @param \horstoeko\zugferd\basicwl\ram\TradePartyType $sellerTradeParty
     * @return self
     */
    public function setSellerTradeParty(\horstoeko\zugferd\basicwl\ram\TradePartyType $sellerTradeParty)
    {
        $this->sellerTradeParty = $sellerTradeParty;
        return $this;
    }

    /**
     * Gets as buyerTradeParty
     *
     * @return \horstoeko\zugferd\basicwl\ram\TradePartyType
     */
    public function getBuyerTradeParty()
    {
        return $this->buyerTradeParty;
    }

    /**
     * Sets a new buyerTradeParty
     *
     * @param \horstoeko\zugferd\basicwl\ram\TradePartyType $buyerTradeParty
     * @return self
     */
    public function setBuyerTradeParty(\horstoeko\zugferd\basicwl\ram\TradePartyType $buyerTradeParty)
    {
        $this->buyerTradeParty = $buyerTradeParty;
        return $this;
    }

    /**
     * Gets as sellerTaxRepresentativeTradeParty
     *
     * @return \horstoeko\zugferd\basicwl\ram\TradePartyType
     */
    public function getSellerTaxRepresentativeTradeParty()
    {
        return $this->sellerTaxRepresentativeTradeParty;
    }

    /**
     * Sets a new sellerTaxRepresentativeTradeParty
     *
     * @param \horstoeko\zugferd\basicwl\ram\TradePartyType $sellerTaxRepresentativeTradeParty
     * @return self
     */
    public function setSellerTaxRepresentativeTradeParty(\horstoeko\zugferd\basicwl\ram\TradePartyType $sellerTaxRepresentativeTradeParty)
    {
        $this->sellerTaxRepresentativeTradeParty = $sellerTaxRepresentativeTradeParty;
        return $this;
    }

    /**
     * Gets as buyerOrderReferencedDocument
     *
     * @return \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType
     */
    public function getBuyerOrderReferencedDocument()
    {
        return $this->buyerOrderReferencedDocument;
    }

    /**
     * Sets a new buyerOrderReferencedDocument
     *
     * @param \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $buyerOrderReferencedDocument
     * @return self
     */
    public function setBuyerOrderReferencedDocument(\horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $buyerOrderReferencedDocument)
    {
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;
        return $this;
    }

    /**
     * Gets as contractReferencedDocument
     *
     * @return \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType
     */
    public function getContractReferencedDocument()
    {
        return $this->contractReferencedDocument;
    }

    /**
     * Sets a new contractReferencedDocument
     *
     * @param \horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $contractReferencedDocument
     * @return self
     */
    public function setContractReferencedDocument(\horstoeko\zugferd\basicwl\ram\ReferencedDocumentType $contractReferencedDocument)
    {
        $this->contractReferencedDocument = $contractReferencedDocument;
        return $this;
    }


}

