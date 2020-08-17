<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradeSettlementLineMonetarySummationType
 *
 *
 * XSD Type: TradeSettlementLineMonetarySummationType
 */
class TradeSettlementLineMonetarySummationType
{

    /**
     * @var \horstoeko\zugferd\udt\AmountType $lineTotalAmount
     */
    private $lineTotalAmount = null;

    /**
     * @var \horstoeko\zugferd\udt\AmountType $totalAllowanceChargeAmount
     */
    private $totalAllowanceChargeAmount = null;

    /**
     * Gets as lineTotalAmount
     *
     * @return \horstoeko\zugferd\udt\AmountType
     */
    public function getLineTotalAmount()
    {
        return $this->lineTotalAmount;
    }

    /**
     * Sets a new lineTotalAmount
     *
     * @param \horstoeko\zugferd\udt\AmountType $lineTotalAmount
     * @return self
     */
    public function setLineTotalAmount(\horstoeko\zugferd\udt\AmountType $lineTotalAmount)
    {
        $this->lineTotalAmount = $lineTotalAmount;
        return $this;
    }

    /**
     * Gets as totalAllowanceChargeAmount
     *
     * @return \horstoeko\zugferd\udt\AmountType
     */
    public function getTotalAllowanceChargeAmount()
    {
        return $this->totalAllowanceChargeAmount;
    }

    /**
     * Sets a new totalAllowanceChargeAmount
     *
     * @param \horstoeko\zugferd\udt\AmountType $totalAllowanceChargeAmount
     * @return self
     */
    public function setTotalAllowanceChargeAmount(\horstoeko\zugferd\udt\AmountType $totalAllowanceChargeAmount)
    {
        $this->totalAllowanceChargeAmount = $totalAllowanceChargeAmount;
        return $this;
    }


}

