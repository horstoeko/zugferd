<?php

namespace horstoeko\zugferd\entities\basicwl\udt;

/**
 * Class representing IDType
 *
 * XSD Type: IDType
 */
class IDType
{

    /**
     * @var string|null $__value
     */
    private $__value = null;

    /**
     * @var string|null $schemeID
     */
    private $schemeID = null;

    /**
     * Construct
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value($value);
    }

    /**
     * Gets or sets the inner value
     *
     * @param  string $value
     * @return string|null
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
     * Gets as schemeID
     *
     * @return string|null
     */
    public function getSchemeID()
    {
        return $this->schemeID;
    }

    /**
     * Sets a new schemeID
     *
     * @param  string $schemeID
     * @return self
     */
    public function setSchemeID($schemeID)
    {
        $this->schemeID = $schemeID;
        return $this;
    }
}
