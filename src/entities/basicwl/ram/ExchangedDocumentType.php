<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing ExchangedDocumentType
 *
 *
 * XSD Type: ExchangedDocumentType
 */
class ExchangedDocumentType
{

    /**
     * @var \horstoeko\zugferd\basicwl\udt\IDType $iD
     */
    private $iD = null;

    /**
     * @var string $typeCode
     */
    private $typeCode = null;

    /**
     * @var \horstoeko\zugferd\basicwl\udt\DateTimeType $issueDateTime
     */
    private $issueDateTime = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\NoteType[] $includedNote
     */
    private $includedNote = [
        
    ];

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\basicwl\udt\IDType
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param \horstoeko\zugferd\basicwl\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\basicwl\udt\IDType $iD)
    {
        $this->iD = $iD;
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
     * Gets as issueDateTime
     *
     * @return \horstoeko\zugferd\basicwl\udt\DateTimeType
     */
    public function getIssueDateTime()
    {
        return $this->issueDateTime;
    }

    /**
     * Sets a new issueDateTime
     *
     * @param \horstoeko\zugferd\basicwl\udt\DateTimeType $issueDateTime
     * @return self
     */
    public function setIssueDateTime(\horstoeko\zugferd\basicwl\udt\DateTimeType $issueDateTime)
    {
        $this->issueDateTime = $issueDateTime;
        return $this;
    }

    /**
     * Adds as includedNote
     *
     * @return self
     * @param \horstoeko\zugferd\basicwl\ram\NoteType $includedNote
     */
    public function addToIncludedNote(\horstoeko\zugferd\basicwl\ram\NoteType $includedNote)
    {
        $this->includedNote[] = $includedNote;
        return $this;
    }

    /**
     * isset includedNote
     *
     * @param int|string $index
     * @return bool
     */
    public function issetIncludedNote($index)
    {
        return isset($this->includedNote[$index]);
    }

    /**
     * unset includedNote
     *
     * @param int|string $index
     * @return void
     */
    public function unsetIncludedNote($index)
    {
        unset($this->includedNote[$index]);
    }

    /**
     * Gets as includedNote
     *
     * @return \horstoeko\zugferd\basicwl\ram\NoteType[]
     */
    public function getIncludedNote()
    {
        return $this->includedNote;
    }

    /**
     * Sets a new includedNote
     *
     * @param \horstoeko\zugferd\basicwl\ram\NoteType[] $includedNote
     * @return self
     */
    public function setIncludedNote(array $includedNote)
    {
        $this->includedNote = $includedNote;
        return $this;
    }


}

