<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing CreditorFinancialAccountType
 *
 *
 * XSD Type: CreditorFinancialAccountType
 */
class CreditorFinancialAccountType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\IDType $iBANID
     */
    private $iBANID = null;

    /**
     * @var \horstoeko\zugferd\basic\udt\IDType $proprietaryID
     */
    private $proprietaryID = null;

    /**
     * Gets as iBANID
     *
     * @return \horstoeko\zugferd\basic\udt\IDType
     */
    public function getIBANID()
    {
        return $this->iBANID;
    }

    /**
     * Sets a new iBANID
     *
     * @param \horstoeko\zugferd\basic\udt\IDType $iBANID
     * @return self
     */
    public function setIBANID(\horstoeko\zugferd\basic\udt\IDType $iBANID)
    {
        $this->iBANID = $iBANID;
        return $this;
    }

    /**
     * Gets as proprietaryID
     *
     * @return \horstoeko\zugferd\basic\udt\IDType
     */
    public function getProprietaryID()
    {
        return $this->proprietaryID;
    }

    /**
     * Sets a new proprietaryID
     *
     * @param \horstoeko\zugferd\basic\udt\IDType $proprietaryID
     * @return self
     */
    public function setProprietaryID(\horstoeko\zugferd\basic\udt\IDType $proprietaryID)
    {
        $this->proprietaryID = $proprietaryID;
        return $this;
    }


}

