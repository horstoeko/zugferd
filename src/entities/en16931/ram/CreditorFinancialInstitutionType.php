<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing CreditorFinancialInstitutionType
 *
 * XSD Type: CreditorFinancialInstitutionType
 */
class CreditorFinancialInstitutionType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType $bICID
     */
    private $bICID = null;

    /**
     * Gets as bICID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType
     */
    public function getBICID()
    {
        return $this->bICID;
    }

    /**
     * Sets a new bICID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType $bICID
     * @return self
     */
    public function setBICID(\horstoeko\zugferd\entities\en16931\udt\IDType $bICID)
    {
        $this->bICID = $bICID;
        return $this;
    }
}
