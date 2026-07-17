<?php

namespace horstoeko\zugferd\entities\basicwl\ram;

/**
 * Class representing TradePartyType
 *
 * XSD Type: TradePartyType
 */
class TradePartyType
{

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\IDType[] $iD
     */
    private $iD = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\IDType[] $globalID
     */
    private $globalID = [
        
    ];

    /**
     * @var string|null $name
     */
    private $name = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\ram\LegalOrganizationType|null $specifiedLegalOrganization
     */
    private $specifiedLegalOrganization = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\ram\TradeAddressType|null $postalTradeAddress
     */
    private $postalTradeAddress = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\ram\UniversalCommunicationType|null $uRIUniversalCommunication
     */
    private $uRIUniversalCommunication = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\ram\TaxRegistrationType[] $specifiedTaxRegistration
     */
    private $specifiedTaxRegistration = [
        
    ];

    /**
     * Adds as iD
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IDType $iD
     */
    public function addToID(\horstoeko\zugferd\entities\basicwl\udt\IDType $iD)
    {
        $this->iD[] = $iD;
        return $this;
    }

    /**
     * isset iD
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetID($index)
    {
        return isset($this->iD[$index]);
    }

    /**
     * unset iD
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetID($index)
    {
        unset($this->iD[$index]);
    }

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\IDType[]
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IDType[]|null $iD
     * @return self
     */
    public function setID(?array $iD = null)
    {
        $this->iD = $iD;
        return $this;
    }

    /**
     * Adds as globalID
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IDType $globalID
     */
    public function addToGlobalID(\horstoeko\zugferd\entities\basicwl\udt\IDType $globalID)
    {
        $this->globalID[] = $globalID;
        return $this;
    }

    /**
     * isset globalID
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetGlobalID($index)
    {
        return isset($this->globalID[$index]);
    }

    /**
     * unset globalID
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetGlobalID($index)
    {
        unset($this->globalID[$index]);
    }

    /**
     * Gets as globalID
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\IDType[]
     */
    public function getGlobalID()
    {
        return $this->globalID;
    }

    /**
     * Sets a new globalID
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IDType[]|null $globalID
     * @return self
     */
    public function setGlobalID(?array $globalID = null)
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

    /**
     * Gets as specifiedLegalOrganization
     *
     * @return \horstoeko\zugferd\entities\basicwl\ram\LegalOrganizationType|null
     */
    public function getSpecifiedLegalOrganization()
    {
        return $this->specifiedLegalOrganization;
    }

    /**
     * Sets a new specifiedLegalOrganization
     *
     * @param  \horstoeko\zugferd\entities\basicwl\ram\LegalOrganizationType|null $specifiedLegalOrganization
     * @return self
     */
    public function setSpecifiedLegalOrganization(?\horstoeko\zugferd\entities\basicwl\ram\LegalOrganizationType $specifiedLegalOrganization = null)
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;
        return $this;
    }

    /**
     * Gets as postalTradeAddress
     *
     * @return \horstoeko\zugferd\entities\basicwl\ram\TradeAddressType|null
     */
    public function getPostalTradeAddress()
    {
        return $this->postalTradeAddress;
    }

    /**
     * Sets a new postalTradeAddress
     *
     * @param  \horstoeko\zugferd\entities\basicwl\ram\TradeAddressType|null $postalTradeAddress
     * @return self
     */
    public function setPostalTradeAddress(?\horstoeko\zugferd\entities\basicwl\ram\TradeAddressType $postalTradeAddress = null)
    {
        $this->postalTradeAddress = $postalTradeAddress;
        return $this;
    }

    /**
     * Gets as uRIUniversalCommunication
     *
     * @return \horstoeko\zugferd\entities\basicwl\ram\UniversalCommunicationType|null
     */
    public function getURIUniversalCommunication()
    {
        return $this->uRIUniversalCommunication;
    }

    /**
     * Sets a new uRIUniversalCommunication
     *
     * @param  \horstoeko\zugferd\entities\basicwl\ram\UniversalCommunicationType|null $uRIUniversalCommunication
     * @return self
     */
    public function setURIUniversalCommunication(?\horstoeko\zugferd\entities\basicwl\ram\UniversalCommunicationType $uRIUniversalCommunication = null)
    {
        $this->uRIUniversalCommunication = $uRIUniversalCommunication;
        return $this;
    }

    /**
     * Adds as specifiedTaxRegistration
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\basicwl\ram\TaxRegistrationType $specifiedTaxRegistration
     */
    public function addToSpecifiedTaxRegistration(\horstoeko\zugferd\entities\basicwl\ram\TaxRegistrationType $specifiedTaxRegistration)
    {
        $this->specifiedTaxRegistration[] = $specifiedTaxRegistration;
        return $this;
    }

    /**
     * isset specifiedTaxRegistration
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetSpecifiedTaxRegistration($index)
    {
        return isset($this->specifiedTaxRegistration[$index]);
    }

    /**
     * unset specifiedTaxRegistration
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetSpecifiedTaxRegistration($index)
    {
        unset($this->specifiedTaxRegistration[$index]);
    }

    /**
     * Gets as specifiedTaxRegistration
     *
     * @return \horstoeko\zugferd\entities\basicwl\ram\TaxRegistrationType[]
     */
    public function getSpecifiedTaxRegistration()
    {
        return $this->specifiedTaxRegistration;
    }

    /**
     * Sets a new specifiedTaxRegistration
     *
     * @param  \horstoeko\zugferd\entities\basicwl\ram\TaxRegistrationType[]|null $specifiedTaxRegistration
     * @return self
     */
    public function setSpecifiedTaxRegistration(?array $specifiedTaxRegistration = null)
    {
        $this->specifiedTaxRegistration = $specifiedTaxRegistration;
        return $this;
    }
}
