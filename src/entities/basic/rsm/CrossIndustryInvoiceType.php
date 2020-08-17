<?php

namespace horstoeko\zugferd\basic\rsm;

/**
 * Class representing CrossIndustryInvoiceType
 *
 *
 * XSD Type: CrossIndustryInvoiceType
 */
class CrossIndustryInvoiceType
{

    /**
     * @var \horstoeko\zugferd\basic\ram\ExchangedDocumentContextType $exchangedDocumentContext
     */
    private $exchangedDocumentContext = null;

    /**
     * @var \horstoeko\zugferd\basic\ram\ExchangedDocumentType $exchangedDocument
     */
    private $exchangedDocument = null;

    /**
     * @var \horstoeko\zugferd\basic\ram\SupplyChainTradeTransactionType $supplyChainTradeTransaction
     */
    private $supplyChainTradeTransaction = null;

    /**
     * Gets as exchangedDocumentContext
     *
     * @return \horstoeko\zugferd\basic\ram\ExchangedDocumentContextType
     */
    public function getExchangedDocumentContext()
    {
        return $this->exchangedDocumentContext;
    }

    /**
     * Sets a new exchangedDocumentContext
     *
     * @param \horstoeko\zugferd\basic\ram\ExchangedDocumentContextType $exchangedDocumentContext
     * @return self
     */
    public function setExchangedDocumentContext(\horstoeko\zugferd\basic\ram\ExchangedDocumentContextType $exchangedDocumentContext)
    {
        $this->exchangedDocumentContext = $exchangedDocumentContext;
        return $this;
    }

    /**
     * Gets as exchangedDocument
     *
     * @return \horstoeko\zugferd\basic\ram\ExchangedDocumentType
     */
    public function getExchangedDocument()
    {
        return $this->exchangedDocument;
    }

    /**
     * Sets a new exchangedDocument
     *
     * @param \horstoeko\zugferd\basic\ram\ExchangedDocumentType $exchangedDocument
     * @return self
     */
    public function setExchangedDocument(\horstoeko\zugferd\basic\ram\ExchangedDocumentType $exchangedDocument)
    {
        $this->exchangedDocument = $exchangedDocument;
        return $this;
    }

    /**
     * Gets as supplyChainTradeTransaction
     *
     * @return \horstoeko\zugferd\basic\ram\SupplyChainTradeTransactionType
     */
    public function getSupplyChainTradeTransaction()
    {
        return $this->supplyChainTradeTransaction;
    }

    /**
     * Sets a new supplyChainTradeTransaction
     *
     * @param \horstoeko\zugferd\basic\ram\SupplyChainTradeTransactionType $supplyChainTradeTransaction
     * @return self
     */
    public function setSupplyChainTradeTransaction(\horstoeko\zugferd\basic\ram\SupplyChainTradeTransactionType $supplyChainTradeTransaction)
    {
        $this->supplyChainTradeTransaction = $supplyChainTradeTransaction;
        return $this;
    }


}

