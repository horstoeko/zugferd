<?php

namespace horstoeko\zugferd\entities\minimum\ram;

/**
 * Class representing TradePartyType
 *
 * XSD Type: TradePartyType
 */
class TradePartyType
{

    /**
     * @var string|null $name
     */
    private $name = null;

    /**
     * @var \horstoeko\zugferd\entities\minimum\ram\LegalOrganizationType|null $specifiedLegalOrganization
     */
    private $specifiedLegalOrganization = null;

    /**
     * @var \horstoeko\zugferd\entities\minimum\ram\TradeAddressType|null $postalTradeAddress
     */
    private $postalTradeAddress = null;

    /**
     * @var \horstoeko\zugferd\entities\minimum\ram\TaxRegistrationType[] $specifiedTaxRegistration
     */
    private $specifiedTaxRegistration = [
        
    ];

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
     * @return \horstoeko\zugferd\entities\minimum\ram\LegalOrganizationType|null
     */
    public function getSpecifiedLegalOrganization()
    {
        return $this->specifiedLegalOrganization;
    }

    /**
     * Sets a new specifiedLegalOrganization
     *
     * @param  \horstoeko\zugferd\entities\minimum\ram\LegalOrganizationType|null $specifiedLegalOrganization
     * @return self
     */
    public function setSpecifiedLegalOrganization(?\horstoeko\zugferd\entities\minimum\ram\LegalOrganizationType $specifiedLegalOrganization = null)
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;
        return $this;
    }

    /**
     * Gets as postalTradeAddress
     *
     * @return \horstoeko\zugferd\entities\minimum\ram\TradeAddressType|null
     */
    public function getPostalTradeAddress()
    {
        return $this->postalTradeAddress;
    }

    /**
     * Sets a new postalTradeAddress
     *
     * @param  \horstoeko\zugferd\entities\minimum\ram\TradeAddressType|null $postalTradeAddress
     * @return self
     */
    public function setPostalTradeAddress(?\horstoeko\zugferd\entities\minimum\ram\TradeAddressType $postalTradeAddress = null)
    {
        $this->postalTradeAddress = $postalTradeAddress;
        return $this;
    }

    /**
     * Adds as specifiedTaxRegistration
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\minimum\ram\TaxRegistrationType $specifiedTaxRegistration
     */
    public function addToSpecifiedTaxRegistration(\horstoeko\zugferd\entities\minimum\ram\TaxRegistrationType $specifiedTaxRegistration)
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
     * @return \horstoeko\zugferd\entities\minimum\ram\TaxRegistrationType[]
     */
    public function getSpecifiedTaxRegistration()
    {
        return $this->specifiedTaxRegistration;
    }

    /**
     * Sets a new specifiedTaxRegistration
     *
     * @param  \horstoeko\zugferd\entities\minimum\ram\TaxRegistrationType[]|null $specifiedTaxRegistration
     * @return self
     */
    public function setSpecifiedTaxRegistration(?array $specifiedTaxRegistration = null)
    {
        $this->specifiedTaxRegistration = $specifiedTaxRegistration;
        return $this;
    }
}
