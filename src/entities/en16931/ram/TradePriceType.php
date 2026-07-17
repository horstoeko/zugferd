<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing TradePriceType
 *
 * XSD Type: TradePriceType
 */
class TradePriceType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\AmountType|null $chargeAmount
     */
    private $chargeAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\QuantityType|null $basisQuantity
     */
    private $basisQuantity = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType|null $appliedTradeAllowanceCharge
     */
    private $appliedTradeAllowanceCharge = null;

    /**
     * Gets as chargeAmount
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\AmountType|null
     */
    public function getChargeAmount()
    {
        return $this->chargeAmount;
    }

    /**
     * Sets a new chargeAmount
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\AmountType $chargeAmount
     * @return self
     */
    public function setChargeAmount(\horstoeko\zugferd\entities\en16931\udt\AmountType $chargeAmount)
    {
        $this->chargeAmount = $chargeAmount;
        return $this;
    }

    /**
     * Gets as basisQuantity
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\QuantityType|null
     */
    public function getBasisQuantity()
    {
        return $this->basisQuantity;
    }

    /**
     * Sets a new basisQuantity
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\QuantityType|null $basisQuantity
     * @return self
     */
    public function setBasisQuantity(?\horstoeko\zugferd\entities\en16931\udt\QuantityType $basisQuantity = null)
    {
        $this->basisQuantity = $basisQuantity;
        return $this;
    }

    /**
     * Gets as appliedTradeAllowanceCharge
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType|null
     */
    public function getAppliedTradeAllowanceCharge()
    {
        return $this->appliedTradeAllowanceCharge;
    }

    /**
     * Sets a new appliedTradeAllowanceCharge
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType|null $appliedTradeAllowanceCharge
     * @return self
     */
    public function setAppliedTradeAllowanceCharge(?\horstoeko\zugferd\entities\en16931\ram\TradeAllowanceChargeType $appliedTradeAllowanceCharge = null)
    {
        $this->appliedTradeAllowanceCharge = $appliedTradeAllowanceCharge;
        return $this;
    }
}
