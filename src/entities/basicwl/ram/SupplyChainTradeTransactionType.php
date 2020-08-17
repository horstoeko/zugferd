<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing SupplyChainTradeTransactionType
 *
 *
 * XSD Type: SupplyChainTradeTransactionType
 */
class SupplyChainTradeTransactionType
{

    /**
     * @var \horstoeko\zugferd\basicwl\ram\HeaderTradeAgreementType $applicableHeaderTradeAgreement
     */
    private $applicableHeaderTradeAgreement = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\HeaderTradeDeliveryType $applicableHeaderTradeDelivery
     */
    private $applicableHeaderTradeDelivery = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\HeaderTradeSettlementType $applicableHeaderTradeSettlement
     */
    private $applicableHeaderTradeSettlement = null;

    /**
     * Gets as applicableHeaderTradeAgreement
     *
     * @return \horstoeko\zugferd\basicwl\ram\HeaderTradeAgreementType
     */
    public function getApplicableHeaderTradeAgreement()
    {
        return $this->applicableHeaderTradeAgreement;
    }

    /**
     * Sets a new applicableHeaderTradeAgreement
     *
     * @param \horstoeko\zugferd\basicwl\ram\HeaderTradeAgreementType $applicableHeaderTradeAgreement
     * @return self
     */
    public function setApplicableHeaderTradeAgreement(\horstoeko\zugferd\basicwl\ram\HeaderTradeAgreementType $applicableHeaderTradeAgreement)
    {
        $this->applicableHeaderTradeAgreement = $applicableHeaderTradeAgreement;
        return $this;
    }

    /**
     * Gets as applicableHeaderTradeDelivery
     *
     * @return \horstoeko\zugferd\basicwl\ram\HeaderTradeDeliveryType
     */
    public function getApplicableHeaderTradeDelivery()
    {
        return $this->applicableHeaderTradeDelivery;
    }

    /**
     * Sets a new applicableHeaderTradeDelivery
     *
     * @param \horstoeko\zugferd\basicwl\ram\HeaderTradeDeliveryType $applicableHeaderTradeDelivery
     * @return self
     */
    public function setApplicableHeaderTradeDelivery(\horstoeko\zugferd\basicwl\ram\HeaderTradeDeliveryType $applicableHeaderTradeDelivery)
    {
        $this->applicableHeaderTradeDelivery = $applicableHeaderTradeDelivery;
        return $this;
    }

    /**
     * Gets as applicableHeaderTradeSettlement
     *
     * @return \horstoeko\zugferd\basicwl\ram\HeaderTradeSettlementType
     */
    public function getApplicableHeaderTradeSettlement()
    {
        return $this->applicableHeaderTradeSettlement;
    }

    /**
     * Sets a new applicableHeaderTradeSettlement
     *
     * @param \horstoeko\zugferd\basicwl\ram\HeaderTradeSettlementType $applicableHeaderTradeSettlement
     * @return self
     */
    public function setApplicableHeaderTradeSettlement(\horstoeko\zugferd\basicwl\ram\HeaderTradeSettlementType $applicableHeaderTradeSettlement)
    {
        $this->applicableHeaderTradeSettlement = $applicableHeaderTradeSettlement;
        return $this;
    }


}

