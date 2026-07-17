<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeSettlementLineMonetarySummationType
 *
 * XSD Type: TradeSettlementLineMonetarySummationType
 */
class TradeSettlementLineMonetarySummationType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $lineTotalAmount
     */
    private $lineTotalAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $chargeTotalAmount
     */
    private $chargeTotalAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $allowanceTotalAmount
     */
    private $allowanceTotalAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType[] $taxTotalAmount
     */
    private $taxTotalAmount = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $grandTotalAmount
     */
    private $grandTotalAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $totalAllowanceChargeAmount
     */
    private $totalAllowanceChargeAmount = null;

    /**
     * Gets as lineTotalAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getLineTotalAmount()
    {
        return $this->lineTotalAmount;
    }

    /**
     * Sets a new lineTotalAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $lineTotalAmount
     * @return self
     */
    public function setLineTotalAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $lineTotalAmount = null)
    {
        $this->lineTotalAmount = $lineTotalAmount;
        return $this;
    }

    /**
     * Gets as chargeTotalAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getChargeTotalAmount()
    {
        return $this->chargeTotalAmount;
    }

    /**
     * Sets a new chargeTotalAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $chargeTotalAmount
     * @return self
     */
    public function setChargeTotalAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $chargeTotalAmount = null)
    {
        $this->chargeTotalAmount = $chargeTotalAmount;
        return $this;
    }

    /**
     * Gets as allowanceTotalAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getAllowanceTotalAmount()
    {
        return $this->allowanceTotalAmount;
    }

    /**
     * Sets a new allowanceTotalAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $allowanceTotalAmount
     * @return self
     */
    public function setAllowanceTotalAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $allowanceTotalAmount = null)
    {
        $this->allowanceTotalAmount = $allowanceTotalAmount;
        return $this;
    }

    /**
     * Adds as taxTotalAmount
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $taxTotalAmount
     */
    public function addToTaxTotalAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $taxTotalAmount)
    {
        $this->taxTotalAmount[] = $taxTotalAmount;
        return $this;
    }

    /**
     * isset taxTotalAmount
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetTaxTotalAmount($index)
    {
        return isset($this->taxTotalAmount[$index]);
    }

    /**
     * unset taxTotalAmount
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetTaxTotalAmount($index)
    {
        unset($this->taxTotalAmount[$index]);
    }

    /**
     * Gets as taxTotalAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType[]
     */
    public function getTaxTotalAmount()
    {
        return $this->taxTotalAmount;
    }

    /**
     * Sets a new taxTotalAmount
     *
     * Factur-X 1.09 raised TaxTotalAmount to [0..2]. A single AmountType is still
     * accepted so callers written against the pre-1.09 signature keep working.
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType|\horstoeko\zugferd\entities\extended\udt\AmountType[]|null $taxTotalAmount
     * @return self
     */
    public function setTaxTotalAmount($taxTotalAmount = null)
    {
        if ($taxTotalAmount !== null && !is_array($taxTotalAmount)) {
            $taxTotalAmount = [$taxTotalAmount];
        }

        $this->taxTotalAmount = $taxTotalAmount;
        return $this;
    }

    /**
     * Gets as grandTotalAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getGrandTotalAmount()
    {
        return $this->grandTotalAmount;
    }

    /**
     * Sets a new grandTotalAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $grandTotalAmount
     * @return self
     */
    public function setGrandTotalAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $grandTotalAmount = null)
    {
        $this->grandTotalAmount = $grandTotalAmount;
        return $this;
    }

    /**
     * Gets as totalAllowanceChargeAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getTotalAllowanceChargeAmount()
    {
        return $this->totalAllowanceChargeAmount;
    }

    /**
     * Sets a new totalAllowanceChargeAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $totalAllowanceChargeAmount
     * @return self
     */
    public function setTotalAllowanceChargeAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $totalAllowanceChargeAmount = null)
    {
        $this->totalAllowanceChargeAmount = $totalAllowanceChargeAmount;
        return $this;
    }
}
