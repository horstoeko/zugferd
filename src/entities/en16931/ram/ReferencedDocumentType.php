<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing ReferencedDocumentType
 *
 * XSD Type: ReferencedDocumentType
 */
class ReferencedDocumentType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType|null $issuerAssignedID
     */
    private $issuerAssignedID = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType|null $uRIID
     */
    private $uRIID = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\IDType|null $lineID
     */
    private $lineID = null;

    /**
     * @var string|null $typeCode
     */
    private $typeCode = null;

    /**
     * @var string|null $name
     */
    private $name = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\BinaryObjectType|null $attachmentBinaryObject
     */
    private $attachmentBinaryObject = null;

    /**
     * @var string|null $referenceTypeCode
     */
    private $referenceTypeCode = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\qdt\FormattedDateTimeType|null $formattedIssueDateTime
     */
    private $formattedIssueDateTime = null;

    /**
     * Gets as issuerAssignedID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType|null
     */
    public function getIssuerAssignedID()
    {
        return $this->issuerAssignedID;
    }

    /**
     * Sets a new issuerAssignedID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType|null $issuerAssignedID
     * @return self
     */
    public function setIssuerAssignedID(?\horstoeko\zugferd\entities\en16931\udt\IDType $issuerAssignedID = null)
    {
        $this->issuerAssignedID = $issuerAssignedID;
        return $this;
    }

    /**
     * Gets as uRIID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType|null
     */
    public function getURIID()
    {
        return $this->uRIID;
    }

    /**
     * Sets a new uRIID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType|null $uRIID
     * @return self
     */
    public function setURIID(?\horstoeko\zugferd\entities\en16931\udt\IDType $uRIID = null)
    {
        $this->uRIID = $uRIID;
        return $this;
    }

    /**
     * Gets as lineID
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\IDType|null
     */
    public function getLineID()
    {
        return $this->lineID;
    }

    /**
     * Sets a new lineID
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\IDType|null $lineID
     * @return self
     */
    public function setLineID(?\horstoeko\zugferd\entities\en16931\udt\IDType $lineID = null)
    {
        $this->lineID = $lineID;
        return $this;
    }

    /**
     * Gets as typeCode
     *
     * @return string|null
     */
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * Sets a new typeCode
     *
     * @param  string $typeCode
     * @return self
     */
    public function setTypeCode($typeCode)
    {
        $this->typeCode = $typeCode;
        return $this;
    }

    /**
     * Gets as name
     *
     * @return string|null
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

    /**
     * Gets as attachmentBinaryObject
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\BinaryObjectType|null
     */
    public function getAttachmentBinaryObject()
    {
        return $this->attachmentBinaryObject;
    }

    /**
     * Sets a new attachmentBinaryObject
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\BinaryObjectType|null $attachmentBinaryObject
     * @return self
     */
    public function setAttachmentBinaryObject(?\horstoeko\zugferd\entities\en16931\udt\BinaryObjectType $attachmentBinaryObject = null)
    {
        $this->attachmentBinaryObject = $attachmentBinaryObject;
        return $this;
    }

    /**
     * Gets as referenceTypeCode
     *
     * @return string|null
     */
    public function getReferenceTypeCode()
    {
        return $this->referenceTypeCode;
    }

    /**
     * Sets a new referenceTypeCode
     *
     * @param  string $referenceTypeCode
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
     * @return \horstoeko\zugferd\entities\en16931\qdt\FormattedDateTimeType|null
     */
    public function getFormattedIssueDateTime()
    {
        return $this->formattedIssueDateTime;
    }

    /**
     * Sets a new formattedIssueDateTime
     *
     * @param  \horstoeko\zugferd\entities\en16931\qdt\FormattedDateTimeType|null $formattedIssueDateTime
     * @return self
     */
    public function setFormattedIssueDateTime(?\horstoeko\zugferd\entities\en16931\qdt\FormattedDateTimeType $formattedIssueDateTime = null)
    {
        $this->formattedIssueDateTime = $formattedIssueDateTime;
        return $this;
    }
}
