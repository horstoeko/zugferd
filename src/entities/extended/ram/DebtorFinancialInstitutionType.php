<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing DebtorFinancialInstitutionType
 *
 * XSD Type: DebtorFinancialInstitutionType
 */
class DebtorFinancialInstitutionType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType $bICID
     */
    private $bICID = null;

    /**
     * Gets as bICID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType
     */
    public function getBICID()
    {
        return $this->bICID;
    }

    /**
     * Sets a new bICID
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType $bICID
     * @return self
     */
    public function setBICID(?\horstoeko\zugferd\entities\extended\udt\IDType $bICID = null)
    {
        $this->bICID = $bICID;
        return $this;
    }
}
