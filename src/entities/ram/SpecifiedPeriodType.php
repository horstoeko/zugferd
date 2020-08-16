<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing SpecifiedPeriodType
 *
 *
 * XSD Type: SpecifiedPeriodType
 */
class SpecifiedPeriodType
{

    /**
     * @property string $description
     */
    private $description = null;

    /**
     * @property \horstoeko\zugferd\udt\DateTimeType $startDateTime
     */
    private $startDateTime = null;

    /**
     * @property \horstoeko\zugferd\udt\DateTimeType $endDateTime
     */
    private $endDateTime = null;

    /**
     * @property \horstoeko\zugferd\udt\DateTimeType $completeDateTime
     */
    private $completeDateTime = null;

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
     * Gets as startDateTime
     *
     * @return \horstoeko\zugferd\udt\DateTimeType
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * Sets a new startDateTime
     *
     * @param \horstoeko\zugferd\udt\DateTimeType $startDateTime
     * @return self
     */
    public function setStartDateTime(\horstoeko\zugferd\udt\DateTimeType $startDateTime)
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    /**
     * Gets as endDateTime
     *
     * @return \horstoeko\zugferd\udt\DateTimeType
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * Sets a new endDateTime
     *
     * @param \horstoeko\zugferd\udt\DateTimeType $endDateTime
     * @return self
     */
    public function setEndDateTime(\horstoeko\zugferd\udt\DateTimeType $endDateTime)
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }

    /**
     * Gets as completeDateTime
     *
     * @return \horstoeko\zugferd\udt\DateTimeType
     */
    public function getCompleteDateTime()
    {
        return $this->completeDateTime;
    }

    /**
     * Sets a new completeDateTime
     *
     * @param \horstoeko\zugferd\udt\DateTimeType $completeDateTime
     * @return self
     */
    public function setCompleteDateTime(\horstoeko\zugferd\udt\DateTimeType $completeDateTime)
    {
        $this->completeDateTime = $completeDateTime;
        return $this;
    }


}

