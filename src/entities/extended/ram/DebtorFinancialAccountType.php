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
     * @var \horstoeko\zugferd\entities\extended\udt\IDType|null $iBANID
     */
    private $iBANID = null;

    /**
     * @var string|null $accountName
     */
    private $accountName = null;

    /**
     * Gets as iBANID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType|null
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

    /**
     * Gets as accountName
     *
     * @return string|null
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * Sets a new accountName
     *
     * @param  string $accountName
     * @return self
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;
        return $this;
    }
}
