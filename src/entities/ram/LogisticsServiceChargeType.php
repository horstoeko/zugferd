<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing LogisticsServiceChargeType
 *
 *
 * XSD Type: LogisticsServiceChargeType
 */
class LogisticsServiceChargeType
{

    /**
     * @property string $description
     */
    private $description = null;

    /**
     * @property \horstoeko\zugferd\udt\AmountType $appliedAmount
     */
    private $appliedAmount = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeTaxType[] $appliedTradeTax
     */
    private $appliedTradeTax = null;

    /**
     * Gets as description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets a new description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets as appliedAmount
     *
     * @return \horstoeko\zugferd\udt\AmountType
     */
    public function getAppliedAmount()
    {
        return $this->appliedAmount;
    }

    /**
     * Sets a new appliedAmount
     *
     * @param \horstoeko\zugferd\udt\AmountType $appliedAmount
     * @return self
     */
    public function setAppliedAmount(\horstoeko\zugferd\udt\AmountType $appliedAmount)
    {
        $this->appliedAmount = $appliedAmount;
        return $this;
    }

    /**
     * Adds as appliedTradeTax
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TradeTaxType $appliedTradeTax
     */
    public function addToAppliedTradeTax(\horstoeko\zugferd\ram\TradeTaxType $appliedTradeTax)
    {
        $this->appliedTradeTax[] = $appliedTradeTax;
        return $this;
    }

    /**
     * isset appliedTradeTax
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAppliedTradeTax($index)
    {
        return isset($this->appliedTradeTax[$index]);
    }

    /**
     * unset appliedTradeTax
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAppliedTradeTax($index)
    {
        unset($this->appliedTradeTax[$index]);
    }

    /**
     * Gets as appliedTradeTax
     *
     * @return \horstoeko\zugferd\ram\TradeTaxType[]
     */
    public function getAppliedTradeTax()
    {
        return $this->appliedTradeTax;
    }

    /**
     * Sets a new appliedTradeTax
     *
     * @param \horstoeko\zugferd\ram\TradeTaxType[] $appliedTradeTax
     * @return self
     */
    public function setAppliedTradeTax(array $appliedTradeTax)
    {
        $this->appliedTradeTax = $appliedTradeTax;
        return $this;
    }


}

