<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing TradePaymentTermsType
 *
 *
 * XSD Type: TradePaymentTermsType
 */
class TradePaymentTermsType
{

    /**
     * @var \horstoeko\zugferd\basicwl\udt\DateTimeType $dueDateDateTime
     */
    private $dueDateDateTime = null;

    /**
     * @var \horstoeko\zugferd\basicwl\udt\IDType $directDebitMandateID
     */
    private $directDebitMandateID = null;

    /**
     * Gets as dueDateDateTime
     *
     * @return \horstoeko\zugferd\basicwl\udt\DateTimeType
     */
    public function getDueDateDateTime()
    {
        return $this->dueDateDateTime;
    }

    /**
     * Sets a new dueDateDateTime
     *
     * @param \horstoeko\zugferd\basicwl\udt\DateTimeType $dueDateDateTime
     * @return self
     */
    public function setDueDateDateTime(\horstoeko\zugferd\basicwl\udt\DateTimeType $dueDateDateTime)
    {
        $this->dueDateDateTime = $dueDateDateTime;
        return $this;
    }

    /**
     * Gets as directDebitMandateID
     *
     * @return \horstoeko\zugferd\basicwl\udt\IDType
     */
    public function getDirectDebitMandateID()
    {
        return $this->directDebitMandateID;
    }

    /**
     * Sets a new directDebitMandateID
     *
     * @param \horstoeko\zugferd\basicwl\udt\IDType $directDebitMandateID
     * @return self
     */
    public function setDirectDebitMandateID(\horstoeko\zugferd\basicwl\udt\IDType $directDebitMandateID)
    {
        $this->directDebitMandateID = $directDebitMandateID;
        return $this;
    }


}

