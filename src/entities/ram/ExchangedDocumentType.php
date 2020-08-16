<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing ExchangedDocumentType
 *
 *
 * XSD Type: ExchangedDocumentType
 */
class ExchangedDocumentType
{

    /**
     * @property \horstoeko\zugferd\udt\IDType $iD
     */
    private $iD = null;

    /**
     * @property string $name
     */
    private $name = null;

    /**
     * @property string $typeCode
     */
    private $typeCode = null;

    /**
     * @property \horstoeko\zugferd\udt\DateTimeType $issueDateTime
     */
    private $issueDateTime = null;

    /**
     * @property \horstoeko\zugferd\udt\IndicatorType $copyIndicator
     */
    private $copyIndicator = null;

    /**
     * @property \horstoeko\zugferd\udt\IDType[] $languageID
     */
    private $languageID = null;

    /**
     * @property \horstoeko\zugferd\ram\NoteType[] $includedNote
     */
    private $includedNote = null;

    /**
     * @property \horstoeko\zugferd\ram\SpecifiedPeriodType $effectiveSpecifiedPeriod
     */
    private $effectiveSpecifiedPeriod = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\udt\IDType
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param \horstoeko\zugferd\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\udt\IDType $iD)
    {
        $this->iD = $iD;
        return $this;
    }

    /**
     * Gets as name
     *
     * @return string
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
    public function setName($name)
    {
        $this->name = $name;
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
     * @return \horstoeko\zugferd\udt\DateTimeType
     */
    public function getIssueDateTime()
    {
        return $this->issueDateTime;
    }

    /**
     * Sets a new issueDateTime
     *
     * @param \horstoeko\zugferd\udt\DateTimeType $issueDateTime
     * @return self
     */
    public function setIssueDateTime(\horstoeko\zugferd\udt\DateTimeType $issueDateTime)
    {
        $this->issueDateTime = $issueDateTime;
        return $this;
    }

    /**
     * Gets as copyIndicator
     *
     * @return \horstoeko\zugferd\udt\IndicatorType
     */
    public function getCopyIndicator()
    {
        return $this->copyIndicator;
    }

    /**
     * Sets a new copyIndicator
     *
     * @param \horstoeko\zugferd\udt\IndicatorType $copyIndicator
     * @return self
     */
    public function setCopyIndicator(\horstoeko\zugferd\udt\IndicatorType $copyIndicator)
    {
        $this->copyIndicator = $copyIndicator;
        return $this;
    }

    /**
     * Adds as languageID
     *
     * @return self
     * @param \horstoeko\zugferd\udt\IDType $languageID
     */
    public function addToLanguageID(\horstoeko\zugferd\udt\IDType $languageID)
    {
        $this->languageID[] = $languageID;
        return $this;
    }

    /**
     * isset languageID
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetLanguageID($index)
    {
        return isset($this->languageID[$index]);
    }

    /**
     * unset languageID
     *
     * @param scalar $index
     * @return void
     */
    public function unsetLanguageID($index)
    {
        unset($this->languageID[$index]);
    }

    /**
     * Gets as languageID
     *
     * @return \horstoeko\zugferd\udt\IDType[]
     */
    public function getLanguageID()
    {
        return $this->languageID;
    }

    /**
     * Sets a new languageID
     *
     * @param \horstoeko\zugferd\udt\IDType[] $languageID
     * @return self
     */
    public function setLanguageID(array $languageID)
    {
        $this->languageID = $languageID;
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

    /**
     * Gets as effectiveSpecifiedPeriod
     *
     * @return \horstoeko\zugferd\ram\SpecifiedPeriodType
     */
    public function getEffectiveSpecifiedPeriod()
    {
        return $this->effectiveSpecifiedPeriod;
    }

    /**
     * Sets a new effectiveSpecifiedPeriod
     *
     * @param \horstoeko\zugferd\ram\SpecifiedPeriodType $effectiveSpecifiedPeriod
     * @return self
     */
    public function setEffectiveSpecifiedPeriod(\horstoeko\zugferd\ram\SpecifiedPeriodType $effectiveSpecifiedPeriod)
    {
        $this->effectiveSpecifiedPeriod = $effectiveSpecifiedPeriod;
        return $this;
    }


}

