<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradeSettlementFinancialCardType
 *
 *
 * XSD Type: TradeSettlementFinancialCardType
 */
class TradeSettlementFinancialCardType
{

    /**
     * @var \horstoeko\zugferd\udt\IDType $iD
     */
    private $iD = null;

    /**
     * @var string $cardholderName
     */
    private $cardholderName = null;

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
     * Gets as cardholderName
     *
     * @return string
     */
    public function getCardholderName()
    {
        return $this->cardholderName;
    }

    /**
     * Sets a new cardholderName
     *
     * @param string $cardholderName
     * @return self
     */
    public function setCardholderName($cardholderName)
    {
        $this->cardholderName = $cardholderName;
        return $this;
    }


}

