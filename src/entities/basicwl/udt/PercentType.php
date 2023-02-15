<?php

namespace horstoeko\zugferd\entities\basicwl\udt;

/**
 * Class representing PercentType
 *
 * XSD Type: PercentType
 */
class PercentType
{

    /**
     * @var float $__value
     */
    private $__value = null;

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
}
