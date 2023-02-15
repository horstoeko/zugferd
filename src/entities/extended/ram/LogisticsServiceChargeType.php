<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing LogisticsServiceChargeType
 *
 * XSD Type: LogisticsServiceChargeType
 */
class LogisticsServiceChargeType
{

    /**
     * @var string $description
     */
    private $description = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $appliedAmount
     */
    private $appliedAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradeTaxType[] $appliedTradeTax
     */
    private $appliedTradeTax = [
        
    ];

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
     * @param  string $description
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
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getAppliedAmount()
    {
        return $this->appliedAmount;
    }

    /**
     * Sets a new appliedAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $appliedAmount
     * @return self
     */
    public function setAppliedAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $appliedAmount)
    {
        $this->appliedAmount = $appliedAmount;
        return $this;
    }

    /**
     * Adds as appliedTradeTax
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeTaxType $appliedTradeTax
     */
    public function addToAppliedTradeTax(\horstoeko\zugferd\entities\extended\ram\TradeTaxType $appliedTradeTax)
    {
        $this->appliedTradeTax[] = $appliedTradeTax;
        return $this;
    }

    /**
     * isset appliedTradeTax
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetAppliedTradeTax($index)
    {
        return isset($this->appliedTradeTax[$index]);
    }

    /**
     * unset appliedTradeTax
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetAppliedTradeTax($index)
    {
        unset($this->appliedTradeTax[$index]);
    }

    /**
     * Gets as appliedTradeTax
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradeTaxType[]
     */
    public function getAppliedTradeTax()
    {
        return $this->appliedTradeTax;
    }

    /**
     * Sets a new appliedTradeTax
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeTaxType[] $appliedTradeTax
     * @return self
     */
    public function setAppliedTradeTax(array $appliedTradeTax)
    {
        $this->appliedTradeTax = $appliedTradeTax;
        return $this;
    }
}
