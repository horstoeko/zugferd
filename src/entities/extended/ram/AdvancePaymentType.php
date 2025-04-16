<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing AdvancePaymentType
 *
 * XSD Type: AdvancePaymentType
 */
class AdvancePaymentType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $paidAmount
     */
    private $paidAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType $formattedReceivedDateTime
     */
    private $formattedReceivedDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradeTaxType[] $includedTradeTax
     */
    private $includedTradeTax = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $invoiceSpecifiedReferencedDocument
     */
    private $invoiceSpecifiedReferencedDocument = null;

    /**
     * Gets as paidAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
     * Sets a new paidAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $paidAmount
     * @return self
     */
    public function setPaidAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $paidAmount)
    {
        $this->paidAmount = $paidAmount;
        return $this;
    }

    /**
     * Gets as formattedReceivedDateTime
     *
     * @return \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType
     */
    public function getFormattedReceivedDateTime()
    {
        return $this->formattedReceivedDateTime;
    }

    /**
     * Sets a new formattedReceivedDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType $formattedReceivedDateTime
     * @return self
     */
    public function setFormattedReceivedDateTime(?\horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType $formattedReceivedDateTime = null)
    {
        $this->formattedReceivedDateTime = $formattedReceivedDateTime;
        return $this;
    }

    /**
     * Adds as includedTradeTax
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeTaxType $includedTradeTax
     */
    public function addToIncludedTradeTax(\horstoeko\zugferd\entities\extended\ram\TradeTaxType $includedTradeTax)
    {
        $this->includedTradeTax[] = $includedTradeTax;
        return $this;
    }

    /**
     * isset includedTradeTax
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetIncludedTradeTax($index)
    {
        return isset($this->includedTradeTax[$index]);
    }

    /**
     * unset includedTradeTax
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetIncludedTradeTax($index)
    {
        unset($this->includedTradeTax[$index]);
    }

    /**
     * Gets as includedTradeTax
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradeTaxType[]
     */
    public function getIncludedTradeTax()
    {
        return $this->includedTradeTax;
    }

    /**
     * Sets a new includedTradeTax
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeTaxType[] $includedTradeTax
     * @return self
     */
    public function setIncludedTradeTax(array $includedTradeTax)
    {
        $this->includedTradeTax = $includedTradeTax;
        return $this;
    }

    /**
     * Gets as invoiceSpecifiedReferencedDocument
     *
     * @return \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType
     */
    public function getInvoiceSpecifiedReferencedDocument()
    {
        return $this->invoiceSpecifiedReferencedDocument;
    }

    /**
     * Sets a new invoiceSpecifiedReferencedDocument
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $invoiceSpecifiedReferencedDocument
     * @return self
     */
    public function setInvoiceSpecifiedReferencedDocument(?\horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType $invoiceSpecifiedReferencedDocument = null)
    {
        $this->invoiceSpecifiedReferencedDocument = $invoiceSpecifiedReferencedDocument;
        return $this;
    }
}
