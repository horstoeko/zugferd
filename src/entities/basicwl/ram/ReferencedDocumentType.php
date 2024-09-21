<?php

namespace horstoeko\zugferd\entities\basicwl\ram;

/**
 * Class representing ReferencedDocumentType
 *
 * XSD Type: ReferencedDocumentType
 */
class ReferencedDocumentType
{

    /**
     * @var \horstoeko\zugferd\entities\basicwl\udt\IDType $issuerAssignedID
     */
    private $issuerAssignedID = null;

    /**
     * @var \horstoeko\zugferd\entities\basicwl\qdt\FormattedDateTimeType $formattedIssueDateTime
     */
    private $formattedIssueDateTime = null;

    /**
     * Gets as issuerAssignedID
     *
     * @return \horstoeko\zugferd\entities\basicwl\udt\IDType
     */
    public function getIssuerAssignedID()
    {
        return $this->issuerAssignedID;
    }

    /**
     * Sets a new issuerAssignedID
     *
     * @param  \horstoeko\zugferd\entities\basicwl\udt\IDType $issuerAssignedID
     * @return self
     */
    public function setIssuerAssignedID(\horstoeko\zugferd\entities\basicwl\udt\IDType $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
        return $this;
    }

    /**
     * Gets as formattedIssueDateTime
     *
     * @return \horstoeko\zugferd\entities\basicwl\qdt\FormattedDateTimeType
     */
    public function getFormattedIssueDateTime()
    {
        return $this->formattedIssueDateTime;
    }

    /**
     * Sets a new formattedIssueDateTime
     *
     * @param  \horstoeko\zugferd\entities\basicwl\qdt\FormattedDateTimeType $formattedIssueDateTime
     * @return self
     */
    public function setFormattedIssueDateTime(?\horstoeko\zugferd\entities\basicwl\qdt\FormattedDateTimeType $formattedIssueDateTime = null)
    {
        $this->formattedIssueDateTime = $formattedIssueDateTime;
        return $this;
    }
}
