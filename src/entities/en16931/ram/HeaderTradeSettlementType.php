<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing HeaderTradeSettlementType
 *
 * XSD Type: HeaderTradeSettlementType
 */
class HeaderTradeSettlementType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType|null $creditorReferenceID
     */
    private $creditorReferenceID = null;

    /**
     * @var string|null $paymentReference
     */
    private $paymentReference = null;

    /**
     * @var string|null $taxCurrencyCode
     */
    private $taxCurrencyCode = null;

    /**
     * @var string|null $invoiceCurrencyCode
     */
    private $invoiceCurrencyCode = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null $payeeTradeParty
     */
    private $payeeTradeParty = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradeSettlementPaymentMeansType[] $specifiedTradeSettlementPaymentMeans
     */
    private $specifiedTradeSettlementPaymentMeans = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradeTaxType[] $applicableTradeTax
     */
    private $applicableTradeTax = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\SpecifiedPeriodType|null $billingSpecifiedPeriod
     */
    private $billingSpecifiedPeriod = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType[] $specifiedTradeAllowanceCharge
     */
    private $specifiedTradeAllowanceCharge = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradePaymentTermsType|null $specifiedTradePaymentTerms
     */
    private $specifiedTradePaymentTerms = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradeSettlementHeaderMonetarySummationType|null $specifiedTradeSettlementHeaderMonetarySummation
     */
    private $specifiedTradeSettlementHeaderMonetarySummation = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType[] $invoiceReferencedDocument
     */
    private $invoiceReferencedDocument = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradeAccountingAccountType|null $receivableSpecifiedTradeAccountingAccount
     */
    private $receivableSpecifiedTradeAccountingAccount = null;

    /**
     * Gets as creditorReferenceID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType|null
     */
    public function getCreditorReferenceID()
    {
        return $this->creditorReferenceID;
    }

    /**
     * Sets a new creditorReferenceID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType|null $creditorReferenceID
     * @return self
     */
    public function setCreditorReferenceID(?\horstoeko\zugferd\entities\en16931\udt\IDType $creditorReferenceID = null)
    {
        $this->creditorReferenceID = $creditorReferenceID;
        return $this;
    }

    /**
     * Gets as paymentReference
     *
     * @return string|null
     */
    public function getPaymentReference()
    {
        return $this->paymentReference;
    }

    /**
     * Sets a new paymentReference
     *
     * @param  string $paymentReference
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
     * @return string|null
     */
    public function getTaxCurrencyCode()
    {
        return $this->taxCurrencyCode;
    }

    /**
     * Sets a new taxCurrencyCode
     *
     * @param  string $taxCurrencyCode
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
     * @return string|null
     */
    public function getInvoiceCurrencyCode()
    {
        return $this->invoiceCurrencyCode;
    }

    /**
     * Sets a new invoiceCurrencyCode
     *
     * @param  string $invoiceCurrencyCode
     * @return self
     */
    public function setInvoiceCurrencyCode($invoiceCurrencyCode)
    {
        $this->invoiceCurrencyCode = $invoiceCurrencyCode;
        return $this;
    }

    /**
     * Gets as payeeTradeParty
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null
     */
    public function getPayeeTradeParty()
    {
        return $this->payeeTradeParty;
    }

    /**
     * Sets a new payeeTradeParty
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradePartyType|null $payeeTradeParty
     * @return self
     */
    public function setPayeeTradeParty(?\horstoeko\zugferd\entities\en16931\ram\TradePartyType $payeeTradeParty = null)
    {
        $this->payeeTradeParty = $payeeTradeParty;
        return $this;
    }

    /**
     * Adds as specifiedTradeSettlementPaymentMeans
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeSettlementPaymentMeansType $specifiedTradeSettlementPaymentMeans
     */
    public function addToSpecifiedTradeSettlementPaymentMeans(\horstoeko\zugferd\entities\en16931\ram\TradeSettlementPaymentMeansType $specifiedTradeSettlementPaymentMeans)
    {
        $this->specifiedTradeSettlementPaymentMeans[] = $specifiedTradeSettlementPaymentMeans;
        return $this;
    }

    /**
     * isset specifiedTradeSettlementPaymentMeans
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetSpecifiedTradeSettlementPaymentMeans($index)
    {
        return isset($this->specifiedTradeSettlementPaymentMeans[$index]);
    }

    /**
     * unset specifiedTradeSettlementPaymentMeans
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetSpecifiedTradeSettlementPaymentMeans($index)
    {
        unset($this->specifiedTradeSettlementPaymentMeans[$index]);
    }

    /**
     * Gets as specifiedTradeSettlementPaymentMeans
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradeSettlementPaymentMeansType[]
     */
    public function getSpecifiedTradeSettlementPaymentMeans()
    {
        return $this->specifiedTradeSettlementPaymentMeans;
    }

    /**
     * Sets a new specifiedTradeSettlementPaymentMeans
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeSettlementPaymentMeansType[]|null $specifiedTradeSettlementPaymentMeans
     * @return self
     */
    public function setSpecifiedTradeSettlementPaymentMeans(?array $specifiedTradeSettlementPaymentMeans = null)
    {
        $this->specifiedTradeSettlementPaymentMeans = $specifiedTradeSettlementPaymentMeans;
        return $this;
    }

    /**
     * Adds as applicableTradeTax
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeTaxType $applicableTradeTax
     */
    public function addToApplicableTradeTax(\horstoeko\zugferd\entities\en16931\ram\TradeTaxType $applicableTradeTax)
    {
        $this->applicableTradeTax[] = $applicableTradeTax;
        return $this;
    }

    /**
     * isset applicableTradeTax
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetApplicableTradeTax($index)
    {
        return isset($this->applicableTradeTax[$index]);
    }

    /**
     * unset applicableTradeTax
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetApplicableTradeTax($index)
    {
        unset($this->applicableTradeTax[$index]);
    }

    /**
     * Gets as applicableTradeTax
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradeTaxType[]
     */
    public function getApplicableTradeTax()
    {
        return $this->applicableTradeTax;
    }

    /**
     * Sets a new applicableTradeTax
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeTaxType[] $applicableTradeTax
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
     * @return \horstoeko\zugferd\entities\en16931\ram\SpecifiedPeriodType|null
     */
    public function getBillingSpecifiedPeriod()
    {
        return $this->billingSpecifiedPeriod;
    }

    /**
     * Sets a new billingSpecifiedPeriod
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\SpecifiedPeriodType|null $billingSpecifiedPeriod
     * @return self
     */
    public function setBillingSpecifiedPeriod(?\horstoeko\zugferd\entities\en16931\ram\SpecifiedPeriodType $billingSpecifiedPeriod = null)
    {
        $this->billingSpecifiedPeriod = $billingSpecifiedPeriod;
        return $this;
    }

    /**
     * Adds as specifiedTradeAllowanceCharge
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType $specifiedTradeAllowanceCharge
     */
    public function addToSpecifiedTradeAllowanceCharge(\horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType $specifiedTradeAllowanceCharge)
    {
        $this->specifiedTradeAllowanceCharge[] = $specifiedTradeAllowanceCharge;
        return $this;
    }

    /**
     * isset specifiedTradeAllowanceCharge
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetSpecifiedTradeAllowanceCharge($index)
    {
        return isset($this->specifiedTradeAllowanceCharge[$index]);
    }

    /**
     * unset specifiedTradeAllowanceCharge
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetSpecifiedTradeAllowanceCharge($index)
    {
        unset($this->specifiedTradeAllowanceCharge[$index]);
    }

    /**
     * Gets as specifiedTradeAllowanceCharge
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType[]
     */
    public function getSpecifiedTradeAllowanceCharge()
    {
        return $this->specifiedTradeAllowanceCharge;
    }

    /**
     * Sets a new specifiedTradeAllowanceCharge
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType[]|null $specifiedTradeAllowanceCharge
     * @return self
     */
    public function setSpecifiedTradeAllowanceCharge(?array $specifiedTradeAllowanceCharge = null)
    {
        $this->specifiedTradeAllowanceCharge = $specifiedTradeAllowanceCharge;
        return $this;
    }

    /**
     * Gets as specifiedTradePaymentTerms
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradePaymentTermsType|null
     */
    public function getSpecifiedTradePaymentTerms()
    {
        return $this->specifiedTradePaymentTerms;
    }

    /**
     * Sets a new specifiedTradePaymentTerms
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradePaymentTermsType|null $specifiedTradePaymentTerms
     * @return self
     */
    public function setSpecifiedTradePaymentTerms(?\horstoeko\zugferd\entities\en16931\ram\TradePaymentTermsType $specifiedTradePaymentTerms = null)
    {
        $this->specifiedTradePaymentTerms = $specifiedTradePaymentTerms;
        return $this;
    }

    /**
     * Gets as specifiedTradeSettlementHeaderMonetarySummation
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradeSettlementHeaderMonetarySummationType|null
     */
    public function getSpecifiedTradeSettlementHeaderMonetarySummation()
    {
        return $this->specifiedTradeSettlementHeaderMonetarySummation;
    }

    /**
     * Sets a new specifiedTradeSettlementHeaderMonetarySummation
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeSettlementHeaderMonetarySummationType $specifiedTradeSettlementHeaderMonetarySummation
     * @return self
     */
    public function setSpecifiedTradeSettlementHeaderMonetarySummation(\horstoeko\zugferd\entities\en16931\ram\TradeSettlementHeaderMonetarySummationType $specifiedTradeSettlementHeaderMonetarySummation)
    {
        $this->specifiedTradeSettlementHeaderMonetarySummation = $specifiedTradeSettlementHeaderMonetarySummation;
        return $this;
    }

    /**
     * Adds as invoiceReferencedDocument
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType $invoiceReferencedDocument
     */
    public function addToInvoiceReferencedDocument(\horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType $invoiceReferencedDocument)
    {
        $this->invoiceReferencedDocument[] = $invoiceReferencedDocument;
        return $this;
    }

    /**
     * isset invoiceReferencedDocument
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetInvoiceReferencedDocument($index)
    {
        return isset($this->invoiceReferencedDocument[$index]);
    }

    /**
     * unset invoiceReferencedDocument
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetInvoiceReferencedDocument($index)
    {
        unset($this->invoiceReferencedDocument[$index]);
    }

    /**
     * Gets as invoiceReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType[]
     */
    public function getInvoiceReferencedDocument()
    {
        return $this->invoiceReferencedDocument;
    }

    /**
     * Sets a new invoiceReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\ReferencedDocumentType[]|null $invoiceReferencedDocument
     * @return self
     */
    public function setInvoiceReferencedDocument(?array $invoiceReferencedDocument = null)
    {
        $this->invoiceReferencedDocument = $invoiceReferencedDocument;
        return $this;
    }

    /**
     * Gets as receivableSpecifiedTradeAccountingAccount
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradeAccountingAccountType|null
     */
    public function getReceivableSpecifiedTradeAccountingAccount()
    {
        return $this->receivableSpecifiedTradeAccountingAccount;
    }

    /**
     * Sets a new receivableSpecifiedTradeAccountingAccount
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeAccountingAccountType|null $receivableSpecifiedTradeAccountingAccount
     * @return self
     */
    public function setReceivableSpecifiedTradeAccountingAccount(?\horstoeko\zugferd\entities\en16931\ram\TradeAccountingAccountType $receivableSpecifiedTradeAccountingAccount = null)
    {
        $this->receivableSpecifiedTradeAccountingAccount = $receivableSpecifiedTradeAccountingAccount;
        return $this;
    }
}
