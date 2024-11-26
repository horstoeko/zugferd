<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing DocumentLineDocumentType
 *
 * XSD Type: DocumentLineDocumentType
 */
class DocumentLineDocumentType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType $lineID
     */
    private $lineID = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType $parentLineID
     */
    private $parentLineID = null;

    /**
     * @var string $lineStatusCode
     */
    private $lineStatusCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\CodeType $lineStatusReasonCode
     */
    private $lineStatusReasonCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\NoteType[] $includedNote
     */
    private $includedNote = [
        
    ];

    /**
     * Gets as lineID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType
     */
    public function getLineID()
    {
        return $this->lineID;
    }

    /**
     * Sets a new lineID
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType $lineID
     * @return self
     */
    public function setLineID(\horstoeko\zugferd\entities\extended\udt\IDType $lineID)
    {
        $this->lineID = $lineID;
        return $this;
    }

    /**
     * Gets as parentLineID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType
     */
    public function getParentLineID()
    {
        return $this->parentLineID;
    }

    /**
     * Sets a new parentLineID
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType $parentLineID
     * @return self
     */
    public function setParentLineID(?\horstoeko\zugferd\entities\extended\udt\IDType $parentLineID = null)
    {
        $this->parentLineID = $parentLineID;
        return $this;
    }

    /**
     * Gets as lineStatusCode
     *
     * @return string
     */
    public function getLineStatusCode()
    {
        return $this->lineStatusCode;
    }

    /**
     * Sets a new lineStatusCode
     *
     * @param  string $lineStatusCode
     * @return self
     */
    public function setLineStatusCode($lineStatusCode)
    {
        $this->lineStatusCode = $lineStatusCode;
        return $this;
    }

    /**
     * Gets as lineStatusReasonCode
     *
     * @return \horstoeko\zugferd\entities\extended\udt\CodeType
     */
    public function getLineStatusReasonCode()
    {
        return $this->lineStatusReasonCode;
    }

    /**
     * Sets a new lineStatusReasonCode
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\CodeType $lineStatusReasonCode
     * @return self
     */
    public function setLineStatusReasonCode(?\horstoeko\zugferd\entities\extended\udt\CodeType $lineStatusReasonCode = null)
    {
        $this->lineStatusReasonCode = $lineStatusReasonCode;
        return $this;
    }

    /**
     * Adds as includedNote
     *
     * @return self
     * @param  \horstoeko\zugferd\entities\extended\ram\NoteType $includedNote
     */
    public function addToIncludedNote(\horstoeko\zugferd\entities\extended\ram\NoteType $includedNote)
    {
        $this->includedNote[] = $includedNote;
        return $this;
    }

    /**
     * isset includedNote
     *
     * @param  int|string $index
     * @return bool
     */
    public function issetIncludedNote($index)
    {
        return isset($this->includedNote[$index]);
    }

    /**
     * unset includedNote
     *
     * @param  int|string $index
     * @return void
     */
    public function unsetIncludedNote($index)
    {
        unset($this->includedNote[$index]);
    }

    /**
     * Gets as includedNote
     *
     * @return \horstoeko\zugferd\entities\extended\ram\NoteType[]
     */
    public function getIncludedNote()
    {
        return $this->includedNote;
    }

    /**
     * Sets a new includedNote
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\NoteType[] $includedNote
     * @return self
     */
    public function setIncludedNote(?array $includedNote = null)
    {
        $this->includedNote = $includedNote;
        return $this;
    }
}
