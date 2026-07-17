<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradePaymentDiscountTermsType
 *
 * XSD Type: TradePaymentDiscountTermsType
 */
class TradePaymentDiscountTermsType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $basisDateTime
     */
    private $basisDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\MeasureType|null $basisPeriodMeasure
     */
    private $basisPeriodMeasure = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType|null $basisAmount
     */
    private $basisAmount = null;

    /**
     * @var float|null $calculationPercent
     */
    private $calculationPercent = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType|null $actualDiscountAmount
     */
    private $actualDiscountAmount = null;

    /**
     * Gets as basisDateTime
     *
     * @return \horstoeko\zugferd\entities\extended\udt\DateTimeType|null
     */
    public function getBasisDateTime()
    {
        return $this->basisDateTime;
    }

    /**
     * Sets a new basisDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $basisDateTime
     * @return self
     */
    public function setBasisDateTime(?\horstoeko\zugferd\entities\extended\udt\DateTimeType $basisDateTime = null)
    {
        $this->basisDateTime = $basisDateTime;
        return $this;
    }

    /**
     * Gets as basisPeriodMeasure
     *
     * @return \horstoeko\zugferd\entities\extended\udt\MeasureType|null
     */
    public function getBasisPeriodMeasure()
    {
        return $this->basisPeriodMeasure;
    }

    /**
     * Sets a new basisPeriodMeasure
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\MeasureType|null $basisPeriodMeasure
     * @return self
     */
    public function setBasisPeriodMeasure(?\horstoeko\zugferd\entities\extended\udt\MeasureType $basisPeriodMeasure = null)
    {
        $this->basisPeriodMeasure = $basisPeriodMeasure;
        return $this;
    }

    /**
     * Gets as basisAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType|null
     */
    public function getBasisAmount()
    {
        return $this->basisAmount;
    }

    /**
     * Sets a new basisAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType|null $basisAmount
     * @return self
     */
    public function setBasisAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $basisAmount = null)
    {
        $this->basisAmount = $basisAmount;
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
     * Gets as actualDiscountAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType|null
     */
    public function getActualDiscountAmount()
    {
        return $this->actualDiscountAmount;
    }

    /**
     * Sets a new actualDiscountAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType|null $actualDiscountAmount
     * @return self
     */
    public function setActualDiscountAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $actualDiscountAmount = null)
    {
        $this->actualDiscountAmount = $actualDiscountAmount;
        return $this;
    }
}
