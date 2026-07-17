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
     * @var string|null $sourceCurrencyCode
     */
    private $sourceCurrencyCode = null;

    /**
     * @var string|null $targetCurrencyCode
     */
    private $targetCurrencyCode = null;

    /**
     * @var float|null $conversionRate
     */
    private $conversionRate = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $conversionRateDateTime
     */
    private $conversionRateDateTime = null;

    /**
     * Gets as sourceCurrencyCode
     *
     * @return string|null
     */
    public function getSourceCurrencyCode()
    {
        return $this->sourceCurrencyCode;
    }

    /**
     * Sets a new sourceCurrencyCode
     *
     * @param  string $sourceCurrencyCode
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
     * @return string|null
     */
    public function getTargetCurrencyCode()
    {
        return $this->targetCurrencyCode;
    }

    /**
     * Sets a new targetCurrencyCode
     *
     * @param  string $targetCurrencyCode
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
     * @return float|null
     */
    public function getConversionRate()
    {
        return $this->conversionRate;
    }

    /**
     * Sets a new conversionRate
     *
     * @param  float $conversionRate
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
     * @return \horstoeko\zugferd\entities\extended\udt\DateTimeType|null
     */
    public function getConversionRateDateTime()
    {
        return $this->conversionRateDateTime;
    }

    /**
     * Sets a new conversionRateDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $conversionRateDateTime
     * @return self
     */
    public function setConversionRateDateTime(?\horstoeko\zugferd\entities\extended\udt\DateTimeType $conversionRateDateTime = null)
    {
        $this->conversionRateDateTime = $conversionRateDateTime;
        return $this;
    }
}
