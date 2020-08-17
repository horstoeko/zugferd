<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing ReferencedDocumentType
 *
 *
 * XSD Type: ReferencedDocumentType
 */
class ReferencedDocumentType
{

    /**
     * @var \horstoeko\zugferd\basicwl\udt\IDType $issuerAssignedID
     */
    private $issuerAssignedID = null;

    /**
     * @var \horstoeko\zugferd\basicwl\qdt\FormattedDateTimeType $formattedIssueDateTime
     */
    private $formattedIssueDateTime = null;

    /**
     * Gets as issuerAssignedID
     *
     * @return \horstoeko\zugferd\basicwl\udt\IDType
     */
    public function getIssuerAssignedID()
    {
        return $this->issuerAssignedID;
    }

    /**
     * Sets a new issuerAssignedID
     *
     * @param \horstoeko\zugferd\basicwl\udt\IDType $issuerAssignedID
     * @return self
     */
    public function setIssuerAssignedID(\horstoeko\zugferd\basicwl\udt\IDType $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
        return $this;
    }

    /**
     * Gets as formattedIssueDateTime
     *
     * @return \horstoeko\zugferd\basicwl\qdt\FormattedDateTimeType
     */
    public function getFormattedIssueDateTime()
    {
        return $this->formattedIssueDateTime;
    }

    /**
     * Sets a new formattedIssueDateTime
     *
     * @param \horstoeko\zugferd\basicwl\qdt\FormattedDateTimeType $formattedIssueDateTime
     * @return self
     */
    public function setFormattedIssueDateTime(\horstoeko\zugferd\basicwl\qdt\FormattedDateTimeType $formattedIssueDateTime)
    {
        $this->formattedIssueDateTime = $formattedIssueDateTime;
        return $this;
    }


}

