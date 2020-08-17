<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradePriceType
 *
 *
 * XSD Type: TradePriceType
 */
class TradePriceType
{

    /**
     * @var \horstoeko\zugferd\udt\AmountType $chargeAmount
     */
    private $chargeAmount = null;

    /**
     * @var \horstoeko\zugferd\udt\QuantityType $basisQuantity
     */
    private $basisQuantity = null;

    /**
     * @var \horstoeko\zugferd\ram\TradeAllowanceChargeType[] $appliedTradeAllowanceCharge
     */
    private $appliedTradeAllowanceCharge = [
        
    ];

    /**
     * @var \horstoeko\zugferd\ram\TradeTaxType $includedTradeTax
     */
    private $includedTradeTax = null;

    /**
     * Gets as chargeAmount
     *
     * @return \horstoeko\zugferd\udt\AmountType
     */
    public function getChargeAmount()
    {
        return $this->chargeAmount;
    }

    /**
     * Sets a new chargeAmount
     *
     * @param \horstoeko\zugferd\udt\AmountType $chargeAmount
     * @return self
     */
    public function setChargeAmount(\horstoeko\zugferd\udt\AmountType $chargeAmount)
    {
        $this->chargeAmount = $chargeAmount;
        return $this;
    }

    /**
     * Gets as basisQuantity
     *
     * @return \horstoeko\zugferd\udt\QuantityType
     */
    public function getBasisQuantity()
    {
        return $this->basisQuantity;
    }

    /**
     * Sets a new basisQuantity
     *
     * @param \horstoeko\zugferd\udt\QuantityType $basisQuantity
     * @return self
     */
    public function setBasisQuantity(\horstoeko\zugferd\udt\QuantityType $basisQuantity)
    {
        $this->basisQuantity = $basisQuantity;
        return $this;
    }

    /**
     * Adds as appliedTradeAllowanceCharge
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TradeAllowanceChargeType $appliedTradeAllowanceCharge
     */
    public function addToAppliedTradeAllowanceCharge(\horstoeko\zugferd\ram\TradeAllowanceChargeType $appliedTradeAllowanceCharge)
    {
        $this->appliedTradeAllowanceCharge[] = $appliedTradeAllowanceCharge;
        return $this;
    }

    /**
     * isset appliedTradeAllowanceCharge
     *
     * @param int|string $index
     * @return bool
     */
    public function issetAppliedTradeAllowanceCharge($index)
    {
        return isset($this->appliedTradeAllowanceCharge[$index]);
    }

    /**
     * unset appliedTradeAllowanceCharge
     *
     * @param int|string $index
     * @return void
     */
    public function unsetAppliedTradeAllowanceCharge($index)
    {
        unset($this->appliedTradeAllowanceCharge[$index]);
    }

    /**
     * Gets as appliedTradeAllowanceCharge
     *
     * @return \horstoeko\zugferd\ram\TradeAllowanceChargeType[]
     */
    public function getAppliedTradeAllowanceCharge()
    {
        return $this->appliedTradeAllowanceCharge;
    }

    /**
     * Sets a new appliedTradeAllowanceCharge
     *
     * @param \horstoeko\zugferd\ram\TradeAllowanceChargeType[] $appliedTradeAllowanceCharge
     * @return self
     */
    public function setAppliedTradeAllowanceCharge(array $appliedTradeAllowanceCharge)
    {
        $this->appliedTradeAllowanceCharge = $appliedTradeAllowanceCharge;
        return $this;
    }

    /**
     * Gets as includedTradeTax
     *
     * @return \horstoeko\zugferd\ram\TradeTaxType
     */
    public function getIncludedTradeTax()
    {
        return $this->includedTradeTax;
    }

    /**
     * Sets a new includedTradeTax
     *
     * @param \horstoeko\zugferd\ram\TradeTaxType $includedTradeTax
     * @return self
     */
    public function setIncludedTradeTax(\horstoeko\zugferd\ram\TradeTaxType $includedTradeTax)
    {
        $this->includedTradeTax = $includedTradeTax;
        return $this;
    }


}

