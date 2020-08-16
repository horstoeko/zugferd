<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing DebtorFinancialAccountType
 *
 *
 * XSD Type: DebtorFinancialAccountType
 */
class DebtorFinancialAccountType
{

    /**
     * @property \horstoeko\zugferd\udt\IDType $iBANID
     */
    private $iBANID = null;

    /**
     * Gets as iBANID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getIBANID()
    {
        return $this->iBANID;
    }

    /**
     * Sets a new iBANID
     *
     * @param \horstoeko\zugferd\udt\IDType $iBANID
     * @return self
     */
    public function setIBANID(\horstoeko\zugferd\udt\IDType $iBANID)
    {
        $this->iBANID = $iBANID;
        return $this;
    }


}

