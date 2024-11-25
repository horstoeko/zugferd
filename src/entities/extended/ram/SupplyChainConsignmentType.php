<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing SupplyChainConsignmentType
 *
 * XSD Type: SupplyChainConsignmentType
 */
class SupplyChainConsignmentType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType[] $specifiedLogisticsTransportMovement
     */
    private $specifiedLogisticsTransportMovement = [
        
    ];

    /**
     * Adds as specifiedLogisticsTransportMovement
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType $specifiedLogisticsTransportMovement
     */
    public function addToSpecifiedLogisticsTransportMovement(\horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType $specifiedLogisticsTransportMovement)
    {
        $this->specifiedLogisticsTransportMovement[] = $specifiedLogisticsTransportMovement;
        return $this;
    }

    /**
     * isset specifiedLogisticsTransportMovement
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetSpecifiedLogisticsTransportMovement($index)
    {
        return isset($this->specifiedLogisticsTransportMovement[$index]);
    }

    /**
     * unset specifiedLogisticsTransportMovement
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetSpecifiedLogisticsTransportMovement($index)
    {
        unset($this->specifiedLogisticsTransportMovement[$index]);
    }

    /**
     * Gets as specifiedLogisticsTransportMovement
     *
     * @return \horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType[]
     */
    public function getSpecifiedLogisticsTransportMovement()
    {
        return $this->specifiedLogisticsTransportMovement;
    }

    /**
     * Sets a new specifiedLogisticsTransportMovement
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\LogisticsTransportMovementType[] $specifiedLogisticsTransportMovement
     * @return self
     */
    public function setSpecifiedLogisticsTransportMovement(?array $specifiedLogisticsTransportMovement = null)
    {
        $this->specifiedLogisticsTransportMovement = $specifiedLogisticsTransportMovement;
        return $this;
    }
}
