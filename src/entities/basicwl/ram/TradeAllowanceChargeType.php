<?php

namespace horstoeko\zugferd\entities\basicwl\ram;

/**
 * Class representing TradeAllowanceChargeType
 *
 * XSD Type: TradeAllowanceChargeType
 */
class TradeAllowanceChargeType
{

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\IndicatorType|null $chargeIndicator
     */
    private $chargeIndicator = null;

    /**
     * @var float|null $calculationPercent
     */
    private $calculationPercent = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\AmountType|null $basisAmount
     */
    private $basisAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\AmountType|null $actualAmount
     */
    private $actualAmount = null;

    /**
     * @var string|null $reasonCode
     */
    private $reasonCode = null;

    /**
     * @var string|null $reason
     */
    private $reason = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\ram\TradeTaxType|null $categoryTradeTax
     */
    private $categoryTradeTax = null;

    /**
     * Gets as chargeIndicator
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\IndicatorType|null
     */
    public function getChargeIndicator()
    {
        return $this->chargeIndicator;
    }

    /**
     * Sets a new chargeIndicator
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IndicatorType $chargeIndicator
     * @return self
     */
    public function setChargeIndicator(\horstoeko\zugferd\entities\basicwl\udt\IndicatorType $chargeIndicator)
    {
        $this->chargeIndicator = $chargeIndicator;
        return $this;
    }

    /**
     * Gets as calculationPercent
     *
     * @return float|null
     */
    public function getCalculationPercent()
    {
        return $this->calculationPercent;
    }

    /**
     * Sets a new calculationPercent
     *
     * @param  float $calculationPercent
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
     * @return \horstoeko\zugferd\entities\basicwl\udt\AmountType|null
     */
    public function getBasisAmount()
    {
        return $this->basisAmount;
    }

    /**
     * Sets a new basisAmount
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\AmountType|null $basisAmount
     * @return self
     */
    public function setBasisAmount(?\horstoeko\zugferd\entities\basicwl\udt\AmountType $basisAmount = null)
    {
        $this->basisAmount = $basisAmount;
        return $this;
    }

    /**
     * Gets as actualAmount
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\AmountType|null
     */
    public function getActualAmount()
    {
        return $this->actualAmount;
    }

    /**
     * Sets a new actualAmount
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\AmountType $actualAmount
     * @return self
     */
    public function setActualAmount(\horstoeko\zugferd\entities\basicwl\udt\AmountType $actualAmount)
    {
        $this->actualAmount = $actualAmount;
        return $this;
    }

    /**
     * Gets as reasonCode
     *
     * @return string|null
     */
    public function getReasonCode()
    {
        return $this->reasonCode;
    }

    /**
     * Sets a new reasonCode
     *
     * @param  string $reasonCode
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
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Sets a new reason
     *
     * @param  string $reason
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
     * @return \horstoeko\zugferd\entities\basicwl\ram\TradeTaxType|null
     */
    public function getCategoryTradeTax()
    {
        return $this->categoryTradeTax;
    }

    /**
     * Sets a new categoryTradeTax
     *
     * @param  \horstoeko\zugferd\entities\basicwl\ram\TradeTaxType $categoryTradeTax
     * @return self
     */
    public function setCategoryTradeTax(\horstoeko\zugferd\entities\basicwl\ram\TradeTaxType $categoryTradeTax)
    {
        $this->categoryTradeTax = $categoryTradeTax;
        return $this;
    }
}
