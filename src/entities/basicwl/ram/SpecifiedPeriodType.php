<?php

namespace horstoeko\zugferd\entities\basicwl\ram;

/**
 * Class representing SpecifiedPeriodType
 *
 * XSD Type: SpecifiedPeriodType
 */
class SpecifiedPeriodType
{

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\DateTimeType|null $startDateTime
     */
    private $startDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\DateTimeType|null $endDateTime
     */
    private $endDateTime = null;

    /**
     * Gets as startDateTime
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\DateTimeType|null
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * Sets a new startDateTime
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\DateTimeType|null $startDateTime
     * @return self
     */
    public function setStartDateTime(?\horstoeko\zugferd\entities\basicwl\udt\DateTimeType $startDateTime = null)
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    /**
     * Gets as endDateTime
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\DateTimeType|null
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * Sets a new endDateTime
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\DateTimeType|null $endDateTime
     * @return self
     */
    public function setEndDateTime(?\horstoeko\zugferd\entities\basicwl\udt\DateTimeType $endDateTime = null)
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }
}
