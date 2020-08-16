<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradeCurrencyExchangeType
 *
 *
 * XSD Type: TradeCurrencyExchangeType
 */
class TradeCurrencyExchangeType
{

    /**
     * @property string $sourceCurrencyCode
     */
    private $sourceCurrencyCode = null;

    /**
     * @property string $targetCurrencyCode
     */
    private $targetCurrencyCode = null;

    /**
     * @property float $conversionRate
     */
    private $conversionRate = null;

    /**
     * @property \horstoeko\zugferd\udt\DateTimeType $conversionRateDateTime
     */
    private $conversionRateDateTime = null;

    /**
     * Gets as sourceCurrencyCode
     *
     * @return string
     */
    public function getSourceCurrencyCode()
    {
        return $this->sourceCurrencyCode;
    }

    /**
     * Sets a new sourceCurrencyCode
     *
     * @param string $sourceCurrencyCode
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
     * @return string
     */
    public function getTargetCurrencyCode()
    {
        return $this->targetCurrencyCode;
    }

    /**
     * Sets a new targetCurrencyCode
     *
     * @param string $targetCurrencyCode
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
     * @return float
     */
    public function getConversionRate()
    {
        return $this->conversionRate;
    }

    /**
     * Sets a new conversionRate
     *
     * @param float $conversionRate
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
     * @return \horstoeko\zugferd\udt\DateTimeType
     */
    public function getConversionRateDateTime()
    {
        return $this->conversionRateDateTime;
    }

    /**
     * Sets a new conversionRateDateTime
     *
     * @param \horstoeko\zugferd\udt\DateTimeType $conversionRateDateTime
     * @return self
     */
    public function setConversionRateDateTime(\horstoeko\zugferd\udt\DateTimeType $conversionRateDateTime)
    {
        $this->conversionRateDateTime = $conversionRateDateTime;
        return $this;
    }


}

