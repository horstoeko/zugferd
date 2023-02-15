<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing DebtorFinancialAccountType
 *
 * XSD Type: DebtorFinancialAccountType
 */
class DebtorFinancialAccountType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType $iBANID
     */
    private $iBANID = null;

    /**
     * Gets as iBANID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType
     */
    public function getIBANID()
    {
        return $this->iBANID;
    }

    /**
     * Sets a new iBANID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType $iBANID
     * @return self
     */
    public function setIBANID(\horstoeko\zugferd\entities\en16931\udt\IDType $iBANID)
    {
        $this->iBANID = $iBANID;
        return $this;
    }
}
