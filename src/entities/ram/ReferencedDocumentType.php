<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing ReferencedDocumentType
 *
 *
 * XSD Type: ReferencedDocumentType
 */
class ReferencedDocumentType
{

    /**
     * @var \horstoeko\zugferd\udt\IDType $issuerAssignedID
     */
    private $issuerAssignedID = null;

    /**
     * @var \horstoeko\zugferd\udt\IDType $uRIID
     */
    private $uRIID = null;

    /**
     * @var \horstoeko\zugferd\udt\IDType $lineID
     */
    private $lineID = null;

    /**
     * @var string $typeCode
     */
    private $typeCode = null;

    /**
     * @var string[] $name
     */
    private $name = [
        
    ];

    /**
     * @var \horstoeko\zugferd\udt\BinaryObjectType $attachmentBinaryObject
     */
    private $attachmentBinaryObject = null;

    /**
     * @var string $referenceTypeCode
     */
    private $referenceTypeCode = null;

    /**
     * @var \horstoeko\zugferd\qdt\FormattedDateTimeType $formattedIssueDateTime
     */
    private $formattedIssueDateTime = null;

    /**
     * Gets as issuerAssignedID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getIssuerAssignedID()
    {
        return $this->issuerAssignedID;
    }

    /**
     * Sets a new issuerAssignedID
     *
     * @param \horstoeko\zugferd\udt\IDType $issuerAssignedID
     * @return self
     */
    public function setIssuerAssignedID(\horstoeko\zugferd\udt\IDType $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
        return $this;
    }

    /**
     * Gets as uRIID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getURIID()
    {
        return $this->uRIID;
    }

    /**
     * Sets a new uRIID
     *
     * @param \horstoeko\zugferd\udt\IDType $uRIID
     * @return self
     */
    public function setURIID(\horstoeko\zugferd\udt\IDType $uRIID)
    {
        $this->uRIID = $uRIID;
        return $this;
    }

    /**
     * Gets as lineID
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getLineID()
    {
        return $this->lineID;
    }

    /**
     * Sets a new lineID
     *
     * @param \horstoeko\zugferd\udt\IDType $lineID
     * @return self
     */
    public function setLineID(\horstoeko\zugferd\udt\IDType $lineID)
    {
        $this->lineID = $lineID;
        return $this;
    }

    /**
     * Gets as typeCode
     *
     * @return string
     */
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * Sets a new typeCode
     *
     * @param string $typeCode
     * @return self
     */
    public function setTypeCode($typeCode)
    {
        $this->typeCode = $typeCode;
        return $this;
    }

    /**
     * Adds as name
     *
     * @return self
     * @param string $name
     */
    public function addToName($name)
    {
        $this->name[] = $name;
        return $this;
    }

    /**
     * isset name
     *
     * @param int|string $index
     * @return bool
     */
    public function issetName($index)
    {
        return isset($this->name[$index]);
    }

    /**
     * unset name
     *
     * @param int|string $index
     * @return void
     */
    public function unsetName($index)
    {
        unset($this->name[$index]);
    }

    /**
     * Gets as name
     *
     * @return string[]
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param string $name
     * @return self
     */
    public function setName(array $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets as attachmentBinaryObject
     *
     * @return \horstoeko\zugferd\udt\BinaryObjectType
     */
    public function getAttachmentBinaryObject()
    {
        return $this->attachmentBinaryObject;
    }

    /**
     * Sets a new attachmentBinaryObject
     *
     * @param \horstoeko\zugferd\udt\BinaryObjectType $attachmentBinaryObject
     * @return self
     */
    public function setAttachmentBinaryObject(\horstoeko\zugferd\udt\BinaryObjectType $attachmentBinaryObject)
    {
        $this->attachmentBinaryObject = $attachmentBinaryObject;
        return $this;
    }

    /**
     * Gets as referenceTypeCode
     *
     * @return string
     */
    public function getReferenceTypeCode()
    {
        return $this->referenceTypeCode;
    }

    /**
     * Sets a new referenceTypeCode
     *
     * @param string $referenceTypeCode
     * @return self
     */
    public function setReferenceTypeCode($referenceTypeCode)
    {
        $this->referenceTypeCode = $referenceTypeCode;
        return $this;
    }

    /**
     * Gets as formattedIssueDateTime
     *
     * @return \horstoeko\zugferd\qdt\FormattedDateTimeType
     */
    public function getFormattedIssueDateTime()
    {
        return $this->formattedIssueDateTime;
    }

    /**
     * Sets a new formattedIssueDateTime
     *
     * @param \horstoeko\zugferd\qdt\FormattedDateTimeType $formattedIssueDateTime
     * @return self
     */
    public function setFormattedIssueDateTime(\horstoeko\zugferd\qdt\FormattedDateTimeType $formattedIssueDateTime)
    {
        $this->formattedIssueDateTime = $formattedIssueDateTime;
        return $this;
    }


}

