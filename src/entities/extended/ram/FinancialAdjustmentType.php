<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing FinancialAdjustmentType
 *
 * XSD Type: FinancialAdjustmentType
 */
class FinancialAdjustmentType
{

    /**
     * @var string|null $reason
     */
    private $reason = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\AmountType|null $actualAmount
     */
    private $actualAmount = null;

    /**
     * Gets as reason
     *
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Sets a new reason
     *
     * @param  string $reason
     * @return self
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * Gets as actualAmount
     *
     * @return \horstoeko\zugferd\entities\extended\udt\AmountType|null
     */
    public function getActualAmount()
    {
        return $this->actualAmount;
    }

    /**
     * Sets a new actualAmount
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\AmountType $actualAmount
     * @return self
     */
    public function setActualAmount(\horstoeko\zugferd\entities\extended\udt\AmountType $actualAmount)
    {
        $this->actualAmount = $actualAmount;
        return $this;
    }
}
