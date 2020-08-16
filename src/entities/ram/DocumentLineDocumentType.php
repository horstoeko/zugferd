<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing DocumentLineDocumentType
 *
 *
 * XSD Type: DocumentLineDocumentType
 */
class DocumentLineDocumentType
{

    /**
     * @property \horstoeko\zugferd\udt\IDType $lineID
     */
    private $lineID = null;

    /**
     * @property string $lineStatusCode
     */
    private $lineStatusCode = null;

    /**
     * @property \horstoeko\zugferd\udt\CodeType $lineStatusReasonCode
     */
    private $lineStatusReasonCode = null;

    /**
     * @property \horstoeko\zugferd\ram\NoteType[] $includedNote
     */
    private $includedNote = null;

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
     * @param string $lineStatusCode
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
     * @return \horstoeko\zugferd\udt\CodeType
     */
    public function getLineStatusReasonCode()
    {
        return $this->lineStatusReasonCode;
    }

    /**
     * Sets a new lineStatusReasonCode
     *
     * @param \horstoeko\zugferd\udt\CodeType $lineStatusReasonCode
     * @return self
     */
    public function setLineStatusReasonCode(\horstoeko\zugferd\udt\CodeType $lineStatusReasonCode)
    {
        $this->lineStatusReasonCode = $lineStatusReasonCode;
        return $this;
    }

    /**
     * Adds as includedNote
     *
     * @return self
     * @param \horstoeko\zugferd\ram\NoteType $includedNote
     */
    public function addToIncludedNote(\horstoeko\zugferd\ram\NoteType $includedNote)
    {
        $this->includedNote[] = $includedNote;
        return $this;
    }

    /**
     * isset includedNote
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetIncludedNote($index)
    {
        return isset($this->includedNote[$index]);
    }

    /**
     * unset includedNote
     *
     * @param scalar $index
     * @return void
     */
    public function unsetIncludedNote($index)
    {
        unset($this->includedNote[$index]);
    }

    /**
     * Gets as includedNote
     *
     * @return \horstoeko\zugferd\ram\NoteType[]
     */
    public function getIncludedNote()
    {
        return $this->includedNote;
    }

    /**
     * Sets a new includedNote
     *
     * @param \horstoeko\zugferd\ram\NoteType[] $includedNote
     * @return self
     */
    public function setIncludedNote(array $includedNote)
    {
        $this->includedNote = $includedNote;
        return $this;
    }


}

