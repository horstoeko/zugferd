<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradePaymentTermsType
 *
 * XSD Type: TradePaymentTermsType
 */
class TradePaymentTermsType
{

    /**
     * @var string|null $description
     */
    private $description = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $dueDateDateTime
     */
    private $dueDateDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType|null $directDebitMandateID
     */
    private $directDebitMandateID = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType|null $partialPaymentAmount
     */
    private $partialPaymentAmount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentPenaltyTermsType|null $applicableTradePaymentPenaltyTerms
     */
    private $applicableTradePaymentPenaltyTerms = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType|null $applicableTradePaymentDiscountTerms
     */
    private $applicableTradePaymentDiscountTerms = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $payeeTradeParty
     */
    private $payeeTradeParty = null;

    /**
     * Gets as description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets a new description
     *
     * @param  string $description
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
     * @return \horstoeko\zugferd\entities\extended\udt\DateTimeType|null
     */
    public function getDueDateDateTime()
    {
        return $this->dueDateDateTime;
    }

    /**
     * Sets a new dueDateDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $dueDateDateTime
     * @return self
     */
    public function setDueDateDateTime(?\horstoeko\zugferd\entities\extended\udt\DateTimeType $dueDateDateTime = null)
    {
        $this->dueDateDateTime = $dueDateDateTime;
        return $this;
    }

    /**
     * Gets as directDebitMandateID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType|null
     */
    public function getDirectDebitMandateID()
    {
        return $this->directDebitMandateID;
    }

    /**
     * Sets a new directDebitMandateID
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType|null $directDebitMandateID
     * @return self
     */
    public function setDirectDebitMandateID(?\horstoeko\zugferd\entities\extended\udt\IDType $directDebitMandateID = null)
    {
        $this->directDebitMandateID = $directDebitMandateID;
        return $this;
    }

    /**
     * Gets as partialPaymentAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType|null
     */
    public function getPartialPaymentAmount()
    {
        return $this->partialPaymentAmount;
    }

    /**
     * Sets a new partialPaymentAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType|null $partialPaymentAmount
     * @return self
     */
    public function setPartialPaymentAmount(?\horstoeko\zugferd\entities\extended\udt\AmountType $partialPaymentAmount = null)
    {
        $this->partialPaymentAmount = $partialPaymentAmount;
        return $this;
    }

    /**
     * Gets as applicableTradePaymentPenaltyTerms
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePaymentPenaltyTermsType|null
     */
    public function getApplicableTradePaymentPenaltyTerms()
    {
        return $this->applicableTradePaymentPenaltyTerms;
    }

    /**
     * Sets a new applicableTradePaymentPenaltyTerms
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePaymentPenaltyTermsType|null $applicableTradePaymentPenaltyTerms
     * @return self
     */
    public function setApplicableTradePaymentPenaltyTerms(?\horstoeko\zugferd\entities\extended\ram\TradePaymentPenaltyTermsType $applicableTradePaymentPenaltyTerms = null)
    {
        $this->applicableTradePaymentPenaltyTerms = $applicableTradePaymentPenaltyTerms;
        return $this;
    }

    /**
     * Gets as applicableTradePaymentDiscountTerms
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType|null
     */
    public function getApplicableTradePaymentDiscountTerms()
    {
        return $this->applicableTradePaymentDiscountTerms;
    }

    /**
     * Sets a new applicableTradePaymentDiscountTerms
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType|null $applicableTradePaymentDiscountTerms
     * @return self
     */
    public function setApplicableTradePaymentDiscountTerms(?\horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType $applicableTradePaymentDiscountTerms = null)
    {
        $this->applicableTradePaymentDiscountTerms = $applicableTradePaymentDiscountTerms;
        return $this;
    }

    /**
     * Gets as payeeTradeParty
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradePartyType|null
     */
    public function getPayeeTradeParty()
    {
        return $this->payeeTradeParty;
    }

    /**
     * Sets a new payeeTradeParty
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradePartyType|null $payeeTradeParty
     * @return self
     */
    public function setPayeeTradeParty(?\horstoeko\zugferd\entities\extended\ram\TradePartyType $payeeTradeParty = null)
    {
        $this->payeeTradeParty = $payeeTradeParty;
        return $this;
    }
}
