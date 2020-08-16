<?php

namespace horstoeko\zugferd\udt;

/**
 * Class representing DateType
 *
 *
 * XSD Type: DateType
 */
class DateType
{

    /**
     * @property \horstoeko\zugferd\udt\DateType\DateStringAType $dateString
     */
    private $dateString = null;

    /**
     * Gets as dateString
     *
     * @return \horstoeko\zugferd\udt\DateType\DateStringAType
     */
    public function getDateString()
    {
        return $this->dateString;
    }

    /**
     * Sets a new dateString
     *
     * @param \horstoeko\zugferd\udt\DateType\DateStringAType $dateString
     * @return self
     */
    public function setDateString(\horstoeko\zugferd\udt\DateType\DateStringAType $dateString)
    {
        $this->dateString = $dateString;
        return $this;
    }


}

