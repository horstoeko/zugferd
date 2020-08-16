<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradePaymentTermsType
 *
 *
 * XSD Type: TradePaymentTermsType
 */
class TradePaymentTermsType
{

    /**
     * @property string $description
     */
    private $description = null;

    /**
     * @property \horstoeko\zugferd\udt\DateTimeType $dueDateDateTime
     */
    private $dueDateDateTime = null;

    /**
     * @property \horstoeko\zugferd\udt\IDType $directDebitMandateID
     */
    private $directDebitMandateID = null;

    /**
     * @property \horstoeko\zugferd\udt\AmountType $partialPaymentAmount
     */
    private $partialPaymentAmount = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePaymentPenaltyTermsType
     * $applicableTradePaymentPenaltyTerms
     */
    private $applicableTradePaymentPenaltyTerms = null;

    /**
     * @property \horstoeko\zugferd\ram\TradePaymentDiscountTermsType
     * $applicableTradePaymentDiscountTerms
     */
    private $applicableTradePaymentDiscountTerms = null;

    /**
     * Gets as description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets a new description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets as dueDateDateTime
     *
     * @return \horstoeko\zugferd\udt\DateTimeType
     */
    public function getDueDateDateTime()
    {
        return $this->dueDateDateTime;
    }

    /**
     * Sets a new dueDateDateTime
     *
     * @param \horstoeko\zugferd\udt\DateTimeType $dueDateDateTime
     * @return self
     */
    public function setDueDateDateTime(\horstoeko\zugferd\udt\DateTimeType $dueDateDateTime)
    {
        $this->dueDateDateTime = $dueDateDateTime;
        return $this;
    }

    /**
     * Gets as directDebitMandateID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getDirectDebitMandateID()
    {
        return $this->directDebitMandateID;
    }

    /**
     * Sets a new directDebitMandateID
     *
     * @param \horstoeko\zugferd\udt\IDType $directDebitMandateID
     * @return self
     */
    public function setDirectDebitMandateID(\horstoeko\zugferd\udt\IDType $directDebitMandateID)
    {
        $this->directDebitMandateID = $directDebitMandateID;
        return $this;
    }

    /**
     * Gets as partialPaymentAmount
     *
     * @return \horstoeko\zugferd\udt\AmountType
     */
    public function getPartialPaymentAmount()
    {
        return $this->partialPaymentAmount;
    }

    /**
     * Sets a new partialPaymentAmount
     *
     * @param \horstoeko\zugferd\udt\AmountType $partialPaymentAmount
     * @return self
     */
    public function setPartialPaymentAmount(\horstoeko\zugferd\udt\AmountType $partialPaymentAmount)
    {
        $this->partialPaymentAmount = $partialPaymentAmount;
        return $this;
    }

    /**
     * Gets as applicableTradePaymentPenaltyTerms
     *
     * @return \horstoeko\zugferd\ram\TradePaymentPenaltyTermsType
     */
    public function getApplicableTradePaymentPenaltyTerms()
    {
        return $this->applicableTradePaymentPenaltyTerms;
    }

    /**
     * Sets a new applicableTradePaymentPenaltyTerms
     *
     * @param \horstoeko\zugferd\ram\TradePaymentPenaltyTermsType
     * $applicableTradePaymentPenaltyTerms
     * @return self
     */
    public function setApplicableTradePaymentPenaltyTerms(\horstoeko\zugferd\ram\TradePaymentPenaltyTermsType $applicableTradePaymentPenaltyTerms)
    {
        $this->applicableTradePaymentPenaltyTerms = $applicableTradePaymentPenaltyTerms;
        return $this;
    }

    /**
     * Gets as applicableTradePaymentDiscountTerms
     *
     * @return \horstoeko\zugferd\ram\TradePaymentDiscountTermsType
     */
    public function getApplicableTradePaymentDiscountTerms()
    {
        return $this->applicableTradePaymentDiscountTerms;
    }

    /**
     * Sets a new applicableTradePaymentDiscountTerms
     *
     * @param \horstoeko\zugferd\ram\TradePaymentDiscountTermsType
     * $applicableTradePaymentDiscountTerms
     * @return self
     */
    public function setApplicableTradePaymentDiscountTerms(\horstoeko\zugferd\ram\TradePaymentDiscountTermsType $applicableTradePaymentDiscountTerms)
    {
        $this->applicableTradePaymentDiscountTerms = $applicableTradePaymentDiscountTerms;
        return $this;
    }


}

