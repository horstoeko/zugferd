<?php

namespace horstoeko\zugferd\entities\extended\udt;

/**
 * Class representing DateType
 *
 * XSD Type: DateType
 */
class DateType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateType\DateStringAType $dateString
     */
    private $dateString = null;

    /**
     * Gets as dateString
     *
     * @return \horstoeko\zugferd\entities\extended\udt\DateType\DateStringAType
     */
    public function getDateString()
    {
        return $this->dateString;
    }

    /**
     * Sets a new dateString
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateType\DateStringAType $dateString
     * @return self
     */
    public function setDateString(?\horstoeko\zugferd\entities\extended\udt\DateType\DateStringAType $dateString = null)
    {
        $this->dateString = $dateString;
        return $this;
    }
}
