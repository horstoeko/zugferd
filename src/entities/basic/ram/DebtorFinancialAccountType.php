<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing DebtorFinancialAccountType
 *
 *
 * XSD Type: DebtorFinancialAccountType
 */
class DebtorFinancialAccountType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\IDType $iBANID
     */
    private $iBANID = null;

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


}

