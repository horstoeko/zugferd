<?php

namespace horstoeko\zugferd\entities\minimum\ram;

/**
 * Class representing ReferencedDocumentType
 *
 * XSD Type: ReferencedDocumentType
 */
class ReferencedDocumentType
{

    /**
     * @var \horstoeko\zugferd\entities\minimum\udt\IDType $issuerAssignedID
     */
    private $issuerAssignedID = null;

    /**
     * Gets as issuerAssignedID
     *
     * @return \horstoeko\zugferd\entities\minimum\udt\IDType
     */
    public function getIssuerAssignedID()
    {
        return $this->issuerAssignedID;
    }

    /**
     * Sets a new issuerAssignedID
     *
     * @param  \horstoeko\zugferd\entities\minimum\udt\IDType $issuerAssignedID
     * @return self
     */
    public function setIssuerAssignedID(\horstoeko\zugferd\entities\minimum\udt\IDType $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
        return $this;
    }
}
