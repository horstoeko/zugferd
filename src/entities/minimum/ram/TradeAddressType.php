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
     * @var string|null $countryID
     */
    private $countryID = null;

    /**
     * Gets as countryID
     *
     * @return string|null
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
