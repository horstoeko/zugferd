<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing DebtorFinancialAccountType
 *
 *
 * XSD Type: DebtorFinancialAccountType
 */
class DebtorFinancialAccountType
{

    /**
     * @var \horstoeko\zugferd\basicwl\udt\IDType $iBANID
     */
    private $iBANID = null;

    /**
     * Gets as iBANID
     *
     * @return \horstoeko\zugferd\basicwl\udt\IDType
     */
    public function getIBANID()
    {
        return $this->iBANID;
    }

    /**
     * Sets a new iBANID
     *
     * @param \horstoeko\zugferd\basicwl\udt\IDType $iBANID
     * @return self
     */
    public function setIBANID(\horstoeko\zugferd\basicwl\udt\IDType $iBANID)
    {
        $this->iBANID = $iBANID;
        return $this;
    }


}

