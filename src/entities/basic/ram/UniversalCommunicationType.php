<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing UniversalCommunicationType
 *
 *
 * XSD Type: UniversalCommunicationType
 */
class UniversalCommunicationType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\IDType $uRIID
     */
    private $uRIID = null;

    /**
     * Gets as uRIID
     *
     * @return \horstoeko\zugferd\basic\udt\IDType
     */
    public function getURIID()
    {
        return $this->uRIID;
    }

    /**
     * Sets a new uRIID
     *
     * @param \horstoeko\zugferd\basic\udt\IDType $uRIID
     * @return self
     */
    public function setURIID(\horstoeko\zugferd\basic\udt\IDType $uRIID)
    {
        $this->uRIID = $uRIID;
        return $this;
    }


}

