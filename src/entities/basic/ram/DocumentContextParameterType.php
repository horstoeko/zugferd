<?php

namespace horstoeko\zugferd\entities\basic\ram;

/**
 * Class representing DocumentContextParameterType
 *
 * XSD Type: DocumentContextParameterType
 */
class DocumentContextParameterType
{

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\IDType $iD
     */
    private $iD = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\entities\basic\udt\IDType
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param  \horstoeko\zugferd\entities\basic\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\entities\basic\udt\IDType $iD)
    {
        $this->iD = $iD;
        return $this;
    }
}
