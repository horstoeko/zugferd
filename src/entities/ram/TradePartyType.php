<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradePartyType
 *
 *
 * XSD Type: TradePartyType
 */
class TradePartyType
{

    /**
     * @property \horstoeko\zugferd\udt\IDType[] $iD
     */
    private $iD = null;

    /**
     * @property \horstoeko\zugferd\udt\IDType[] $globalID
     */
    private $globalID = null;

    /**
     * @property string $name
     */
    private $name = null;

    /**
     * @property string $description
     */
    private $description = null;

    /**
     * @property \horstoeko\zugferd\ram\LegalOrganizationType
     * $specifiedLegalOrganization
     */
    private $specifiedLegalOrganization = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeContactType $definedTradeContact
     */
    private $definedTradeContact = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeAddressType $postalTradeAddress
     */
    private $postalTradeAddress = null;

    /**
     * @property \horstoeko\zugferd\ram\UniversalCommunicationType
     * $uRIUniversalCommunication
     */
    private $uRIUniversalCommunication = null;

    /**
     * @property \horstoeko\zugferd\ram\TaxRegistrationType[] $specifiedTaxRegistration
     */
    private $specifiedTaxRegistration = null;

    /**
     * Adds as iD
     *
     * @return self
     * @param \horstoeko\zugferd\udt\IDType $iD
     */
    public function addToID(\horstoeko\zugferd\udt\IDType $iD)
    {
        $this->iD[] = $iD;
        return $this;
    }

    /**
     * isset iD
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetID($index)
    {
        return isset($this->iD[$index]);
    }

    /**
     * unset iD
     *
     * @param scalar $index
     * @return void
     */
    public function unsetID($index)
    {
        unset($this->iD[$index]);
    }

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\udt\IDType[]
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param \horstoeko\zugferd\udt\IDType[] $iD
     * @return self
     */
    public function setID(array $iD)
    {
        $this->iD = $iD;
        return $this;
    }

    /**
     * Adds as globalID
     *
     * @return self
     * @param \horstoeko\zugferd\udt\IDType $globalID
     */
    public function addToGlobalID(\horstoeko\zugferd\udt\IDType $globalID)
    {
        $this->globalID[] = $globalID;
        return $this;
    }

    /**
     * isset globalID
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetGlobalID($index)
    {
        return isset($this->globalID[$index]);
    }

    /**
     * unset globalID
     *
     * @param scalar $index
     * @return void
     */
    public function unsetGlobalID($index)
    {
        unset($this->globalID[$index]);
    }

    /**
     * Gets as globalID
     *
     * @return \horstoeko\zugferd\udt\IDType[]
     */
    public function getGlobalID()
    {
        return $this->globalID;
    }

    /**
     * Sets a new globalID
     *
     * @param \horstoeko\zugferd\udt\IDType[] $globalID
     * @return self
     */
    public function setGlobalID(array $globalID)
    {
        $this->globalID = $globalID;
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
     * Gets as specifiedLegalOrganization
     *
     * @return \horstoeko\zugferd\ram\LegalOrganizationType
     */
    public function getSpecifiedLegalOrganization()
    {
        return $this->specifiedLegalOrganization;
    }

    /**
     * Sets a new specifiedLegalOrganization
     *
     * @param \horstoeko\zugferd\ram\LegalOrganizationType $specifiedLegalOrganization
     * @return self
     */
    public function setSpecifiedLegalOrganization(\horstoeko\zugferd\ram\LegalOrganizationType $specifiedLegalOrganization)
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;
        return $this;
    }

    /**
     * Gets as definedTradeContact
     *
     * @return \horstoeko\zugferd\ram\TradeContactType
     */
    public function getDefinedTradeContact()
    {
        return $this->definedTradeContact;
    }

    /**
     * Sets a new definedTradeContact
     *
     * @param \horstoeko\zugferd\ram\TradeContactType $definedTradeContact
     * @return self
     */
    public function setDefinedTradeContact(\horstoeko\zugferd\ram\TradeContactType $definedTradeContact)
    {
        $this->definedTradeContact = $definedTradeContact;
        return $this;
    }

    /**
     * Gets as postalTradeAddress
     *
     * @return \horstoeko\zugferd\ram\TradeAddressType
     */
    public function getPostalTradeAddress()
    {
        return $this->postalTradeAddress;
    }

    /**
     * Sets a new postalTradeAddress
     *
     * @param \horstoeko\zugferd\ram\TradeAddressType $postalTradeAddress
     * @return self
     */
    public function setPostalTradeAddress(\horstoeko\zugferd\ram\TradeAddressType $postalTradeAddress)
    {
        $this->postalTradeAddress = $postalTradeAddress;
        return $this;
    }

    /**
     * Gets as uRIUniversalCommunication
     *
     * @return \horstoeko\zugferd\ram\UniversalCommunicationType
     */
    public function getURIUniversalCommunication()
    {
        return $this->uRIUniversalCommunication;
    }

    /**
     * Sets a new uRIUniversalCommunication
     *
     * @param \horstoeko\zugferd\ram\UniversalCommunicationType
     * $uRIUniversalCommunication
     * @return self
     */
    public function setURIUniversalCommunication(\horstoeko\zugferd\ram\UniversalCommunicationType $uRIUniversalCommunication)
    {
        $this->uRIUniversalCommunication = $uRIUniversalCommunication;
        return $this;
    }

    /**
     * Adds as specifiedTaxRegistration
     *
     * @return self
     * @param \horstoeko\zugferd\ram\TaxRegistrationType $specifiedTaxRegistration
     */
    public function addToSpecifiedTaxRegistration(\horstoeko\zugferd\ram\TaxRegistrationType $specifiedTaxRegistration)
    {
        $this->specifiedTaxRegistration[] = $specifiedTaxRegistration;
        return $this;
    }

    /**
     * isset specifiedTaxRegistration
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSpecifiedTaxRegistration($index)
    {
        return isset($this->specifiedTaxRegistration[$index]);
    }

    /**
     * unset specifiedTaxRegistration
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSpecifiedTaxRegistration($index)
    {
        unset($this->specifiedTaxRegistration[$index]);
    }

    /**
     * Gets as specifiedTaxRegistration
     *
     * @return \horstoeko\zugferd\ram\TaxRegistrationType[]
     */
    public function getSpecifiedTaxRegistration()
    {
        return $this->specifiedTaxRegistration;
    }

    /**
     * Sets a new specifiedTaxRegistration
     *
     * @param \horstoeko\zugferd\ram\TaxRegistrationType[] $specifiedTaxRegistration
     * @return self
     */
    public function setSpecifiedTaxRegistration(array $specifiedTaxRegistration)
    {
        $this->specifiedTaxRegistration = $specifiedTaxRegistration;
        return $this;
    }


}

