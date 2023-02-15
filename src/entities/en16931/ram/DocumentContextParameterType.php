<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing DocumentContextParameterType
 *
 * XSD Type: DocumentContextParameterType
 */
class DocumentContextParameterType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType $iD
     */
    private $iD = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\entities\en16931\udt\IDType $iD)
    {
        $this->iD = $iD;
        return $this;
    }
}
