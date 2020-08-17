<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing LineTradeAgreementType
 *
 *
 * XSD Type: LineTradeAgreementType
 */
class LineTradeAgreementType
{

    /**
     * @var \horstoeko\zugferd\basic\ram\TradePriceType $netPriceProductTradePrice
     */
    private $netPriceProductTradePrice = null;

    /**
     * Gets as netPriceProductTradePrice
     *
     * @return \horstoeko\zugferd\basic\ram\TradePriceType
     */
    public function getNetPriceProductTradePrice()
    {
        return $this->netPriceProductTradePrice;
    }

    /**
     * Sets a new netPriceProductTradePrice
     *
     * @param \horstoeko\zugferd\basic\ram\TradePriceType $netPriceProductTradePrice
     * @return self
     */
    public function setNetPriceProductTradePrice(\horstoeko\zugferd\basic\ram\TradePriceType $netPriceProductTradePrice)
    {
        $this->netPriceProductTradePrice = $netPriceProductTradePrice;
        return $this;
    }


}

