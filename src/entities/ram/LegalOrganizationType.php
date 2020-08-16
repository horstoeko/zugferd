<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing LegalOrganizationType
 *
 *
 * XSD Type: LegalOrganizationType
 */
class LegalOrganizationType
{

    /**
     * @property \horstoeko\zugferd\udt\IDType $iD
     */
    private $iD = null;

    /**
     * @property string $tradingBusinessName
     */
    private $tradingBusinessName = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeAddressType $postalTradeAddress
     */
    private $postalTradeAddress = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param \horstoeko\zugferd\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\udt\IDType $iD)
    {
        $this->iD = $iD;
        return $this;
    }

    /**
     * Gets as tradingBusinessName
     *
     * @return string
     */
    public function getTradingBusinessName()
    {
        return $this->tradingBusinessName;
    }

    /**
     * Sets a new tradingBusinessName
     *
     * @param string $tradingBusinessName
     * @return self
     */
    public function setTradingBusinessName($tradingBusinessName)
    {
        $this->tradingBusinessName = $tradingBusinessName;
        return $this;
    }

    /**
     * Gets as postalTradeAddress
     *
     * @return \horstoeko\zugferd\ram\TradeAddressType
     */
    public function getPostalTradeAddress()
    {
        return $this->postalTradeAddress;
    }

    /**
     * Sets a new postalTradeAddress
     *
     * @param \horstoeko\zugferd\ram\TradeAddressType $postalTradeAddress
     * @return self
     */
    public function setPostalTradeAddress(\horstoeko\zugferd\ram\TradeAddressType $postalTradeAddress)
    {
        $this->postalTradeAddress = $postalTradeAddress;
        return $this;
    }


}

