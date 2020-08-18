<?php

namespace horstoeko\zugferd\entities\basic\ram;

/**
 * Class representing TradePaymentTermsType
 *
 *
 * XSD Type: TradePaymentTermsType
 */
class TradePaymentTermsType
{

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\DateTimeType $dueDateDateTime
     */
    private $dueDateDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\IDType $directDebitMandateID
     */
    private $directDebitMandateID = null;

    /**
     * Gets as dueDateDateTime
     *
     * @return \horstoeko\zugferd\entities\basic\udt\DateTimeType
     */
    public function getDueDateDateTime()
    {
        return $this->dueDateDateTime;
    }

    /**
     * Sets a new dueDateDateTime
     *
     * @param \horstoeko\zugferd\entities\basic\udt\DateTimeType $dueDateDateTime
     * @return self
     */
    public function setDueDateDateTime(\horstoeko\zugferd\entities\basic\udt\DateTimeType $dueDateDateTime)
    {
        $this->dueDateDateTime = $dueDateDateTime;
        return $this;
    }

    /**
     * Gets as directDebitMandateID
     *
     * @return \horstoeko\zugferd\entities\basic\udt\IDType
     */
    public function getDirectDebitMandateID()
    {
        return $this->directDebitMandateID;
    }

    /**
     * Sets a new directDebitMandateID
     *
     * @param \horstoeko\zugferd\entities\basic\udt\IDType $directDebitMandateID
     * @return self
     */
    public function setDirectDebitMandateID(\horstoeko\zugferd\entities\basic\udt\IDType $directDebitMandateID)
    {
        $this->directDebitMandateID = $directDebitMandateID;
        return $this;
    }


}

