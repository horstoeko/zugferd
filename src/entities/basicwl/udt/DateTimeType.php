<?php

namespace horstoeko\zugferd\basicwl\udt;

/**
 * Class representing DateTimeType
 *
 *
 * XSD Type: DateTimeType
 */
class DateTimeType
{

    /**
     * @var \horstoeko\zugferd\basicwl\udt\DateTimeType\DateTimeStringAType $dateTimeString
     */
    private $dateTimeString = null;

    /**
     * Gets as dateTimeString
     *
     * @return \horstoeko\zugferd\basicwl\udt\DateTimeType\DateTimeStringAType
     */
    public function getDateTimeString()
    {
        return $this->dateTimeString;
    }

    /**
     * Sets a new dateTimeString
     *
     * @param \horstoeko\zugferd\basicwl\udt\DateTimeType\DateTimeStringAType $dateTimeString
     * @return self
     */
    public function setDateTimeString(\horstoeko\zugferd\basicwl\udt\DateTimeType\DateTimeStringAType $dateTimeString)
    {
        $this->dateTimeString = $dateTimeString;
        return $this;
    }


}

