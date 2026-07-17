<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing TradeProductType
 *
 * XSD Type: TradeProductType
 */
class TradeProductType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType|null $globalID
     */
    private $globalID = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType|null $sellerAssignedID
     */
    private $sellerAssignedID = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType|null $buyerAssignedID
     */
    private $buyerAssignedID = null;

    /**
     * @var string|null $name
     */
    private $name = null;

    /**
     * @var string|null $description
     */
    private $description = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\ProductCharacteristicType[] $applicableProductCharacteristic
     */
    private $applicableProductCharacteristic = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\ProductClassificationType[] $designatedProductClassification
     */
    private $designatedProductClassification = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\TradeCountryType|null $originTradeCountry
     */
    private $originTradeCountry = null;

    /**
     * Gets as globalID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType|null
     */
    public function getGlobalID()
    {
        return $this->globalID;
    }

    /**
     * Sets a new globalID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType|null $globalID
     * @return self
     */
    public function setGlobalID(?\horstoeko\zugferd\entities\en16931\udt\IDType $globalID = null)
    {
        $this->globalID = $globalID;
        return $this;
    }

    /**
     * Gets as sellerAssignedID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType|null
     */
    public function getSellerAssignedID()
    {
        return $this->sellerAssignedID;
    }

    /**
     * Sets a new sellerAssignedID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType|null $sellerAssignedID
     * @return self
     */
    public function setSellerAssignedID(?\horstoeko\zugferd\entities\en16931\udt\IDType $sellerAssignedID = null)
    {
        $this->sellerAssignedID = $sellerAssignedID;
        return $this;
    }

    /**
     * Gets as buyerAssignedID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType|null
     */
    public function getBuyerAssignedID()
    {
        return $this->buyerAssignedID;
    }

    /**
     * Sets a new buyerAssignedID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType|null $buyerAssignedID
     * @return self
     */
    public function setBuyerAssignedID(?\horstoeko\zugferd\entities\en16931\udt\IDType $buyerAssignedID = null)
    {
        $this->buyerAssignedID = $buyerAssignedID;
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
     * Adds as applicableProductCharacteristic
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\en16931\ram\ProductCharacteristicType $applicableProductCharacteristic
     */
    public function addToApplicableProductCharacteristic(\horstoeko\zugferd\entities\en16931\ram\ProductCharacteristicType $applicableProductCharacteristic)
    {
        $this->applicableProductCharacteristic[] = $applicableProductCharacteristic;
        return $this;
    }

    /**
     * isset applicableProductCharacteristic
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetApplicableProductCharacteristic($index)
    {
        return isset($this->applicableProductCharacteristic[$index]);
    }

    /**
     * unset applicableProductCharacteristic
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetApplicableProductCharacteristic($index)
    {
        unset($this->applicableProductCharacteristic[$index]);
    }

    /**
     * Gets as applicableProductCharacteristic
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\ProductCharacteristicType[]
     */
    public function getApplicableProductCharacteristic()
    {
        return $this->applicableProductCharacteristic;
    }

    /**
     * Sets a new applicableProductCharacteristic
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\ProductCharacteristicType[]|null $applicableProductCharacteristic
     * @return self
     */
    public function setApplicableProductCharacteristic(?array $applicableProductCharacteristic = null)
    {
        $this->applicableProductCharacteristic = $applicableProductCharacteristic;
        return $this;
    }

    /**
     * Adds as designatedProductClassification
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\en16931\ram\ProductClassificationType $designatedProductClassification
     */
    public function addToDesignatedProductClassification(\horstoeko\zugferd\entities\en16931\ram\ProductClassificationType $designatedProductClassification)
    {
        $this->designatedProductClassification[] = $designatedProductClassification;
        return $this;
    }

    /**
     * isset designatedProductClassification
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetDesignatedProductClassification($index)
    {
        return isset($this->designatedProductClassification[$index]);
    }

    /**
     * unset designatedProductClassification
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetDesignatedProductClassification($index)
    {
        unset($this->designatedProductClassification[$index]);
    }

    /**
     * Gets as designatedProductClassification
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\ProductClassificationType[]
     */
    public function getDesignatedProductClassification()
    {
        return $this->designatedProductClassification;
    }

    /**
     * Sets a new designatedProductClassification
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\ProductClassificationType[]|null $designatedProductClassification
     * @return self
     */
    public function setDesignatedProductClassification(?array $designatedProductClassification = null)
    {
        $this->designatedProductClassification = $designatedProductClassification;
        return $this;
    }

    /**
     * Gets as originTradeCountry
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\TradeCountryType|null
     */
    public function getOriginTradeCountry()
    {
        return $this->originTradeCountry;
    }

    /**
     * Sets a new originTradeCountry
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\TradeCountryType|null $originTradeCountry
     * @return self
     */
    public function setOriginTradeCountry(?\horstoeko\zugferd\entities\en16931\ram\TradeCountryType $originTradeCountry = null)
    {
        $this->originTradeCountry = $originTradeCountry;
        return $this;
    }
}
