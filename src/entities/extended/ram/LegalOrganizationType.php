<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing LegalOrganizationType
 *
 * XSD Type: LegalOrganizationType
 */
class LegalOrganizationType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType|null $iD
     */
    private $iD = null;

    /**
     * @var string|null $tradingBusinessName
     */
    private $tradingBusinessName = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradeAddressType|null $postalTradeAddress
     */
    private $postalTradeAddress = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType|null
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType|null $iD
     * @return self
     */
    public function setID(?\horstoeko\zugferd\entities\extended\udt\IDType $iD = null)
    {
        $this->iD = $iD;
        return $this;
    }

    /**
     * Gets as tradingBusinessName
     *
     * @return string|null
     */
    public function getTradingBusinessName()
    {
        return $this->tradingBusinessName;
    }

    /**
     * Sets a new tradingBusinessName
     *
     * @param  string $tradingBusinessName
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
     * @return \horstoeko\zugferd\entities\extended\ram\TradeAddressType|null
     */
    public function getPostalTradeAddress()
    {
        return $this->postalTradeAddress;
    }

    /**
     * Sets a new postalTradeAddress
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeAddressType|null $postalTradeAddress
     * @return self
     */
    public function setPostalTradeAddress(?\horstoeko\zugferd\entities\extended\ram\TradeAddressType $postalTradeAddress = null)
    {
        $this->postalTradeAddress = $postalTradeAddress;
        return $this;
    }
}
