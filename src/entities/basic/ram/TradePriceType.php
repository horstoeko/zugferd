<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing TradePriceType
 *
 *
 * XSD Type: TradePriceType
 */
class TradePriceType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\AmountType $chargeAmount
     */
    private $chargeAmount = null;

    /**
     * @var \horstoeko\zugferd\basic\udt\QuantityType $basisQuantity
     */
    private $basisQuantity = null;

    /**
     * Gets as chargeAmount
     *
     * @return \horstoeko\zugferd\basic\udt\AmountType
     */
    public function getChargeAmount()
    {
        return $this->chargeAmount;
    }

    /**
     * Sets a new chargeAmount
     *
     * @param \horstoeko\zugferd\basic\udt\AmountType $chargeAmount
     * @return self
     */
    public function setChargeAmount(\horstoeko\zugferd\basic\udt\AmountType $chargeAmount)
    {
        $this->chargeAmount = $chargeAmount;
        return $this;
    }

    /**
     * Gets as basisQuantity
     *
     * @return \horstoeko\zugferd\basic\udt\QuantityType
     */
    public function getBasisQuantity()
    {
        return $this->basisQuantity;
    }

    /**
     * Sets a new basisQuantity
     *
     * @param \horstoeko\zugferd\basic\udt\QuantityType $basisQuantity
     * @return self
     */
    public function setBasisQuantity(\horstoeko\zugferd\basic\udt\QuantityType $basisQuantity)
    {
        $this->basisQuantity = $basisQuantity;
        return $this;
    }


}

