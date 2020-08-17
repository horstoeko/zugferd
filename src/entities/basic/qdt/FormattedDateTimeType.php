<?php

namespace horstoeko\zugferd\basic\qdt;

/**
 * Class representing FormattedDateTimeType
 *
 *
 * XSD Type: FormattedDateTimeType
 */
class FormattedDateTimeType
{

    /**
     * @var \horstoeko\zugferd\basic\qdt\FormattedDateTimeType\DateTimeStringAType $dateTimeString
     */
    private $dateTimeString = null;

    /**
     * Gets as dateTimeString
     *
     * @return \horstoeko\zugferd\basic\qdt\FormattedDateTimeType\DateTimeStringAType
     */
    public function getDateTimeString()
    {
        return $this->dateTimeString;
    }

    /**
     * Sets a new dateTimeString
     *
     * @param \horstoeko\zugferd\basic\qdt\FormattedDateTimeType\DateTimeStringAType $dateTimeString
     * @return self
     */
    public function setDateTimeString(\horstoeko\zugferd\basic\qdt\FormattedDateTimeType\DateTimeStringAType $dateTimeString)
    {
        $this->dateTimeString = $dateTimeString;
        return $this;
    }


}

