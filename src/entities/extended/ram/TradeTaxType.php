<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeTaxType
 *
 * XSD Type: TradeTaxType
 */
class TradeTaxType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $calculatedAmount
     */
    private $calculatedAmount = null;

    /**
     * @var string $typeCode
     */
    private $typeCode = null;

    /**
     * @var string $exemptionReason
     */
    private $exemptionReason = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $basisAmount
     */
    private $basisAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $lineTotalBasisAmount
     */
    private $lineTotalBasisAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType $allowanceChargeBasisAmount
     */
    private $allowanceChargeBasisAmount = null;

    /**
     * @var string $categoryCode
     */
    private $categoryCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\CodeType $exemptionReasonCode
     */
    private $exemptionReasonCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateType $taxPointDate
     */
    private $taxPointDate = null;

    /**
     * @var string $dueDateTypeCode
     */
    private $dueDateTypeCode = null;

    /**
     * @var float $rateApplicablePercent
     */
    private $rateApplicablePercent = null;

    /**
     * Gets as calculatedAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getCalculatedAmount()
    {
        return $this->calculatedAmount;
    }

    /**
     * Sets a new calculatedAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $calculatedAmount
     * @return self
     */
    public function setCalculatedAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $calculatedAmount = null)
    {
        $this->calculatedAmount = $calculatedAmount;
        return $this;
    }

    /**
     * Gets as typeCode
     *
     * @return string
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
     * @return string
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
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getBasisAmount()
    {
        return $this->basisAmount;
    }

    /**
     * Sets a new basisAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $basisAmount
     * @return self
     */
    public function setBasisAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $basisAmount = null)
    {
        $this->basisAmount = $basisAmount;
        return $this;
    }

    /**
     * Gets as lineTotalBasisAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getLineTotalBasisAmount()
    {
        return $this->lineTotalBasisAmount;
    }

    /**
     * Sets a new lineTotalBasisAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $lineTotalBasisAmount
     * @return self
     */
    public function setLineTotalBasisAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $lineTotalBasisAmount = null)
    {
        $this->lineTotalBasisAmount = $lineTotalBasisAmount;
        return $this;
    }

    /**
     * Gets as allowanceChargeBasisAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType
     */
    public function getAllowanceChargeBasisAmount()
    {
        return $this->allowanceChargeBasisAmount;
    }

    /**
     * Sets a new allowanceChargeBasisAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $allowanceChargeBasisAmount
     * @return self
     */
    public function setAllowanceChargeBasisAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $allowanceChargeBasisAmount = null)
    {
        $this->allowanceChargeBasisAmount = $allowanceChargeBasisAmount;
        return $this;
    }

    /**
     * Gets as categoryCode
     *
     * @return string
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
     * @return \horstoeko\zugferd\entities\extended\udt\CodeType
     */
    public function getExemptionReasonCode()
    {
        return $this->exemptionReasonCode;
    }

    /**
     * Sets a new exemptionReasonCode
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\CodeType $exemptionReasonCode
     * @return self
     */
    public function setExemptionReasonCode(?\horstoeko\zugferd\entities\extended\udt\CodeType $exemptionReasonCode = null)
    {
        $this->exemptionReasonCode = $exemptionReasonCode;
        return $this;
    }

    /**
     * Gets as taxPointDate
     *
     * @return \horstoeko\zugferd\entities\extended\udt\DateType
     */
    public function getTaxPointDate()
    {
        return $this->taxPointDate;
    }

    /**
     * Sets a new taxPointDate
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateType $taxPointDate
     * @return self
     */
    public function setTaxPointDate(?\horstoeko\zugferd\entities\extended\udt\DateType $taxPointDate = null)
    {
        $this->taxPointDate = $taxPointDate;
        return $this;
    }

    /**
     * Gets as dueDateTypeCode
     *
     * @return string
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
     * @return float
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
