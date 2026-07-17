<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeCountryType
 *
 * XSD Type: TradeCountryType
 */
class TradeCountryType
{

    /**
     * @var string|null $iD
     */
    private $iD = null;

    /**
     * Gets as iD
     *
     * @return string|null
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
