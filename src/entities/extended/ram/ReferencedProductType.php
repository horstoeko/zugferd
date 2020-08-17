<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing ReferencedProductType
 *
 *
 * XSD Type: ReferencedProductType
 */
class ReferencedProductType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType $globalID
     */
    private $globalID = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType $sellerAssignedID
     */
    private $sellerAssignedID = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType $buyerAssignedID
     */
    private $buyerAssignedID = null;

    /**
     * @var string $name
     */
    private $name = null;

    /**
     * @var string $description
     */
    private $description = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\QuantityType $unitQuantity
     */
    private $unitQuantity = null;

    /**
     * Gets as globalID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType
     */
    public function getGlobalID()
    {
        return $this->globalID;
    }

    /**
     * Sets a new globalID
     *
     * @param \horstoeko\zugferd\entities\extended\udt\IDType $globalID
     * @return self
     */
    public function setGlobalID(\horstoeko\zugferd\entities\extended\udt\IDType $globalID)
    {
        $this->globalID = $globalID;
        return $this;
    }

    /**
     * Gets as sellerAssignedID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType
     */
    public function getSellerAssignedID()
    {
        return $this->sellerAssignedID;
    }

    /**
     * Sets a new sellerAssignedID
     *
     * @param \horstoeko\zugferd\entities\extended\udt\IDType $sellerAssignedID
     * @return self
     */
    public function setSellerAssignedID(\horstoeko\zugferd\entities\extended\udt\IDType $sellerAssignedID)
    {
        $this->sellerAssignedID = $sellerAssignedID;
        return $this;
    }

    /**
     * Gets as buyerAssignedID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType
     */
    public function getBuyerAssignedID()
    {
        return $this->buyerAssignedID;
    }

    /**
     * Sets a new buyerAssignedID
     *
     * @param \horstoeko\zugferd\entities\extended\udt\IDType $buyerAssignedID
     * @return self
     */
    public function setBuyerAssignedID(\horstoeko\zugferd\entities\extended\udt\IDType $buyerAssignedID)
    {
        $this->buyerAssignedID = $buyerAssignedID;
        return $this;
    }

    /**
     * Gets as name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets as description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets a new description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets as unitQuantity
     *
     * @return \horstoeko\zugferd\entities\extended\udt\QuantityType
     */
    public function getUnitQuantity()
    {
        return $this->unitQuantity;
    }

    /**
     * Sets a new unitQuantity
     *
     * @param \horstoeko\zugferd\entities\extended\udt\QuantityType $unitQuantity
     * @return self
     */
    public function setUnitQuantity(\horstoeko\zugferd\entities\extended\udt\QuantityType $unitQuantity)
    {
        $this->unitQuantity = $unitQuantity;
        return $this;
    }


}

