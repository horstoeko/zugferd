<?php

namespace horstoeko\zugferd\entities\extended\udt;

/**
 * Class representing CodeType
 *
 * XSD Type: CodeType
 */
class CodeType
{

    /**
     * @var string $__value
     */
    private $__value = null;

    /**
     * @var string $listID
     */
    private $listID = null;

    /**
     * @var string $listVersionID
     */
    private $listVersionID = null;

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
     * @return string
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
     * @return string
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

    /**
     * Gets as listVersionID
     *
     * @return string
     */
    public function getListVersionID()
    {
        return $this->listVersionID;
    }

    /**
     * Sets a new listVersionID
     *
     * @param  string $listVersionID
     * @return self
     */
    public function setListVersionID($listVersionID)
    {
        $this->listVersionID = $listVersionID;
        return $this;
    }
}
