<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing UniversalCommunicationType
 *
 *
 * XSD Type: UniversalCommunicationType
 */
class UniversalCommunicationType
{

    /**
     * @property \horstoeko\zugferd\udt\IDType $uRIID
     */
    private $uRIID = null;

    /**
     * @property string $completeNumber
     */
    private $completeNumber = null;

    /**
     * Gets as uRIID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getURIID()
    {
        return $this->uRIID;
    }

    /**
     * Sets a new uRIID
     *
     * @param \horstoeko\zugferd\udt\IDType $uRIID
     * @return self
     */
    public function setURIID(\horstoeko\zugferd\udt\IDType $uRIID)
    {
        $this->uRIID = $uRIID;
        return $this;
    }

    /**
     * Gets as completeNumber
     *
     * @return string
     */
    public function getCompleteNumber()
    {
        return $this->completeNumber;
    }

    /**
     * Sets a new completeNumber
     *
     * @param string $completeNumber
     * @return self
     */
    public function setCompleteNumber($completeNumber)
    {
        $this->completeNumber = $completeNumber;
        return $this;
    }


}

