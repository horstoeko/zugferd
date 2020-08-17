<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing CreditorFinancialInstitutionType
 *
 *
 * XSD Type: CreditorFinancialInstitutionType
 */
class CreditorFinancialInstitutionType
{

    /**
     * @var \horstoeko\zugferd\udt\IDType $bICID
     */
    private $bICID = null;

    /**
     * Gets as bICID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getBICID()
    {
        return $this->bICID;
    }

    /**
     * Sets a new bICID
     *
     * @param \horstoeko\zugferd\udt\IDType $bICID
     * @return self
     */
    public function setBICID(\horstoeko\zugferd\udt\IDType $bICID)
    {
        $this->bICID = $bICID;
        return $this;
    }


}

