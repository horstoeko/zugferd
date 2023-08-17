<?php

namespace horstoeko\zugferd\entities\minimum\ram;

/**
 * Class representing LegalOrganizationType
 *
 * XSD Type: LegalOrganizationType
 */
class LegalOrganizationType
{

    /**
     * @var \horstoeko\zugferd\entities\minimum\udt\IDType $iD
     */
    private $iD = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\entities\minimum\udt\IDType
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param  \horstoeko\zugferd\entities\minimum\udt\IDType $iD
     * @return self
     */
    public function setID(?\horstoeko\zugferd\entities\minimum\udt\IDType $iD = null)
    {
        $this->iD = $iD;
        return $this;
    }
}
