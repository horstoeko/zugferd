<?php

namespace horstoeko\zugferd\basicwl\rsm;

/**
 * Class representing CrossIndustryInvoiceType
 *
 *
 * XSD Type: CrossIndustryInvoiceType
 */
class CrossIndustryInvoiceType
{

    /**
     * @var \horstoeko\zugferd\basicwl\ram\ExchangedDocumentContextType $exchangedDocumentContext
     */
    private $exchangedDocumentContext = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\ExchangedDocumentType $exchangedDocument
     */
    private $exchangedDocument = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\SupplyChainTradeTransactionType $supplyChainTradeTransaction
     */
    private $supplyChainTradeTransaction = null;

    /**
     * Gets as exchangedDocumentContext
     *
     * @return \horstoeko\zugferd\basicwl\ram\ExchangedDocumentContextType
     */
    public function getExchangedDocumentContext()
    {
        return $this->exchangedDocumentContext;
    }

    /**
     * Sets a new exchangedDocumentContext
     *
     * @param \horstoeko\zugferd\basicwl\ram\ExchangedDocumentContextType $exchangedDocumentContext
     * @return self
     */
    public function setExchangedDocumentContext(\horstoeko\zugferd\basicwl\ram\ExchangedDocumentContextType $exchangedDocumentContext)
    {
        $this->exchangedDocumentContext = $exchangedDocumentContext;
        return $this;
    }

    /**
     * Gets as exchangedDocument
     *
     * @return \horstoeko\zugferd\basicwl\ram\ExchangedDocumentType
     */
    public function getExchangedDocument()
    {
        return $this->exchangedDocument;
    }

    /**
     * Sets a new exchangedDocument
     *
     * @param \horstoeko\zugferd\basicwl\ram\ExchangedDocumentType $exchangedDocument
     * @return self
     */
    public function setExchangedDocument(\horstoeko\zugferd\basicwl\ram\ExchangedDocumentType $exchangedDocument)
    {
        $this->exchangedDocument = $exchangedDocument;
        return $this;
    }

    /**
     * Gets as supplyChainTradeTransaction
     *
     * @return \horstoeko\zugferd\basicwl\ram\SupplyChainTradeTransactionType
     */
    public function getSupplyChainTradeTransaction()
    {
        return $this->supplyChainTradeTransaction;
    }

    /**
     * Sets a new supplyChainTradeTransaction
     *
     * @param \horstoeko\zugferd\basicwl\ram\SupplyChainTradeTransactionType $supplyChainTradeTransaction
     * @return self
     */
    public function setSupplyChainTradeTransaction(\horstoeko\zugferd\basicwl\ram\SupplyChainTradeTransactionType $supplyChainTradeTransaction)
    {
        $this->supplyChainTradeTransaction = $supplyChainTradeTransaction;
        return $this;
    }


}

