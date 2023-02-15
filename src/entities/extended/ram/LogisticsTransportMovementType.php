<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing LogisticsTransportMovementType
 *
 * XSD Type: LogisticsTransportMovementType
 */
class LogisticsTransportMovementType
{

    /**
     * @var string $modeCode
     */
    private $modeCode = null;

    /**
     * Gets as modeCode
     *
     * @return string
     */
    public function getModeCode()
    {
        return $this->modeCode;
    }

    /**
     * Sets a new modeCode
     *
     * @param  string $modeCode
     * @return self
     */
    public function setModeCode($modeCode)
    {
        $this->modeCode = $modeCode;
        return $this;
    }
}
