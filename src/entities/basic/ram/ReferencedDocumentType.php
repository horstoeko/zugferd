<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing ReferencedDocumentType
 *
 *
 * XSD Type: ReferencedDocumentType
 */
class ReferencedDocumentType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\IDType $issuerAssignedID
     */
    private $issuerAssignedID = null;

    /**
     * @var \horstoeko\zugferd\basic\qdt\FormattedDateTimeType $formattedIssueDateTime
     */
    private $formattedIssueDateTime = null;

    /**
     * Gets as issuerAssignedID
     *
     * @return \horstoeko\zugferd\basic\udt\IDType
     */
    public function getIssuerAssignedID()
    {
        return $this->issuerAssignedID;
    }

    /**
     * Sets a new issuerAssignedID
     *
     * @param \horstoeko\zugferd\basic\udt\IDType $issuerAssignedID
     * @return self
     */
    public function setIssuerAssignedID(\horstoeko\zugferd\basic\udt\IDType $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
        return $this;
    }

    /**
     * Gets as formattedIssueDateTime
     *
     * @return \horstoeko\zugferd\basic\qdt\FormattedDateTimeType
     */
    public function getFormattedIssueDateTime()
    {
        return $this->formattedIssueDateTime;
    }

    /**
     * Sets a new formattedIssueDateTime
     *
     * @param \horstoeko\zugferd\basic\qdt\FormattedDateTimeType $formattedIssueDateTime
     * @return self
     */
    public function setFormattedIssueDateTime(\horstoeko\zugferd\basic\qdt\FormattedDateTimeType $formattedIssueDateTime)
    {
        $this->formattedIssueDateTime = $formattedIssueDateTime;
        return $this;
    }


}

