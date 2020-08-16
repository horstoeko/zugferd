<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradeCountryType
 *
 *
 * XSD Type: TradeCountryType
 */
class TradeCountryType
{

    /**
     * @property string $iD
     */
    private $iD = null;

    /**
     * Gets as iD
     *
     * @return string
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param string $iD
     * @return self
     */
    public function setID($iD)
    {
        $this->iD = $iD;
        return $this;
    }


}

