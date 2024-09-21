<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeAllowanceChargeType
 *
 * XSD Type: TradeAllowanceChargeType
 */
class TradeAllowanceChargeType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType $chargeIndicator
     */
    private $chargeIndicator = null;

    /**
     * @var float $sequenceNumeric
     */
    private $sequenceNumeric = null;

    /**
     * @var float $calculationPercent
     */
    private $calculationPercent = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $basisAmount
     */
    private $basisAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\QuantityType $basisQuantity
     */
    private $basisQuantity = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $actualAmount
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
     * @var \horstoeko\zugferd\entities\extended\ram\TradeTaxType $categoryTradeTax
     */
    private $categoryTradeTax = null;

    /**
     * Gets as chargeIndicator
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IndicatorType
     */
    public function getChargeIndicator()
    {
        return $this->chargeIndicator;
    }

    /**
     * Sets a new chargeIndicator
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IndicatorType $chargeIndicator
     * @return self
     */
    public function setChargeIndicator(\horstoeko\zugferd\entities\extended\udt\IndicatorType $chargeIndicator)
    {
        $this->chargeIndicator = $chargeIndicator;
        return $this;
    }

    /**
     * Gets as sequenceNumeric
     *
     * @return float
     */
    public function getSequenceNumeric()
    {
        return $this->sequenceNumeric;
    }

    /**
     * Sets a new sequenceNumeric
     *
     * @param  float $sequenceNumeric
     * @return self
     */
    public function setSequenceNumeric($sequenceNumeric)
    {
        $this->sequenceNumeric = $sequenceNumeric;
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
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getBasisAmount()
    {
        return $this->basisAmount;
    }

    /**
     * Sets a new basisAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $basisAmount
     * @return self
     */
    public function setBasisAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $basisAmount = null)
    {
        $this->basisAmount = $basisAmount;
        return $this;
    }

    /**
     * Gets as basisQuantity
     *
     * @return \horstoeko\zugferd\entities\extended\udt\QuantityType
     */
    public function getBasisQuantity()
    {
        return $this->basisQuantity;
    }

    /**
     * Sets a new basisQuantity
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\QuantityType $basisQuantity
     * @return self
     */
    public function setBasisQuantity(?\horstoeko\zugferd\entities\extended\udt\QuantityType $basisQuantity = null)
    {
        $this->basisQuantity = $basisQuantity;
        return $this;
    }

    /**
     * Gets as actualAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getActualAmount()
    {
        return $this->actualAmount;
    }

    /**
     * Sets a new actualAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $actualAmount
     * @return self
     */
    public function setActualAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $actualAmount)
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
     * @return string
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
     * @return \horstoeko\zugferd\entities\extended\ram\TradeTaxType
     */
    public function getCategoryTradeTax()
    {
        return $this->categoryTradeTax;
    }

    /**
     * Sets a new categoryTradeTax
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeTaxType $categoryTradeTax
     * @return self
     */
    public function setCategoryTradeTax(?\horstoeko\zugferd\entities\extended\ram\TradeTaxType $categoryTradeTax = null)
    {
        $this->categoryTradeTax = $categoryTradeTax;
        return $this;
    }
}
