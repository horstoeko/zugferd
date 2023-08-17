<?php

namespace horstoeko\zugferd\entities\minimum\ram;

/**
 * Class representing TradeAddressType
 *
 * XSD Type: TradeAddressType
 */
class TradeAddressType
{

    /**
     * @var string $countryID
     */
    private $countryID = null;

    /**
     * Gets as countryID
     *
     * @return string
     */
    public function getCountryID()
    {
        return $this->countryID;
    }

    /**
     * Sets a new countryID
     *
     * @param  string $countryID
     * @return self
     */
    public function setCountryID($countryID)
    {
        $this->countryID = $countryID;
        return $this;
    }
}
