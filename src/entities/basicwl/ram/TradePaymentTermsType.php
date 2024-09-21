<?php

namespace horstoeko\zugferd\entities\basicwl\ram;

/**
 * Class representing TradePaymentTermsType
 *
 * XSD Type: TradePaymentTermsType
 */
class TradePaymentTermsType
{

    /**
     * @var string $description
     */
    private $description = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\DateTimeType $dueDateDateTime
     */
    private $dueDateDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\IDType $directDebitMandateID
     */
    private $directDebitMandateID = null;

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
     * @return \horstoeko\zugferd\entities\basicwl\udt\DateTimeType
     */
    public function getDueDateDateTime()
    {
        return $this->dueDateDateTime;
    }

    /**
     * Sets a new dueDateDateTime
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\DateTimeType $dueDateDateTime
     * @return self
     */
    public function setDueDateDateTime(?\horstoeko\zugferd\entities\basicwl\udt\DateTimeType $dueDateDateTime = null)
    {
        $this->dueDateDateTime = $dueDateDateTime;
        return $this;
    }

    /**
     * Gets as directDebitMandateID
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\IDType
     */
    public function getDirectDebitMandateID()
    {
        return $this->directDebitMandateID;
    }

    /**
     * Sets a new directDebitMandateID
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IDType $directDebitMandateID
     * @return self
     */
    public function setDirectDebitMandateID(?\horstoeko\zugferd\entities\basicwl\udt\IDType $directDebitMandateID = null)
    {
        $this->directDebitMandateID = $directDebitMandateID;
        return $this;
    }
}
