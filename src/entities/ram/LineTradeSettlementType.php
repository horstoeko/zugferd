<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing LineTradeSettlementType
 *
 *
 * XSD Type: LineTradeSettlementType
 */
class LineTradeSettlementType
{

    /**
     * @property \horstoeko\zugferd\ram\TradeTaxType[] $applicableTradeTax
     */
    private $applicableTradeTax = null;

    /**
     * @property \horstoeko\zugferd\ram\SpecifiedPeriodType $billingSpecifiedPeriod
     */
    private $billingSpecifiedPeriod = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeAllowanceChargeType[]
     * $specifiedTradeAllowanceCharge
     */
    private $specifiedTradeAllowanceCharge = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeSettlementLineMonetarySummationType
     * $specifiedTradeSettlementLineMonetarySummation
     */
    private $specifiedTradeSettlementLineMonetarySummation = null;

    /**
     * @property \horstoeko\zugferd\ram\ReferencedDocumentType[]
     * $additionalReferencedDocument
     */
    private $additionalReferencedDocument = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeAccountingAccountType[]
     * $receivableSpecifiedTradeAccountingAccount
     */
    private $receivableSpecifiedTradeAccountingAccount = null;

    /**
     * Adds as applicableTradeTax
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TradeTaxType $applicableTradeTax
     */
    public function addToApplicableTradeTax(\horstoeko\zugferd\ram\TradeTaxType $applicableTradeTax)
    {
        $this->applicableTradeTax[] = $applicableTradeTax;
        return $this;
    }

    /**
     * isset applicableTradeTax
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetApplicableTradeTax($index)
    {
        return isset($this->applicableTradeTax[$index]);
    }

    /**
     * unset applicableTradeTax
     *
     * @param scalar $index
     * @return void
     */
    public function unsetApplicableTradeTax($index)
    {
        unset($this->applicableTradeTax[$index]);
    }

    /**
     * Gets as applicableTradeTax
     *
     * @return \horstoeko\zugferd\ram\TradeTaxType[]
     */
    public function getApplicableTradeTax()
    {
        return $this->applicableTradeTax;
    }

    /**
     * Sets a new applicableTradeTax
     *
     * @param \horstoeko\zugferd\ram\TradeTaxType[] $applicableTradeTax
     * @return self
     */
    public function setApplicableTradeTax(array $applicableTradeTax)
    {
        $this->applicableTradeTax = $applicableTradeTax;
        return $this;
    }

    /**
     * Gets as billingSpecifiedPeriod
     *
     * @return \horstoeko\zugferd\ram\SpecifiedPeriodType
     */
    public function getBillingSpecifiedPeriod()
    {
        return $this->billingSpecifiedPeriod;
    }

    /**
     * Sets a new billingSpecifiedPeriod
     *
     * @param \horstoeko\zugferd\ram\SpecifiedPeriodType $billingSpecifiedPeriod
     * @return self
     */
    public function setBillingSpecifiedPeriod(\horstoeko\zugferd\ram\SpecifiedPeriodType $billingSpecifiedPeriod)
    {
        $this->billingSpecifiedPeriod = $billingSpecifiedPeriod;
        return $this;
    }

    /**
     * Adds as specifiedTradeAllowanceCharge
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TradeAllowanceChargeType
     * $specifiedTradeAllowanceCharge
     */
    public function addToSpecifiedTradeAllowanceCharge(\horstoeko\zugferd\ram\TradeAllowanceChargeType $specifiedTradeAllowanceCharge)
    {
        $this->specifiedTradeAllowanceCharge[] = $specifiedTradeAllowanceCharge;
        return $this;
    }

    /**
     * isset specifiedTradeAllowanceCharge
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSpecifiedTradeAllowanceCharge($index)
    {
        return isset($this->specifiedTradeAllowanceCharge[$index]);
    }

    /**
     * unset specifiedTradeAllowanceCharge
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSpecifiedTradeAllowanceCharge($index)
    {
        unset($this->specifiedTradeAllowanceCharge[$index]);
    }

    /**
     * Gets as specifiedTradeAllowanceCharge
     *
     * @return \horstoeko\zugferd\ram\TradeAllowanceChargeType[]
     */
    public function getSpecifiedTradeAllowanceCharge()
    {
        return $this->specifiedTradeAllowanceCharge;
    }

    /**
     * Sets a new specifiedTradeAllowanceCharge
     *
     * @param \horstoeko\zugferd\ram\TradeAllowanceChargeType[]
     * $specifiedTradeAllowanceCharge
     * @return self
     */
    public function setSpecifiedTradeAllowanceCharge(array $specifiedTradeAllowanceCharge)
    {
        $this->specifiedTradeAllowanceCharge = $specifiedTradeAllowanceCharge;
        return $this;
    }

    /**
     * Gets as specifiedTradeSettlementLineMonetarySummation
     *
     * @return \horstoeko\zugferd\ram\TradeSettlementLineMonetarySummationType
     */
    public function getSpecifiedTradeSettlementLineMonetarySummation()
    {
        return $this->specifiedTradeSettlementLineMonetarySummation;
    }

    /**
     * Sets a new specifiedTradeSettlementLineMonetarySummation
     *
     * @param \horstoeko\zugferd\ram\TradeSettlementLineMonetarySummationType
     * $specifiedTradeSettlementLineMonetarySummation
     * @return self
     */
    public function setSpecifiedTradeSettlementLineMonetarySummation(\horstoeko\zugferd\ram\TradeSettlementLineMonetarySummationType $specifiedTradeSettlementLineMonetarySummation)
    {
        $this->specifiedTradeSettlementLineMonetarySummation = $specifiedTradeSettlementLineMonetarySummation;
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
     * Adds as receivableSpecifiedTradeAccountingAccount
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TradeAccountingAccountType
     * $receivableSpecifiedTradeAccountingAccount
     */
    public function addToReceivableSpecifiedTradeAccountingAccount(\horstoeko\zugferd\ram\TradeAccountingAccountType $receivableSpecifiedTradeAccountingAccount)
    {
        $this->receivableSpecifiedTradeAccountingAccount[] = $receivableSpecifiedTradeAccountingAccount;
        return $this;
    }

    /**
     * isset receivableSpecifiedTradeAccountingAccount
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetReceivableSpecifiedTradeAccountingAccount($index)
    {
        return isset($this->receivableSpecifiedTradeAccountingAccount[$index]);
    }

    /**
     * unset receivableSpecifiedTradeAccountingAccount
     *
     * @param scalar $index
     * @return void
     */
    public function unsetReceivableSpecifiedTradeAccountingAccount($index)
    {
        unset($this->receivableSpecifiedTradeAccountingAccount[$index]);
    }

    /**
     * Gets as receivableSpecifiedTradeAccountingAccount
     *
     * @return \horstoeko\zugferd\ram\TradeAccountingAccountType[]
     */
    public function getReceivableSpecifiedTradeAccountingAccount()
    {
        return $this->receivableSpecifiedTradeAccountingAccount;
    }

    /**
     * Sets a new receivableSpecifiedTradeAccountingAccount
     *
     * @param \horstoeko\zugferd\ram\TradeAccountingAccountType[]
     * $receivableSpecifiedTradeAccountingAccount
     * @return self
     */
    public function setReceivableSpecifiedTradeAccountingAccount(array $receivableSpecifiedTradeAccountingAccount)
    {
        $this->receivableSpecifiedTradeAccountingAccount = $receivableSpecifiedTradeAccountingAccount;
        return $this;
    }


}

