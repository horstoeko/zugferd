<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing SupplyChainEventType
 *
 *
 * XSD Type: SupplyChainEventType
 */
class SupplyChainEventType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\DateTimeType $occurrenceDateTime
     */
    private $occurrenceDateTime = null;

    /**
     * Gets as occurrenceDateTime
     *
     * @return \horstoeko\zugferd\basic\udt\DateTimeType
     */
    public function getOccurrenceDateTime()
    {
        return $this->occurrenceDateTime;
    }

    /**
     * Sets a new occurrenceDateTime
     *
     * @param \horstoeko\zugferd\basic\udt\DateTimeType $occurrenceDateTime
     * @return self
     */
    public function setOccurrenceDateTime(\horstoeko\zugferd\basic\udt\DateTimeType $occurrenceDateTime)
    {
        $this->occurrenceDateTime = $occurrenceDateTime;
        return $this;
    }


}

