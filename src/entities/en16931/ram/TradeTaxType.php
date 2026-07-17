<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing TradeTaxType
 *
 * XSD Type: TradeTaxType
 */
class TradeTaxType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\AmountType|null $calculatedAmount
     */
    private $calculatedAmount = null;

    /**
     * @var string|null $typeCode
     */
    private $typeCode = null;

    /**
     * @var string|null $exemptionReason
     */
    private $exemptionReason = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\AmountType|null $basisAmount
     */
    private $basisAmount = null;

    /**
     * @var string|null $categoryCode
     */
    private $categoryCode = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\CodeType|null $exemptionReasonCode
     */
    private $exemptionReasonCode = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\DateType|null $taxPointDate
     */
    private $taxPointDate = null;

    /**
     * @var string|null $dueDateTypeCode
     */
    private $dueDateTypeCode = null;

    /**
     * @var float|null $rateApplicablePercent
     */
    private $rateApplicablePercent = null;

    /**
     * Gets as calculatedAmount
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\AmountType|null
     */
    public function getCalculatedAmount()
    {
        return $this->calculatedAmount;
    }

    /**
     * Sets a new calculatedAmount
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\AmountType|null $calculatedAmount
     * @return self
     */
    public function setCalculatedAmount(?\horstoeko\zugferd\entities\en16931\udt\AmountType $calculatedAmount = null)
    {
        $this->calculatedAmount = $calculatedAmount;
        return $this;
    }

    /**
     * Gets as typeCode
     *
     * @return string|null
     */
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * Sets a new typeCode
     *
     * @param  string $typeCode
     * @return self
     */
    public function setTypeCode($typeCode)
    {
        $this->typeCode = $typeCode;
        return $this;
    }

    /**
     * Gets as exemptionReason
     *
     * @return string|null
     */
    public function getExemptionReason()
    {
        return $this->exemptionReason;
    }

    /**
     * Sets a new exemptionReason
     *
     * @param  string $exemptionReason
     * @return self
     */
    public function setExemptionReason($exemptionReason)
    {
        $this->exemptionReason = $exemptionReason;
        return $this;
    }

    /**
     * Gets as basisAmount
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\AmountType|null
     */
    public function getBasisAmount()
    {
        return $this->basisAmount;
    }

    /**
     * Sets a new basisAmount
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\AmountType|null $basisAmount
     * @return self
     */
    public function setBasisAmount(?\horstoeko\zugferd\entities\en16931\udt\AmountType $basisAmount = null)
    {
        $this->basisAmount = $basisAmount;
        return $this;
    }

    /**
     * Gets as categoryCode
     *
     * @return string|null
     */
    public function getCategoryCode()
    {
        return $this->categoryCode;
    }

    /**
     * Sets a new categoryCode
     *
     * @param  string $categoryCode
     * @return self
     */
    public function setCategoryCode($categoryCode)
    {
        $this->categoryCode = $categoryCode;
        return $this;
    }

    /**
     * Gets as exemptionReasonCode
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\CodeType|null
     */
    public function getExemptionReasonCode()
    {
        return $this->exemptionReasonCode;
    }

    /**
     * Sets a new exemptionReasonCode
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\CodeType|null $exemptionReasonCode
     * @return self
     */
    public function setExemptionReasonCode(?\horstoeko\zugferd\entities\en16931\udt\CodeType $exemptionReasonCode = null)
    {
        $this->exemptionReasonCode = $exemptionReasonCode;
        return $this;
    }

    /**
     * Gets as taxPointDate
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\DateType|null
     */
    public function getTaxPointDate()
    {
        return $this->taxPointDate;
    }

    /**
     * Sets a new taxPointDate
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\DateType|null $taxPointDate
     * @return self
     */
    public function setTaxPointDate(?\horstoeko\zugferd\entities\en16931\udt\DateType $taxPointDate = null)
    {
        $this->taxPointDate = $taxPointDate;
        return $this;
    }

    /**
     * Gets as dueDateTypeCode
     *
     * @return string|null
     */
    public function getDueDateTypeCode()
    {
        return $this->dueDateTypeCode;
    }

    /**
     * Sets a new dueDateTypeCode
     *
     * @param  string $dueDateTypeCode
     * @return self
     */
    public function setDueDateTypeCode($dueDateTypeCode)
    {
        $this->dueDateTypeCode = $dueDateTypeCode;
        return $this;
    }

    /**
     * Gets as rateApplicablePercent
     *
     * @return float|null
     */
    public function getRateApplicablePercent()
    {
        return $this->rateApplicablePercent;
    }

    /**
     * Sets a new rateApplicablePercent
     *
     * @param  float $rateApplicablePercent
     * @return self
     */
    public function setRateApplicablePercent($rateApplicablePercent)
    {
        $this->rateApplicablePercent = $rateApplicablePercent;
        return $this;
    }
}
