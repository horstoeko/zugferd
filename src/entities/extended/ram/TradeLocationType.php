<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeLocationType
 *
 * XSD Type: TradeLocationType
 */
class TradeLocationType
{

    /**
     * @var string $countryID
     */
    private $countryID = null;

    /**
     * @var string $name
     */
    private $name = null;

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

    /**
     * Gets as name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param  string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
