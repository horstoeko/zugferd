<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing TaxRegistrationType
 *
 *
 * XSD Type: TaxRegistrationType
 */
class TaxRegistrationType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\IDType $iD
     */
    private $iD = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\basic\udt\IDType
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param \horstoeko\zugferd\basic\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\basic\udt\IDType $iD)
    {
        $this->iD = $iD;
        return $this;
    }


}

