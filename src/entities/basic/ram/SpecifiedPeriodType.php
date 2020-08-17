<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing SpecifiedPeriodType
 *
 *
 * XSD Type: SpecifiedPeriodType
 */
class SpecifiedPeriodType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\DateTimeType $startDateTime
     */
    private $startDateTime = null;

    /**
     * @var \horstoeko\zugferd\basic\udt\DateTimeType $endDateTime
     */
    private $endDateTime = null;

    /**
     * Gets as startDateTime
     *
     * @return \horstoeko\zugferd\basic\udt\DateTimeType
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * Sets a new startDateTime
     *
     * @param \horstoeko\zugferd\basic\udt\DateTimeType $startDateTime
     * @return self
     */
    public function setStartDateTime(\horstoeko\zugferd\basic\udt\DateTimeType $startDateTime)
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    /**
     * Gets as endDateTime
     *
     * @return \horstoeko\zugferd\basic\udt\DateTimeType
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * Sets a new endDateTime
     *
     * @param \horstoeko\zugferd\basic\udt\DateTimeType $endDateTime
     * @return self
     */
    public function setEndDateTime(\horstoeko\zugferd\basic\udt\DateTimeType $endDateTime)
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }


}

