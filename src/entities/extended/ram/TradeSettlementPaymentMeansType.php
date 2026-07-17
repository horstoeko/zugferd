<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeSettlementPaymentMeansType
 *
 * XSD Type: TradeSettlementPaymentMeansType
 */
class TradeSettlementPaymentMeansType
{

    /**
     * @var string|null $typeCode
     */
    private $typeCode = null;

    /**
     * @var string|null $information
     */
    private $information = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType|null $applicableTradeSettlementFinancialCard
     */
    private $applicableTradeSettlementFinancialCard = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType|null $payerPartyDebtorFinancialAccount
     */
    private $payerPartyDebtorFinancialAccount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType|null $payeePartyCreditorFinancialAccount
     */
    private $payeePartyCreditorFinancialAccount = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\DebtorFinancialInstitutionType|null $payerSpecifiedDebtorFinancialInstitution
     */
    private $payerSpecifiedDebtorFinancialInstitution = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType|null $payeeSpecifiedCreditorFinancialInstitution
     */
    private $payeeSpecifiedCreditorFinancialInstitution = null;

    /**
     * Gets as typeCode
     *
     * @return string|null
     */
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * Sets a new typeCode
     *
     * @param  string $typeCode
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
     * @return string|null
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Sets a new information
     *
     * @param  string $information
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
     * @return \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType|null
     */
    public function getApplicableTradeSettlementFinancialCard()
    {
        return $this->applicableTradeSettlementFinancialCard;
    }

    /**
     * Sets a new applicableTradeSettlementFinancialCard
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType|null $applicableTradeSettlementFinancialCard
     * @return self
     */
    public function setApplicableTradeSettlementFinancialCard(?\horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType $applicableTradeSettlementFinancialCard = null)
    {
        $this->applicableTradeSettlementFinancialCard = $applicableTradeSettlementFinancialCard;
        return $this;
    }

    /**
     * Gets as payerPartyDebtorFinancialAccount
     *
     * @return \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType|null
     */
    public function getPayerPartyDebtorFinancialAccount()
    {
        return $this->payerPartyDebtorFinancialAccount;
    }

    /**
     * Sets a new payerPartyDebtorFinancialAccount
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType|null $payerPartyDebtorFinancialAccount
     * @return self
     */
    public function setPayerPartyDebtorFinancialAccount(?\horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType $payerPartyDebtorFinancialAccount = null)
    {
        $this->payerPartyDebtorFinancialAccount = $payerPartyDebtorFinancialAccount;
        return $this;
    }

    /**
     * Gets as payeePartyCreditorFinancialAccount
     *
     * @return \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType|null
     */
    public function getPayeePartyCreditorFinancialAccount()
    {
        return $this->payeePartyCreditorFinancialAccount;
    }

    /**
     * Sets a new payeePartyCreditorFinancialAccount
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType|null $payeePartyCreditorFinancialAccount
     * @return self
     */
    public function setPayeePartyCreditorFinancialAccount(?\horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType $payeePartyCreditorFinancialAccount = null)
    {
        $this->payeePartyCreditorFinancialAccount = $payeePartyCreditorFinancialAccount;
        return $this;
    }

    /**
     * Gets as payerSpecifiedDebtorFinancialInstitution
     *
     * @return \horstoeko\zugferd\entities\extended\ram\DebtorFinancialInstitutionType|null
     */
    public function getPayerSpecifiedDebtorFinancialInstitution()
    {
        return $this->payerSpecifiedDebtorFinancialInstitution;
    }

    /**
     * Sets a new payerSpecifiedDebtorFinancialInstitution
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\DebtorFinancialInstitutionType|null $payerSpecifiedDebtorFinancialInstitution
     * @return self
     */
    public function setPayerSpecifiedDebtorFinancialInstitution(?\horstoeko\zugferd\entities\extended\ram\DebtorFinancialInstitutionType $payerSpecifiedDebtorFinancialInstitution = null)
    {
        $this->payerSpecifiedDebtorFinancialInstitution = $payerSpecifiedDebtorFinancialInstitution;
        return $this;
    }

    /**
     * Gets as payeeSpecifiedCreditorFinancialInstitution
     *
     * @return \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType|null
     */
    public function getPayeeSpecifiedCreditorFinancialInstitution()
    {
        return $this->payeeSpecifiedCreditorFinancialInstitution;
    }

    /**
     * Sets a new payeeSpecifiedCreditorFinancialInstitution
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType|null $payeeSpecifiedCreditorFinancialInstitution
     * @return self
     */
    public function setPayeeSpecifiedCreditorFinancialInstitution(?\horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType $payeeSpecifiedCreditorFinancialInstitution = null)
    {
        $this->payeeSpecifiedCreditorFinancialInstitution = $payeeSpecifiedCreditorFinancialInstitution;
        return $this;
    }
}
