<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradeSettlementPaymentMeansType
 *
 *
 * XSD Type: TradeSettlementPaymentMeansType
 */
class TradeSettlementPaymentMeansType
{

    /**
     * @property string $typeCode
     */
    private $typeCode = null;

    /**
     * @property string $information
     */
    private $information = null;

    /**
     * @property \horstoeko\zugferd\ram\TradeSettlementFinancialCardType
     * $applicableTradeSettlementFinancialCard
     */
    private $applicableTradeSettlementFinancialCard = null;

    /**
     * @property \horstoeko\zugferd\ram\DebtorFinancialAccountType
     * $payerPartyDebtorFinancialAccount
     */
    private $payerPartyDebtorFinancialAccount = null;

    /**
     * @property \horstoeko\zugferd\ram\CreditorFinancialAccountType
     * $payeePartyCreditorFinancialAccount
     */
    private $payeePartyCreditorFinancialAccount = null;

    /**
     * @property \horstoeko\zugferd\ram\CreditorFinancialInstitutionType
     * $payeeSpecifiedCreditorFinancialInstitution
     */
    private $payeeSpecifiedCreditorFinancialInstitution = null;

    /**
     * Gets as typeCode
     *
     * @return string
     */
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * Sets a new typeCode
     *
     * @param string $typeCode
     * @return self
     */
    public function setTypeCode($typeCode)
    {
        $this->typeCode = $typeCode;
        return $this;
    }

    /**
     * Gets as information
     *
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Sets a new information
     *
     * @param string $information
     * @return self
     */
    public function setInformation($information)
    {
        $this->information = $information;
        return $this;
    }

    /**
     * Gets as applicableTradeSettlementFinancialCard
     *
     * @return \horstoeko\zugferd\ram\TradeSettlementFinancialCardType
     */
    public function getApplicableTradeSettlementFinancialCard()
    {
        return $this->applicableTradeSettlementFinancialCard;
    }

    /**
     * Sets a new applicableTradeSettlementFinancialCard
     *
     * @param \horstoeko\zugferd\ram\TradeSettlementFinancialCardType
     * $applicableTradeSettlementFinancialCard
     * @return self
     */
    public function setApplicableTradeSettlementFinancialCard(\horstoeko\zugferd\ram\TradeSettlementFinancialCardType $applicableTradeSettlementFinancialCard)
    {
        $this->applicableTradeSettlementFinancialCard = $applicableTradeSettlementFinancialCard;
        return $this;
    }

    /**
     * Gets as payerPartyDebtorFinancialAccount
     *
     * @return \horstoeko\zugferd\ram\DebtorFinancialAccountType
     */
    public function getPayerPartyDebtorFinancialAccount()
    {
        return $this->payerPartyDebtorFinancialAccount;
    }

    /**
     * Sets a new payerPartyDebtorFinancialAccount
     *
     * @param \horstoeko\zugferd\ram\DebtorFinancialAccountType
     * $payerPartyDebtorFinancialAccount
     * @return self
     */
    public function setPayerPartyDebtorFinancialAccount(\horstoeko\zugferd\ram\DebtorFinancialAccountType $payerPartyDebtorFinancialAccount)
    {
        $this->payerPartyDebtorFinancialAccount = $payerPartyDebtorFinancialAccount;
        return $this;
    }

    /**
     * Gets as payeePartyCreditorFinancialAccount
     *
     * @return \horstoeko\zugferd\ram\CreditorFinancialAccountType
     */
    public function getPayeePartyCreditorFinancialAccount()
    {
        return $this->payeePartyCreditorFinancialAccount;
    }

    /**
     * Sets a new payeePartyCreditorFinancialAccount
     *
     * @param \horstoeko\zugferd\ram\CreditorFinancialAccountType
     * $payeePartyCreditorFinancialAccount
     * @return self
     */
    public function setPayeePartyCreditorFinancialAccount(\horstoeko\zugferd\ram\CreditorFinancialAccountType $payeePartyCreditorFinancialAccount)
    {
        $this->payeePartyCreditorFinancialAccount = $payeePartyCreditorFinancialAccount;
        return $this;
    }

    /**
     * Gets as payeeSpecifiedCreditorFinancialInstitution
     *
     * @return \horstoeko\zugferd\ram\CreditorFinancialInstitutionType
     */
    public function getPayeeSpecifiedCreditorFinancialInstitution()
    {
        return $this->payeeSpecifiedCreditorFinancialInstitution;
    }

    /**
     * Sets a new payeeSpecifiedCreditorFinancialInstitution
     *
     * @param \horstoeko\zugferd\ram\CreditorFinancialInstitutionType
     * $payeeSpecifiedCreditorFinancialInstitution
     * @return self
     */
    public function setPayeeSpecifiedCreditorFinancialInstitution(\horstoeko\zugferd\ram\CreditorFinancialInstitutionType $payeeSpecifiedCreditorFinancialInstitution)
    {
        $this->payeeSpecifiedCreditorFinancialInstitution = $payeeSpecifiedCreditorFinancialInstitution;
        return $this;
    }


}

