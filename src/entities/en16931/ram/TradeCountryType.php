<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing TradeCountryType
 *
 * XSD Type: TradeCountryType
 */
class TradeCountryType
{

    /**
     * @var string $iD
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
     * @param  string $iD
     * @return self
     */
    public function setID($iD)
    {
        $this->iD = $iD;
        return $this;
    }
}
