<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing TradeAllowanceChargeType
 *
 *
 * XSD Type: TradeAllowanceChargeType
 */
class TradeAllowanceChargeType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\IndicatorType $chargeIndicator
     */
    private $chargeIndicator = null;

    /**
     * @var float $calculationPercent
     */
    private $calculationPercent = null;

    /**
     * @var \horstoeko\zugferd\basic\udt\AmountType $basisAmount
     */
    private $basisAmount = null;

    /**
     * @var \horstoeko\zugferd\basic\udt\AmountType $actualAmount
     */
    private $actualAmount = null;

    /**
     * @var string $reasonCode
     */
    private $reasonCode = null;

    /**
     * @var string $reason
     */
    private $reason = null;

    /**
     * @var \horstoeko\zugferd\basic\ram\TradeTaxType $categoryTradeTax
     */
    private $categoryTradeTax = null;

    /**
     * Gets as chargeIndicator
     *
     * @return \horstoeko\zugferd\basic\udt\IndicatorType
     */
    public function getChargeIndicator()
    {
        return $this->chargeIndicator;
    }

    /**
     * Sets a new chargeIndicator
     *
     * @param \horstoeko\zugferd\basic\udt\IndicatorType $chargeIndicator
     * @return self
     */
    public function setChargeIndicator(\horstoeko\zugferd\basic\udt\IndicatorType $chargeIndicator)
    {
        $this->chargeIndicator = $chargeIndicator;
        return $this;
    }

    /**
     * Gets as calculationPercent
     *
     * @return float
     */
    public function getCalculationPercent()
    {
        return $this->calculationPercent;
    }

    /**
     * Sets a new calculationPercent
     *
     * @param float $calculationPercent
     * @return self
     */
    public function setCalculationPercent($calculationPercent)
    {
        $this->calculationPercent = $calculationPercent;
        return $this;
    }

    /**
     * Gets as basisAmount
     *
     * @return \horstoeko\zugferd\basic\udt\AmountType
     */
    public function getBasisAmount()
    {
        return $this->basisAmount;
    }

    /**
     * Sets a new basisAmount
     *
     * @param \horstoeko\zugferd\basic\udt\AmountType $basisAmount
     * @return self
     */
    public function setBasisAmount(\horstoeko\zugferd\basic\udt\AmountType $basisAmount)
    {
        $this->basisAmount = $basisAmount;
        return $this;
    }

    /**
     * Gets as actualAmount
     *
     * @return \horstoeko\zugferd\basic\udt\AmountType
     */
    public function getActualAmount()
    {
        return $this->actualAmount;
    }

    /**
     * Sets a new actualAmount
     *
     * @param \horstoeko\zugferd\basic\udt\AmountType $actualAmount
     * @return self
     */
    public function setActualAmount(\horstoeko\zugferd\basic\udt\AmountType $actualAmount)
    {
        $this->actualAmount = $actualAmount;
        return $this;
    }

    /**
     * Gets as reasonCode
     *
     * @return string
     */
    public function getReasonCode()
    {
        return $this->reasonCode;
    }

    /**
     * Sets a new reasonCode
     *
     * @param string $reasonCode
     * @return self
     */
    public function setReasonCode($reasonCode)
    {
        $this->reasonCode = $reasonCode;
        return $this;
    }

    /**
     * Gets as reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Sets a new reason
     *
     * @param string $reason
     * @return self
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * Gets as categoryTradeTax
     *
     * @return \horstoeko\zugferd\basic\ram\TradeTaxType
     */
    public function getCategoryTradeTax()
    {
        return $this->categoryTradeTax;
    }

    /**
     * Sets a new categoryTradeTax
     *
     * @param \horstoeko\zugferd\basic\ram\TradeTaxType $categoryTradeTax
     * @return self
     */
    public function setCategoryTradeTax(\horstoeko\zugferd\basic\ram\TradeTaxType $categoryTradeTax)
    {
        $this->categoryTradeTax = $categoryTradeTax;
        return $this;
    }


}

