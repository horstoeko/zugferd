<?php

namespace horstoeko\zugferd\entities\basic\ram;

/**
 * Class representing TradeProductType
 *
 * XSD Type: TradeProductType
 */
class TradeProductType
{

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\IDType|null $globalID
     */
    private $globalID = null;

    /**
     * @var string|null $name
     */
    private $name = null;

    /**
     * Gets as globalID
     *
     * @return \horstoeko\zugferd\entities\basic\udt\IDType|null
     */
    public function getGlobalID()
    {
        return $this->globalID;
    }

    /**
     * Sets a new globalID
     *
     * @param  \horstoeko\zugferd\entities\basic\udt\IDType|null $globalID
     * @return self
     */
    public function setGlobalID(?\horstoeko\zugferd\entities\basic\udt\IDType $globalID = null)
    {
        $this->globalID = $globalID;
        return $this;
    }

    /**
     * Gets as name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param  string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
