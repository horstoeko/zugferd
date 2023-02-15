<?php

namespace horstoeko\zugferd\entities\basicwl\ram;

/**
 * Class representing TradeAccountingAccountType
 *
 * XSD Type: TradeAccountingAccountType
 */
class TradeAccountingAccountType
{

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\IDType $iD
     */
    private $iD = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\IDType
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\entities\basicwl\udt\IDType $iD)
    {
        $this->iD = $iD;
        return $this;
    }
}
