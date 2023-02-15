<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing ProcuringProjectType
 *
 * XSD Type: ProcuringProjectType
 */
class ProcuringProjectType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType $iD
     */
    private $iD = null;

    /**
     * @var string $name
     */
    private $name = null;

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

    /**
     * Gets as name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param  string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
