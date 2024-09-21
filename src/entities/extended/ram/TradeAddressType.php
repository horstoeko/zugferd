<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeAddressType
 *
 * XSD Type: TradeAddressType
 */
class TradeAddressType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\CodeType $postcodeCode
     */
    private $postcodeCode = null;

    /**
     * @var string $lineOne
     */
    private $lineOne = null;

    /**
     * @var string $lineTwo
     */
    private $lineTwo = null;

    /**
     * @var string $lineThree
     */
    private $lineThree = null;

    /**
     * @var string $cityName
     */
    private $cityName = null;

    /**
     * @var string $countryID
     */
    private $countryID = null;

    /**
     * @var string $countrySubDivisionName
     */
    private $countrySubDivisionName = null;

    /**
     * Gets as postcodeCode
     *
     * @return \horstoeko\zugferd\entities\extended\udt\CodeType
     */
    public function getPostcodeCode()
    {
        return $this->postcodeCode;
    }

    /**
     * Sets a new postcodeCode
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\CodeType $postcodeCode
     * @return self
     */
    public function setPostcodeCode(?\horstoeko\zugferd\entities\extended\udt\CodeType $postcodeCode = null)
    {
        $this->postcodeCode = $postcodeCode;
        return $this;
    }

    /**
     * Gets as lineOne
     *
     * @return string
     */
    public function getLineOne()
    {
        return $this->lineOne;
    }

    /**
     * Sets a new lineOne
     *
     * @param  string $lineOne
     * @return self
     */
    public function setLineOne($lineOne)
    {
        $this->lineOne = $lineOne;
        return $this;
    }

    /**
     * Gets as lineTwo
     *
     * @return string
     */
    public function getLineTwo()
    {
        return $this->lineTwo;
    }

    /**
     * Sets a new lineTwo
     *
     * @param  string $lineTwo
     * @return self
     */
    public function setLineTwo($lineTwo)
    {
        $this->lineTwo = $lineTwo;
        return $this;
    }

    /**
     * Gets as lineThree
     *
     * @return string
     */
    public function getLineThree()
    {
        return $this->lineThree;
    }

    /**
     * Sets a new lineThree
     *
     * @param  string $lineThree
     * @return self
     */
    public function setLineThree($lineThree)
    {
        $this->lineThree = $lineThree;
        return $this;
    }

    /**
     * Gets as cityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Sets a new cityName
     *
     * @param  string $cityName
     * @return self
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;
        return $this;
    }

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
     * Gets as countrySubDivisionName
     *
     * @return string
     */
    public function getCountrySubDivisionName()
    {
        return $this->countrySubDivisionName;
    }

    /**
     * Sets a new countrySubDivisionName
     *
     * @param  string $countrySubDivisionName
     * @return self
     */
    public function setCountrySubDivisionName($countrySubDivisionName)
    {
        $this->countrySubDivisionName = $countrySubDivisionName;
        return $this;
    }
}
