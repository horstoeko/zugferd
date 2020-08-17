<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing TradeSettlementLineMonetarySummationType
 *
 *
 * XSD Type: TradeSettlementLineMonetarySummationType
 */
class TradeSettlementLineMonetarySummationType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\AmountType $lineTotalAmount
     */
    private $lineTotalAmount = null;

    /**
     * Gets as lineTotalAmount
     *
     * @return \horstoeko\zugferd\basic\udt\AmountType
     */
    public function getLineTotalAmount()
    {
        return $this->lineTotalAmount;
    }

    /**
     * Sets a new lineTotalAmount
     *
     * @param \horstoeko\zugferd\basic\udt\AmountType $lineTotalAmount
     * @return self
     */
    public function setLineTotalAmount(\horstoeko\zugferd\basic\udt\AmountType $lineTotalAmount)
    {
        $this->lineTotalAmount = $lineTotalAmount;
        return $this;
    }


}

