<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeDeliveryTermsType
 *
 * XSD Type: TradeDeliveryTermsType
 */
class TradeDeliveryTermsType
{

    /**
     * @var string $deliveryTypeCode
     */
    private $deliveryTypeCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradeLocationType $relevantTradeLocation
     */
    private $relevantTradeLocation = null;

    /**
     * Gets as deliveryTypeCode
     *
     * @return string
     */
    public function getDeliveryTypeCode()
    {
        return $this->deliveryTypeCode;
    }

    /**
     * Sets a new deliveryTypeCode
     *
     * @param  string $deliveryTypeCode
     * @return self
     */
    public function setDeliveryTypeCode($deliveryTypeCode)
    {
        $this->deliveryTypeCode = $deliveryTypeCode;
        return $this;
    }

    /**
     * Gets as relevantTradeLocation
     *
     * @return \horstoeko\zugferd\entities\extended\ram\TradeLocationType
     */
    public function getRelevantTradeLocation()
    {
        return $this->relevantTradeLocation;
    }

    /**
     * Sets a new relevantTradeLocation
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeLocationType $relevantTradeLocation
     * @return self
     */
    public function setRelevantTradeLocation(?\horstoeko\zugferd\entities\extended\ram\TradeLocationType $relevantTradeLocation = null)
    {
        $this->relevantTradeLocation = $relevantTradeLocation;
        return $this;
    }
}
