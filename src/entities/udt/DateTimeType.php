<?php

namespace horstoeko\zugferd\udt;

/**
 * Class representing DateTimeType
 *
 *
 * XSD Type: DateTimeType
 */
class DateTimeType
{

    /**
     * @property \horstoeko\zugferd\udt\DateTimeType\DateTimeStringAType
     * $dateTimeString
     */
    private $dateTimeString = null;

    /**
     * @property \DateTime $dateTime
     */
    private $dateTime = null;

    /**
     * Gets as dateTimeString
     *
     * @return \horstoeko\zugferd\udt\DateTimeType\DateTimeStringAType
     */
    public function getDateTimeString()
    {
        return $this->dateTimeString;
    }

    /**
     * Sets a new dateTimeString
     *
     * @param \horstoeko\zugferd\udt\DateTimeType\DateTimeStringAType $dateTimeString
     * @return self
     */
    public function setDateTimeString(\horstoeko\zugferd\udt\DateTimeType\DateTimeStringAType $dateTimeString)
    {
        $this->dateTimeString = $dateTimeString;
        return $this;
    }

    /**
     * Gets as dateTime
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Sets a new dateTime
     *
     * @param \DateTime $dateTime
     * @return self
     */
    public function setDateTime(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
        return $this;
    }


}

