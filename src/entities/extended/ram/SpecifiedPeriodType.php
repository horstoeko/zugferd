<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing SpecifiedPeriodType
 *
 * XSD Type: SpecifiedPeriodType
 */
class SpecifiedPeriodType
{

    /**
     * @var string|null $description
     */
    private $description = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $startDateTime
     */
    private $startDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $endDateTime
     */
    private $endDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $completeDateTime
     */
    private $completeDateTime = null;

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
     * Gets as startDateTime
     *
     * @return \horstoeko\zugferd\entities\extended\udt\DateTimeType|null
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * Sets a new startDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $startDateTime
     * @return self
     */
    public function setStartDateTime(?\horstoeko\zugferd\entities\extended\udt\DateTimeType $startDateTime = null)
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    /**
     * Gets as endDateTime
     *
     * @return \horstoeko\zugferd\entities\extended\udt\DateTimeType|null
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * Sets a new endDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $endDateTime
     * @return self
     */
    public function setEndDateTime(?\horstoeko\zugferd\entities\extended\udt\DateTimeType $endDateTime = null)
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }

    /**
     * Gets as completeDateTime
     *
     * @return \horstoeko\zugferd\entities\extended\udt\DateTimeType|null
     */
    public function getCompleteDateTime()
    {
        return $this->completeDateTime;
    }

    /**
     * Sets a new completeDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $completeDateTime
     * @return self
     */
    public function setCompleteDateTime(?\horstoeko\zugferd\entities\extended\udt\DateTimeType $completeDateTime = null)
    {
        $this->completeDateTime = $completeDateTime;
        return $this;
    }
}
