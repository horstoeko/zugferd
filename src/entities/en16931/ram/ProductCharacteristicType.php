<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing ProductCharacteristicType
 *
 * XSD Type: ProductCharacteristicType
 */
class ProductCharacteristicType
{

    /**
     * @var string|null $description
     */
    private $description = null;

    /**
     * @var string|null $value
     */
    private $value = null;

    /**
     * Gets as description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets a new description
     *
     * @param  string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets as value
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets a new value
     *
     * @param  string $value
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
