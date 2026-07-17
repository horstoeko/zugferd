<?php

namespace horstoeko\zugferd\entities\basicwl\ram;

/**
 * Class representing TaxRegistrationType
 *
 * XSD Type: TaxRegistrationType
 */
class TaxRegistrationType
{

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\IDType|null $iD
     */
    private $iD = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\IDType|null
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\entities\basicwl\udt\IDType $iD)
    {
        $this->iD = $iD;
        return $this;
    }
}
