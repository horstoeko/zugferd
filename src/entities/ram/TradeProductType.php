<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradeProductType
 *
 *
 * XSD Type: TradeProductType
 */
class TradeProductType
{

    /**
     * @property \horstoeko\zugferd\udt\IDType $globalID
     */
    private $globalID = null;

    /**
     * @property \horstoeko\zugferd\udt\IDType $sellerAssignedID
     */
    private $sellerAssignedID = null;

    /**
     * @property \horstoeko\zugferd\udt\IDType $buyerAssignedID
     */
    private $buyerAssignedID = null;

    /**
     * @property string $name
     */
    private $name = null;

    /**
     * @property string $description
     */
    private $description = null;

    /**
     * @property \horstoeko\zugferd\ram\ProductCharacteristicType[]
     * $applicableProductCharacteristic
     */
    private $applicableProductCharacteristic = null;

    /**
     * @property \horstoeko\zugferd\ram\ProductClassificationType[]
     * $designatedProductClassification
     */
    private $designatedProductClassification = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeCountryType $originTradeCountry
     */
    private $originTradeCountry = null;

    /**
     * @property \horstoeko\zugferd\ram\ReferencedProductType[]
     * $includedReferencedProduct
     */
    private $includedReferencedProduct = null;

    /**
     * Gets as globalID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getGlobalID()
    {
        return $this->globalID;
    }

    /**
     * Sets a new globalID
     *
     * @param \horstoeko\zugferd\udt\IDType $globalID
     * @return self
     */
    public function setGlobalID(\horstoeko\zugferd\udt\IDType $globalID)
    {
        $this->globalID = $globalID;
        return $this;
    }

    /**
     * Gets as sellerAssignedID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getSellerAssignedID()
    {
        return $this->sellerAssignedID;
    }

    /**
     * Sets a new sellerAssignedID
     *
     * @param \horstoeko\zugferd\udt\IDType $sellerAssignedID
     * @return self
     */
    public function setSellerAssignedID(\horstoeko\zugferd\udt\IDType $sellerAssignedID)
    {
        $this->sellerAssignedID = $sellerAssignedID;
        return $this;
    }

    /**
     * Gets as buyerAssignedID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getBuyerAssignedID()
    {
        return $this->buyerAssignedID;
    }

    /**
     * Sets a new buyerAssignedID
     *
     * @param \horstoeko\zugferd\udt\IDType $buyerAssignedID
     * @return self
     */
    public function setBuyerAssignedID(\horstoeko\zugferd\udt\IDType $buyerAssignedID)
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
     * Adds as applicableProductCharacteristic
     *
     * @return self
     * @param \horstoeko\zugferd\ram\ProductCharacteristicType
     * $applicableProductCharacteristic
     */
    public function addToApplicableProductCharacteristic(\horstoeko\zugferd\ram\ProductCharacteristicType $applicableProductCharacteristic)
    {
        $this->applicableProductCharacteristic[] = $applicableProductCharacteristic;
        return $this;
    }

    /**
     * isset applicableProductCharacteristic
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetApplicableProductCharacteristic($index)
    {
        return isset($this->applicableProductCharacteristic[$index]);
    }

    /**
     * unset applicableProductCharacteristic
     *
     * @param scalar $index
     * @return void
     */
    public function unsetApplicableProductCharacteristic($index)
    {
        unset($this->applicableProductCharacteristic[$index]);
    }

    /**
     * Gets as applicableProductCharacteristic
     *
     * @return \horstoeko\zugferd\ram\ProductCharacteristicType[]
     */
    public function getApplicableProductCharacteristic()
    {
        return $this->applicableProductCharacteristic;
    }

    /**
     * Sets a new applicableProductCharacteristic
     *
     * @param \horstoeko\zugferd\ram\ProductCharacteristicType[]
     * $applicableProductCharacteristic
     * @return self
     */
    public function setApplicableProductCharacteristic(array $applicableProductCharacteristic)
    {
        $this->applicableProductCharacteristic = $applicableProductCharacteristic;
        return $this;
    }

    /**
     * Adds as designatedProductClassification
     *
     * @return self
     * @param \horstoeko\zugferd\ram\ProductClassificationType
     * $designatedProductClassification
     */
    public function addToDesignatedProductClassification(\horstoeko\zugferd\ram\ProductClassificationType $designatedProductClassification)
    {
        $this->designatedProductClassification[] = $designatedProductClassification;
        return $this;
    }

    /**
     * isset designatedProductClassification
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDesignatedProductClassification($index)
    {
        return isset($this->designatedProductClassification[$index]);
    }

    /**
     * unset designatedProductClassification
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDesignatedProductClassification($index)
    {
        unset($this->designatedProductClassification[$index]);
    }

    /**
     * Gets as designatedProductClassification
     *
     * @return \horstoeko\zugferd\ram\ProductClassificationType[]
     */
    public function getDesignatedProductClassification()
    {
        return $this->designatedProductClassification;
    }

    /**
     * Sets a new designatedProductClassification
     *
     * @param \horstoeko\zugferd\ram\ProductClassificationType[]
     * $designatedProductClassification
     * @return self
     */
    public function setDesignatedProductClassification(array $designatedProductClassification)
    {
        $this->designatedProductClassification = $designatedProductClassification;
        return $this;
    }

    /**
     * Gets as originTradeCountry
     *
     * @return \horstoeko\zugferd\ram\TradeCountryType
     */
    public function getOriginTradeCountry()
    {
        return $this->originTradeCountry;
    }

    /**
     * Sets a new originTradeCountry
     *
     * @param \horstoeko\zugferd\ram\TradeCountryType $originTradeCountry
     * @return self
     */
    public function setOriginTradeCountry(\horstoeko\zugferd\ram\TradeCountryType $originTradeCountry)
    {
        $this->originTradeCountry = $originTradeCountry;
        return $this;
    }

    /**
     * Adds as includedReferencedProduct
     *
     * @return self
     * @param \horstoeko\zugferd\ram\ReferencedProductType $includedReferencedProduct
     */
    public function addToIncludedReferencedProduct(\horstoeko\zugferd\ram\ReferencedProductType $includedReferencedProduct)
    {
        $this->includedReferencedProduct[] = $includedReferencedProduct;
        return $this;
    }

    /**
     * isset includedReferencedProduct
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetIncludedReferencedProduct($index)
    {
        return isset($this->includedReferencedProduct[$index]);
    }

    /**
     * unset includedReferencedProduct
     *
     * @param scalar $index
     * @return void
     */
    public function unsetIncludedReferencedProduct($index)
    {
        unset($this->includedReferencedProduct[$index]);
    }

    /**
     * Gets as includedReferencedProduct
     *
     * @return \horstoeko\zugferd\ram\ReferencedProductType[]
     */
    public function getIncludedReferencedProduct()
    {
        return $this->includedReferencedProduct;
    }

    /**
     * Sets a new includedReferencedProduct
     *
     * @param \horstoeko\zugferd\ram\ReferencedProductType[] $includedReferencedProduct
     * @return self
     */
    public function setIncludedReferencedProduct(array $includedReferencedProduct)
    {
        $this->includedReferencedProduct = $includedReferencedProduct;
        return $this;
    }


}

