<?php

namespace horstoeko\zugferd\entities\basic\qdt;

/**
 * Class representing FormattedDateTimeType
 *
 * XSD Type: FormattedDateTimeType
 */
class FormattedDateTimeType
{

    /**
     * @var \horstoeko\zugferd\entities\basic\qdt\FormattedDateTimeType\DateTimeStringAType|null $dateTimeString
     */
    private $dateTimeString = null;

    /**
     * Gets as dateTimeString
     *
     * @return \horstoeko\zugferd\entities\basic\qdt\FormattedDateTimeType\DateTimeStringAType|null
     */
    public function getDateTimeString()
    {
        return $this->dateTimeString;
    }

    /**
     * Sets a new dateTimeString
     *
     * @param  \horstoeko\zugferd\entities\basic\qdt\FormattedDateTimeType\DateTimeStringAType $dateTimeString
     * @return self
     */
    public function setDateTimeString(\horstoeko\zugferd\entities\basic\qdt\FormattedDateTimeType\DateTimeStringAType $dateTimeString)
    {
        $this->dateTimeString = $dateTimeString;
        return $this;
    }
}
