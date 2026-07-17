<?php

namespace horstoeko\zugferd\entities\extended\qdt;

/**
 * Class representing AllowanceChargeReasonCodeType
 *
 * XSD Type: AllowanceChargeReasonCodeType
 */
class AllowanceChargeReasonCodeType
{

    /**
     * @var string|null $__value
     */
    private $__value = null;

    /**
     * @var string|null $listID
     */
    private $listID = null;

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
     * Gets as listID
     *
     * @return string|null
     */
    public function getListID()
    {
        return $this->listID;
    }

    /**
     * Sets a new listID
     *
     * @param  string $listID
     * @return self
     */
    public function setListID($listID)
    {
        $this->listID = $listID;
        return $this;
    }
}
