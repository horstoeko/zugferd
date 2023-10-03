<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeCurrencyExchangeType
 *
 * XSD Type: TradeCurrencyExchangeType
 */
class TradeCurrencyExchangeType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\qdt\CurrencyCodeType $sourceCurrencyCode $sourceCurrencyCode
     */
    private $sourceCurrencyCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\qdt\CurrencyCodeType $sourceCurrencyCode $targetCurrencyCode
     */
    private $targetCurrencyCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\RateType $conversionRate
     */
    private $conversionRate = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType $conversionRateDateTime
     */
    private $conversionRateDateTime = null;

    /**
     * Gets as sourceCurrencyCode
     *
     * @return \horstoeko\zugferd\entities\extended\qdt\CurrencyCodeType

     */
    public function getSourceCurrencyCode()
    {
        return $this->sourceCurrencyCode;
    }

    /**
     * Sets a new sourceCurrencyCode
     *
     * @param  \horstoeko\zugferd\entities\extended\qdt\CurrencyCodeType $sourceCurrencyCode
     * @return self
     */
    public function setSourceCurrencyCode($sourceCurrencyCode)
    {
        $this->sourceCurrencyCode = $sourceCurrencyCode;
        return $this;
    }

    /**
     * Gets as targetCurrencyCode
     *
     * @return \horstoeko\zugferd\entities\extended\qdt\CurrencyCodeType $sourceCurrencyCode
     */
    public function getTargetCurrencyCode()
    {
        return $this->targetCurrencyCode;
    }

    /**
     * Sets a new targetCurrencyCode
     *
     * @param  \horstoeko\zugferd\entities\extended\qdt\CurrencyCodeType $sourceCurrencyCode $targetCurrencyCode
     * @return self
     */
    public function setTargetCurrencyCode($targetCurrencyCode)
    {
        $this->targetCurrencyCode = $targetCurrencyCode;
        return $this;
    }

    /**
     * Gets as conversionRate
     *
     * @return \horstoeko\zugferd\entities\extended\udt\RateType
     */
    public function getConversionRate()
    {
        return $this->conversionRate;
    }

    /**
     * Sets a new conversionRate
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\RateType $conversionRate
     * @return self
     */
    public function setConversionRate($conversionRate)
    {
        $this->conversionRate = $conversionRate;
        return $this;
    }

    /**
     * Gets as conversionRateDateTime
     *
     * @return \horstoeko\zugferd\entities\extended\udt\DateTimeType
     */
    public function getConversionRateDateTime()
    {
        return $this->conversionRateDateTime;
    }

    /**
     * Sets a new conversionRateDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateTimeType $conversionRateDateTime
     * @return self
     */
    public function setConversionRateDateTime(\horstoeko\zugferd\entities\extended\udt\DateTimeType $conversionRateDateTime)
    {
        $this->conversionRateDateTime = $conversionRateDateTime;
        return $this;
    }
}
