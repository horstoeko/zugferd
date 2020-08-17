<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing SpecifiedPeriodType
 *
 *
 * XSD Type: SpecifiedPeriodType
 */
class SpecifiedPeriodType
{

    /**
     * @var \horstoeko\zugferd\basicwl\udt\DateTimeType $startDateTime
     */
    private $startDateTime = null;

    /**
     * @var \horstoeko\zugferd\basicwl\udt\DateTimeType $endDateTime
     */
    private $endDateTime = null;

    /**
     * Gets as startDateTime
     *
     * @return \horstoeko\zugferd\basicwl\udt\DateTimeType
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * Sets a new startDateTime
     *
     * @param \horstoeko\zugferd\basicwl\udt\DateTimeType $startDateTime
     * @return self
     */
    public function setStartDateTime(\horstoeko\zugferd\basicwl\udt\DateTimeType $startDateTime)
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    /**
     * Gets as endDateTime
     *
     * @return \horstoeko\zugferd\basicwl\udt\DateTimeType
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * Sets a new endDateTime
     *
     * @param \horstoeko\zugferd\basicwl\udt\DateTimeType $endDateTime
     * @return self
     */
    public function setEndDateTime(\horstoeko\zugferd\basicwl\udt\DateTimeType $endDateTime)
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }


}

