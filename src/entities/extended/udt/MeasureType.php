<?php

namespace horstoeko\zugferd\entities\extended\udt;

/**
 * Class representing MeasureType
 *
 * XSD Type: MeasureType
 */
class MeasureType
{

    /**
     * @var float $__value
     */
    private $__value = null;

    /**
     * @var string $unitCode
     */
    private $unitCode = null;

    /**
     * Construct
     *
     * @param float $value
     */
    public function __construct($value)
    {
        $this->value($value);
    }

    /**
     * Gets or sets the inner value
     *
     * @param  float $value
     * @return float
     */
    public function value()
    {
        if ($args = func_get_args()) {
            $this->__value = $args[0];
        }
        return $this->__value;
    }

    /**
     * Gets a string value
     *
     * @return string
     */
    public function __toString()
    {
        return strval($this->__value);
    }

    /**
     * Gets as unitCode
     *
     * @return string
     */
    public function getUnitCode()
    {
        return $this->unitCode;
    }

    /**
     * Sets a new unitCode
     *
     * @param  string $unitCode
     * @return self
     */
    public function setUnitCode($unitCode)
    {
        $this->unitCode = $unitCode;
        return $this;
    }
}
