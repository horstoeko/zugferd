<?php

namespace horstoeko\zugferd\entities\basic\ram;

/**
 * Class representing LineTradeDeliveryType
 *
 * XSD Type: LineTradeDeliveryType
 */
class LineTradeDeliveryType
{

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\QuantityType|null $billedQuantity
     */
    private $billedQuantity = null;

    /**
     * Gets as billedQuantity
     *
     * @return \horstoeko\zugferd\entities\basic\udt\QuantityType|null
     */
    public function getBilledQuantity()
    {
        return $this->billedQuantity;
    }

    /**
     * Sets a new billedQuantity
     *
     * @param  \horstoeko\zugferd\entities\basic\udt\QuantityType $billedQuantity
     * @return self
     */
    public function setBilledQuantity(\horstoeko\zugferd\entities\basic\udt\QuantityType $billedQuantity)
    {
        $this->billedQuantity = $billedQuantity;
        return $this;
    }
}
