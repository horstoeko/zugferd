<?php

namespace horstoeko\zugferd\entities\basic\ram;

/**
 * Class representing SpecifiedPeriodType
 *
 * XSD Type: SpecifiedPeriodType
 */
class SpecifiedPeriodType
{

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\DateTimeType|null $startDateTime
     */
    private $startDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\DateTimeType|null $endDateTime
     */
    private $endDateTime = null;

    /**
     * Gets as startDateTime
     *
     * @return \horstoeko\zugferd\entities\basic\udt\DateTimeType|null
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * Sets a new startDateTime
     *
     * @param  \horstoeko\zugferd\entities\basic\udt\DateTimeType|null $startDateTime
     * @return self
     */
    public function setStartDateTime(?\horstoeko\zugferd\entities\basic\udt\DateTimeType $startDateTime = null)
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    /**
     * Gets as endDateTime
     *
     * @return \horstoeko\zugferd\entities\basic\udt\DateTimeType|null
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * Sets a new endDateTime
     *
     * @param  \horstoeko\zugferd\entities\basic\udt\DateTimeType|null $endDateTime
     * @return self
     */
    public function setEndDateTime(?\horstoeko\zugferd\entities\basic\udt\DateTimeType $endDateTime = null)
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }
}
