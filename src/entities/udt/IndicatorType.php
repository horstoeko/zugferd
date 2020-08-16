<?php

namespace horstoeko\zugferd\udt;

/**
 * Class representing IndicatorType
 *
 *
 * XSD Type: IndicatorType
 */
class IndicatorType
{

    /**
     * @property boolean $indicator
     */
    private $indicator = null;

    /**
     * Gets as indicator
     *
     * @return boolean
     */
    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * Sets a new indicator
     *
     * @param boolean $indicator
     * @return self
     */
    public function setIndicator($indicator)
    {
        $this->indicator = $indicator;
        return $this;
    }


}

