<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing HeaderTradeSettlementType
 *
 *
 * XSD Type: HeaderTradeSettlementType
 */
class HeaderTradeSettlementType
{

    /**
     * @property \horstoeko\zugferd\udt\IDType $creditorReferenceID
     */
    private $creditorReferenceID = null;

    /**
     * @property string $paymentReference
     */
    private $paymentReference = null;

    /**
     * @property string $taxCurrencyCode
     */
    private $taxCurrencyCode = null;

    /**
     * @property string $invoiceCurrencyCode
     */
    private $invoiceCurrencyCode = null;

    /**
     * @property string $invoiceIssuerReference
     */
    private $invoiceIssuerReference = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePartyType $invoicerTradeParty
     */
    private $invoicerTradeParty = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePartyType $invoiceeTradeParty
     */
    private $invoiceeTradeParty = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePartyType $payeeTradeParty
     */
    private $payeeTradeParty = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeCurrencyExchangeType
     * $taxApplicableTradeCurrencyExchange
     */
    private $taxApplicableTradeCurrencyExchange = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeSettlementPaymentMeansType[]
     * $specifiedTradeSettlementPaymentMeans
     */
    private $specifiedTradeSettlementPaymentMeans = null;

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
     * @property \horstoeko\zugferd\ram\LogisticsServiceChargeType[]
     * $specifiedLogisticsServiceCharge
     */
    private $specifiedLogisticsServiceCharge = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePaymentTermsType[]
     * $specifiedTradePaymentTerms
     */
    private $specifiedTradePaymentTerms = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeSettlementHeaderMonetarySummationType
     * $specifiedTradeSettlementHeaderMonetarySummation
     */
    private $specifiedTradeSettlementHeaderMonetarySummation = null;

    /**
     * @property \horstoeko\zugferd\ram\ReferencedDocumentType
     * $invoiceReferencedDocument
     */
    private $invoiceReferencedDocument = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeAccountingAccountType[]
     * $receivableSpecifiedTradeAccountingAccount
     */
    private $receivableSpecifiedTradeAccountingAccount = null;

    /**
     * @property \horstoeko\zugferd\ram\AdvancePaymentType[] $specifiedAdvancePayment
     */
    private $specifiedAdvancePayment = null;

    /**
     * Gets as creditorReferenceID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getCreditorReferenceID()
    {
        return $this->creditorReferenceID;
    }

    /**
     * Sets a new creditorReferenceID
     *
     * @param \horstoeko\zugferd\udt\IDType $creditorReferenceID
     * @return self
     */
    public function setCreditorReferenceID(\horstoeko\zugferd\udt\IDType $creditorReferenceID)
    {
        $this->creditorReferenceID = $creditorReferenceID;
        return $this;
    }

    /**
     * Gets as paymentReference
     *
     * @return string
     */
    public function getPaymentReference()
    {
        return $this->paymentReference;
    }

    /**
     * Sets a new paymentReference
     *
     * @param string $paymentReference
     * @return self
     */
    public function setPaymentReference($paymentReference)
    {
        $this->paymentReference = $paymentReference;
        return $this;
    }

    /**
     * Gets as taxCurrencyCode
     *
     * @return string
     */
    public function getTaxCurrencyCode()
    {
        return $this->taxCurrencyCode;
    }

    /**
     * Sets a new taxCurrencyCode
     *
     * @param string $taxCurrencyCode
     * @return self
     */
    public function setTaxCurrencyCode($taxCurrencyCode)
    {
        $this->taxCurrencyCode = $taxCurrencyCode;
        return $this;
    }

    /**
     * Gets as invoiceCurrencyCode
     *
     * @return string
     */
    public function getInvoiceCurrencyCode()
    {
        return $this->invoiceCurrencyCode;
    }

    /**
     * Sets a new invoiceCurrencyCode
     *
     * @param string $invoiceCurrencyCode
     * @return self
     */
    public function setInvoiceCurrencyCode($invoiceCurrencyCode)
    {
        $this->invoiceCurrencyCode = $invoiceCurrencyCode;
        return $this;
    }

    /**
     * Gets as invoiceIssuerReference
     *
     * @return string
     */
    public function getInvoiceIssuerReference()
    {
        return $this->invoiceIssuerReference;
    }

    /**
     * Sets a new invoiceIssuerReference
     *
     * @param string $invoiceIssuerReference
     * @return self
     */
    public function setInvoiceIssuerReference($invoiceIssuerReference)
    {
        $this->invoiceIssuerReference = $invoiceIssuerReference;
        return $this;
    }

    /**
     * Gets as invoicerTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getInvoicerTradeParty()
    {
        return $this->invoicerTradeParty;
    }

    /**
     * Sets a new invoicerTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $invoicerTradeParty
     * @return self
     */
    public function setInvoicerTradeParty(\horstoeko\zugferd\ram\TradePartyType $invoicerTradeParty)
    {
        $this->invoicerTradeParty = $invoicerTradeParty;
        return $this;
    }

    /**
     * Gets as invoiceeTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getInvoiceeTradeParty()
    {
        return $this->invoiceeTradeParty;
    }

    /**
     * Sets a new invoiceeTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $invoiceeTradeParty
     * @return self
     */
    public function setInvoiceeTradeParty(\horstoeko\zugferd\ram\TradePartyType $invoiceeTradeParty)
    {
        $this->invoiceeTradeParty = $invoiceeTradeParty;
        return $this;
    }

    /**
     * Gets as payeeTradeParty
     *
     * @return \horstoeko\zugferd\ram\TradePartyType
     */
    public function getPayeeTradeParty()
    {
        return $this->payeeTradeParty;
    }

    /**
     * Sets a new payeeTradeParty
     *
     * @param \horstoeko\zugferd\ram\TradePartyType $payeeTradeParty
     * @return self
     */
    public function setPayeeTradeParty(\horstoeko\zugferd\ram\TradePartyType $payeeTradeParty)
    {
        $this->payeeTradeParty = $payeeTradeParty;
        return $this;
    }

    /**
     * Gets as taxApplicableTradeCurrencyExchange
     *
     * @return \horstoeko\zugferd\ram\TradeCurrencyExchangeType
     */
    public function getTaxApplicableTradeCurrencyExchange()
    {
        return $this->taxApplicableTradeCurrencyExchange;
    }

    /**
     * Sets a new taxApplicableTradeCurrencyExchange
     *
     * @param \horstoeko\zugferd\ram\TradeCurrencyExchangeType
     * $taxApplicableTradeCurrencyExchange
     * @return self
     */
    public function setTaxApplicableTradeCurrencyExchange(\horstoeko\zugferd\ram\TradeCurrencyExchangeType $taxApplicableTradeCurrencyExchange)
    {
        $this->taxApplicableTradeCurrencyExchange = $taxApplicableTradeCurrencyExchange;
        return $this;
    }

    /**
     * Adds as specifiedTradeSettlementPaymentMeans
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TradeSettlementPaymentMeansType
     * $specifiedTradeSettlementPaymentMeans
     */
    public function addToSpecifiedTradeSettlementPaymentMeans(\horstoeko\zugferd\ram\TradeSettlementPaymentMeansType $specifiedTradeSettlementPaymentMeans)
    {
        $this->specifiedTradeSettlementPaymentMeans[] = $specifiedTradeSettlementPaymentMeans;
        return $this;
    }

    /**
     * isset specifiedTradeSettlementPaymentMeans
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSpecifiedTradeSettlementPaymentMeans($index)
    {
        return isset($this->specifiedTradeSettlementPaymentMeans[$index]);
    }

    /**
     * unset specifiedTradeSettlementPaymentMeans
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSpecifiedTradeSettlementPaymentMeans($index)
    {
        unset($this->specifiedTradeSettlementPaymentMeans[$index]);
    }

    /**
     * Gets as specifiedTradeSettlementPaymentMeans
     *
     * @return \horstoeko\zugferd\ram\TradeSettlementPaymentMeansType[]
     */
    public function getSpecifiedTradeSettlementPaymentMeans()
    {
        return $this->specifiedTradeSettlementPaymentMeans;
    }

    /**
     * Sets a new specifiedTradeSettlementPaymentMeans
     *
     * @param \horstoeko\zugferd\ram\TradeSettlementPaymentMeansType[]
     * $specifiedTradeSettlementPaymentMeans
     * @return self
     */
    public function setSpecifiedTradeSettlementPaymentMeans(array $specifiedTradeSettlementPaymentMeans)
    {
        $this->specifiedTradeSettlementPaymentMeans = $specifiedTradeSettlementPaymentMeans;
        return $this;
    }

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
     * Adds as specifiedLogisticsServiceCharge
     *
     * @return self
     * @param \horstoeko\zugferd\ram\LogisticsServiceChargeType
     * $specifiedLogisticsServiceCharge
     */
    public function addToSpecifiedLogisticsServiceCharge(\horstoeko\zugferd\ram\LogisticsServiceChargeType $specifiedLogisticsServiceCharge)
    {
        $this->specifiedLogisticsServiceCharge[] = $specifiedLogisticsServiceCharge;
        return $this;
    }

    /**
     * isset specifiedLogisticsServiceCharge
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSpecifiedLogisticsServiceCharge($index)
    {
        return isset($this->specifiedLogisticsServiceCharge[$index]);
    }

    /**
     * unset specifiedLogisticsServiceCharge
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSpecifiedLogisticsServiceCharge($index)
    {
        unset($this->specifiedLogisticsServiceCharge[$index]);
    }

    /**
     * Gets as specifiedLogisticsServiceCharge
     *
     * @return \horstoeko\zugferd\ram\LogisticsServiceChargeType[]
     */
    public function getSpecifiedLogisticsServiceCharge()
    {
        return $this->specifiedLogisticsServiceCharge;
    }

    /**
     * Sets a new specifiedLogisticsServiceCharge
     *
     * @param \horstoeko\zugferd\ram\LogisticsServiceChargeType[]
     * $specifiedLogisticsServiceCharge
     * @return self
     */
    public function setSpecifiedLogisticsServiceCharge(array $specifiedLogisticsServiceCharge)
    {
        $this->specifiedLogisticsServiceCharge = $specifiedLogisticsServiceCharge;
        return $this;
    }

    /**
     * Adds as specifiedTradePaymentTerms
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TradePaymentTermsType $specifiedTradePaymentTerms
     */
    public function addToSpecifiedTradePaymentTerms(\horstoeko\zugferd\ram\TradePaymentTermsType $specifiedTradePaymentTerms)
    {
        $this->specifiedTradePaymentTerms[] = $specifiedTradePaymentTerms;
        return $this;
    }

    /**
     * isset specifiedTradePaymentTerms
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSpecifiedTradePaymentTerms($index)
    {
        return isset($this->specifiedTradePaymentTerms[$index]);
    }

    /**
     * unset specifiedTradePaymentTerms
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSpecifiedTradePaymentTerms($index)
    {
        unset($this->specifiedTradePaymentTerms[$index]);
    }

    /**
     * Gets as specifiedTradePaymentTerms
     *
     * @return \horstoeko\zugferd\ram\TradePaymentTermsType[]
     */
    public function getSpecifiedTradePaymentTerms()
    {
        return $this->specifiedTradePaymentTerms;
    }

    /**
     * Sets a new specifiedTradePaymentTerms
     *
     * @param \horstoeko\zugferd\ram\TradePaymentTermsType[]
     * $specifiedTradePaymentTerms
     * @return self
     */
    public function setSpecifiedTradePaymentTerms(array $specifiedTradePaymentTerms)
    {
        $this->specifiedTradePaymentTerms = $specifiedTradePaymentTerms;
        return $this;
    }

    /**
     * Gets as specifiedTradeSettlementHeaderMonetarySummation
     *
     * @return \horstoeko\zugferd\ram\TradeSettlementHeaderMonetarySummationType
     */
    public function getSpecifiedTradeSettlementHeaderMonetarySummation()
    {
        return $this->specifiedTradeSettlementHeaderMonetarySummation;
    }

    /**
     * Sets a new specifiedTradeSettlementHeaderMonetarySummation
     *
     * @param \horstoeko\zugferd\ram\TradeSettlementHeaderMonetarySummationType
     * $specifiedTradeSettlementHeaderMonetarySummation
     * @return self
     */
    public function setSpecifiedTradeSettlementHeaderMonetarySummation(\horstoeko\zugferd\ram\TradeSettlementHeaderMonetarySummationType $specifiedTradeSettlementHeaderMonetarySummation)
    {
        $this->specifiedTradeSettlementHeaderMonetarySummation = $specifiedTradeSettlementHeaderMonetarySummation;
        return $this;
    }

    /**
     * Gets as invoiceReferencedDocument
     *
     * @return \horstoeko\zugferd\ram\ReferencedDocumentType
     */
    public function getInvoiceReferencedDocument()
    {
        return $this->invoiceReferencedDocument;
    }

    /**
     * Sets a new invoiceReferencedDocument
     *
     * @param \horstoeko\zugferd\ram\ReferencedDocumentType $invoiceReferencedDocument
     * @return self
     */
    public function setInvoiceReferencedDocument(\horstoeko\zugferd\ram\ReferencedDocumentType $invoiceReferencedDocument)
    {
        $this->invoiceReferencedDocument = $invoiceReferencedDocument;
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

    /**
     * Adds as specifiedAdvancePayment
     *
     * @return self
     * @param \horstoeko\zugferd\ram\AdvancePaymentType $specifiedAdvancePayment
     */
    public function addToSpecifiedAdvancePayment(\horstoeko\zugferd\ram\AdvancePaymentType $specifiedAdvancePayment)
    {
        $this->specifiedAdvancePayment[] = $specifiedAdvancePayment;
        return $this;
    }

    /**
     * isset specifiedAdvancePayment
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSpecifiedAdvancePayment($index)
    {
        return isset($this->specifiedAdvancePayment[$index]);
    }

    /**
     * unset specifiedAdvancePayment
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSpecifiedAdvancePayment($index)
    {
        unset($this->specifiedAdvancePayment[$index]);
    }

    /**
     * Gets as specifiedAdvancePayment
     *
     * @return \horstoeko\zugferd\ram\AdvancePaymentType[]
     */
    public function getSpecifiedAdvancePayment()
    {
        return $this->specifiedAdvancePayment;
    }

    /**
     * Sets a new specifiedAdvancePayment
     *
     * @param \horstoeko\zugferd\ram\AdvancePaymentType[] $specifiedAdvancePayment
     * @return self
     */
    public function setSpecifiedAdvancePayment(array $specifiedAdvancePayment)
    {
        $this->specifiedAdvancePayment = $specifiedAdvancePayment;
        return $this;
    }


}

