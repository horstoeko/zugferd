<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing DebtorFinancialAccountType
 *
 * XSD Type: DebtorFinancialAccountType
 */
class DebtorFinancialAccountType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType $iBANID
     */
    private $iBANID = null;

    /**
     * Gets as iBANID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType
     */
    public function getIBANID()
    {
        return $this->iBANID;
    }

    /**
     * Sets a new iBANID
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType $iBANID
     * @return self
     */
    public function setIBANID(\horstoeko\zugferd\entities\extended\udt\IDType $iBANID)
    {
        $this->iBANID = $iBANID;
        return $this;
    }
}
