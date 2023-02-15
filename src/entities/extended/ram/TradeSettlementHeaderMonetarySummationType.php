<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeSettlementHeaderMonetarySummationType
 *
 * XSD Type: TradeSettlementHeaderMonetarySummationType
 */
class TradeSettlementHeaderMonetarySummationType
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
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType[] $taxBasisTotalAmount
     */
    private $taxBasisTotalAmount = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType[] $taxTotalAmount
     */
    private $taxTotalAmount = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $roundingAmount
     */
    private $roundingAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType[] $grandTotalAmount
     */
    private $grandTotalAmount = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $totalPrepaidAmount
     */
    private $totalPrepaidAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $duePayableAmount
     */
    private $duePayableAmount = null;

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
    public function setLineTotalAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $lineTotalAmount)
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
    public function setChargeTotalAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $chargeTotalAmount)
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
    public function setAllowanceTotalAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $allowanceTotalAmount)
    {
        $this->allowanceTotalAmount = $allowanceTotalAmount;
        return $this;
    }

    /**
     * Adds as taxBasisTotalAmount
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $taxBasisTotalAmount
     */
    public function addToTaxBasisTotalAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $taxBasisTotalAmount)
    {
        $this->taxBasisTotalAmount[] = $taxBasisTotalAmount;
        return $this;
    }

    /**
     * isset taxBasisTotalAmount
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetTaxBasisTotalAmount($index)
    {
        return isset($this->taxBasisTotalAmount[$index]);
    }

    /**
     * unset taxBasisTotalAmount
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetTaxBasisTotalAmount($index)
    {
        unset($this->taxBasisTotalAmount[$index]);
    }

    /**
     * Gets as taxBasisTotalAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType[]
     */
    public function getTaxBasisTotalAmount()
    {
        return $this->taxBasisTotalAmount;
    }

    /**
     * Sets a new taxBasisTotalAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType[] $taxBasisTotalAmount
     * @return self
     */
    public function setTaxBasisTotalAmount(array $taxBasisTotalAmount)
    {
        $this->taxBasisTotalAmount = $taxBasisTotalAmount;
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
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType[] $taxTotalAmount
     * @return self
     */
    public function setTaxTotalAmount(array $taxTotalAmount)
    {
        $this->taxTotalAmount = $taxTotalAmount;
        return $this;
    }

    /**
     * Gets as roundingAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getRoundingAmount()
    {
        return $this->roundingAmount;
    }

    /**
     * Sets a new roundingAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $roundingAmount
     * @return self
     */
    public function setRoundingAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $roundingAmount)
    {
        $this->roundingAmount = $roundingAmount;
        return $this;
    }

    /**
     * Adds as grandTotalAmount
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $grandTotalAmount
     */
    public function addToGrandTotalAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $grandTotalAmount)
    {
        $this->grandTotalAmount[] = $grandTotalAmount;
        return $this;
    }

    /**
     * isset grandTotalAmount
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetGrandTotalAmount($index)
    {
        return isset($this->grandTotalAmount[$index]);
    }

    /**
     * unset grandTotalAmount
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetGrandTotalAmount($index)
    {
        unset($this->grandTotalAmount[$index]);
    }

    /**
     * Gets as grandTotalAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType[]
     */
    public function getGrandTotalAmount()
    {
        return $this->grandTotalAmount;
    }

    /**
     * Sets a new grandTotalAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType[] $grandTotalAmount
     * @return self
     */
    public function setGrandTotalAmount(array $grandTotalAmount)
    {
        $this->grandTotalAmount = $grandTotalAmount;
        return $this;
    }

    /**
     * Gets as totalPrepaidAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getTotalPrepaidAmount()
    {
        return $this->totalPrepaidAmount;
    }

    /**
     * Sets a new totalPrepaidAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $totalPrepaidAmount
     * @return self
     */
    public function setTotalPrepaidAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $totalPrepaidAmount)
    {
        $this->totalPrepaidAmount = $totalPrepaidAmount;
        return $this;
    }

    /**
     * Gets as duePayableAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getDuePayableAmount()
    {
        return $this->duePayableAmount;
    }

    /**
     * Sets a new duePayableAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $duePayableAmount
     * @return self
     */
    public function setDuePayableAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $duePayableAmount)
    {
        $this->duePayableAmount = $duePayableAmount;
        return $this;
    }


}

