<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeProductInstanceType
 *
 * XSD Type: TradeProductInstanceType
 */
class TradeProductInstanceType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType|null $batchID
     */
    private $batchID = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType|null $supplierAssignedSerialID
     */
    private $supplierAssignedSerialID = null;

    /**
     * Gets as batchID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType|null
     */
    public function getBatchID()
    {
        return $this->batchID;
    }

    /**
     * Sets a new batchID
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType|null $batchID
     * @return self
     */
    public function setBatchID(?\horstoeko\zugferd\entities\extended\udt\IDType $batchID = null)
    {
        $this->batchID = $batchID;
        return $this;
    }

    /**
     * Gets as supplierAssignedSerialID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType|null
     */
    public function getSupplierAssignedSerialID()
    {
        return $this->supplierAssignedSerialID;
    }

    /**
     * Sets a new supplierAssignedSerialID
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType|null $supplierAssignedSerialID
     * @return self
     */
    public function setSupplierAssignedSerialID(?\horstoeko\zugferd\entities\extended\udt\IDType $supplierAssignedSerialID = null)
    {
        $this->supplierAssignedSerialID = $supplierAssignedSerialID;
        return $this;
    }
}
