<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing AdvancePaymentType
 *
 *
 * XSD Type: AdvancePaymentType
 */
class AdvancePaymentType
{

    /**
     * @property \horstoeko\zugferd\udt\AmountType $paidAmount
     */
    private $paidAmount = null;

    /**
     * @property \horstoeko\zugferd\qdt\FormattedDateTimeType
     * $formattedReceivedDateTime
     */
    private $formattedReceivedDateTime = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeTaxType[] $includedTradeTax
     */
    private $includedTradeTax = null;

    /**
     * Gets as paidAmount
     *
     * @return \horstoeko\zugferd\udt\AmountType
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
     * Sets a new paidAmount
     *
     * @param \horstoeko\zugferd\udt\AmountType $paidAmount
     * @return self
     */
    public function setPaidAmount(\horstoeko\zugferd\udt\AmountType $paidAmount)
    {
        $this->paidAmount = $paidAmount;
        return $this;
    }

    /**
     * Gets as formattedReceivedDateTime
     *
     * @return \horstoeko\zugferd\qdt\FormattedDateTimeType
     */
    public function getFormattedReceivedDateTime()
    {
        return $this->formattedReceivedDateTime;
    }

    /**
     * Sets a new formattedReceivedDateTime
     *
     * @param \horstoeko\zugferd\qdt\FormattedDateTimeType $formattedReceivedDateTime
     * @return self
     */
    public function setFormattedReceivedDateTime(\horstoeko\zugferd\qdt\FormattedDateTimeType $formattedReceivedDateTime)
    {
        $this->formattedReceivedDateTime = $formattedReceivedDateTime;
        return $this;
    }

    /**
     * Adds as includedTradeTax
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TradeTaxType $includedTradeTax
     */
    public function addToIncludedTradeTax(\horstoeko\zugferd\ram\TradeTaxType $includedTradeTax)
    {
        $this->includedTradeTax[] = $includedTradeTax;
        return $this;
    }

    /**
     * isset includedTradeTax
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetIncludedTradeTax($index)
    {
        return isset($this->includedTradeTax[$index]);
    }

    /**
     * unset includedTradeTax
     *
     * @param scalar $index
     * @return void
     */
    public function unsetIncludedTradeTax($index)
    {
        unset($this->includedTradeTax[$index]);
    }

    /**
     * Gets as includedTradeTax
     *
     * @return \horstoeko\zugferd\ram\TradeTaxType[]
     */
    public function getIncludedTradeTax()
    {
        return $this->includedTradeTax;
    }

    /**
     * Sets a new includedTradeTax
     *
     * @param \horstoeko\zugferd\ram\TradeTaxType[] $includedTradeTax
     * @return self
     */
    public function setIncludedTradeTax(array $includedTradeTax)
    {
        $this->includedTradeTax = $includedTradeTax;
        return $this;
    }


}

