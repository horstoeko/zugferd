<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing SupplyChainEventType
 *
 *
 * XSD Type: SupplyChainEventType
 */
class SupplyChainEventType
{

    /**
     * @var \horstoeko\zugferd\basicwl\udt\DateTimeType $occurrenceDateTime
     */
    private $occurrenceDateTime = null;

    /**
     * Gets as occurrenceDateTime
     *
     * @return \horstoeko\zugferd\basicwl\udt\DateTimeType
     */
    public function getOccurrenceDateTime()
    {
        return $this->occurrenceDateTime;
    }

    /**
     * Sets a new occurrenceDateTime
     *
     * @param \horstoeko\zugferd\basicwl\udt\DateTimeType $occurrenceDateTime
     * @return self
     */
    public function setOccurrenceDateTime(\horstoeko\zugferd\basicwl\udt\DateTimeType $occurrenceDateTime)
    {
        $this->occurrenceDateTime = $occurrenceDateTime;
        return $this;
    }


}

