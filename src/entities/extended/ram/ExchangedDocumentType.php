<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing ExchangedDocumentType
 *
 * XSD Type: ExchangedDocumentType
 */
class ExchangedDocumentType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType|null $iD
     */
    private $iD = null;

    /**
     * @var string|null $name
     */
    private $name = null;

    /**
     * @var string|null $typeCode
     */
    private $typeCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType|null $issueDateTime
     */
    private $issueDateTime = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType|null $copyIndicator
     */
    private $copyIndicator = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IDType|null $languageID
     */
    private $languageID = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\NoteType[] $includedNote
     */
    private $includedNote = [
        
    ];

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType|null $effectiveSpecifiedPeriod
     */
    private $effectiveSpecifiedPeriod = null;

    /**
     * Gets as iD
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType|null
     */
    public function getID()
    {
        return $this->iD;
    }

    /**
     * Sets a new iD
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType $iD
     * @return self
     */
    public function setID(\horstoeko\zugferd\entities\extended\udt\IDType $iD)
    {
        $this->iD = $iD;
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
     * Gets as issueDateTime
     *
     * @return \horstoeko\zugferd\entities\extended\udt\DateTimeType|null
     */
    public function getIssueDateTime()
    {
        return $this->issueDateTime;
    }

    /**
     * Sets a new issueDateTime
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\DateTimeType $issueDateTime
     * @return self
     */
    public function setIssueDateTime(\horstoeko\zugferd\entities\extended\udt\DateTimeType $issueDateTime)
    {
        $this->issueDateTime = $issueDateTime;
        return $this;
    }

    /**
     * Gets as copyIndicator
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IndicatorType|null
     */
    public function getCopyIndicator()
    {
        return $this->copyIndicator;
    }

    /**
     * Sets a new copyIndicator
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IndicatorType|null $copyIndicator
     * @return self
     */
    public function setCopyIndicator(?\horstoeko\zugferd\entities\extended\udt\IndicatorType $copyIndicator = null)
    {
        $this->copyIndicator = $copyIndicator;
        return $this;
    }

    /**
     * Gets as languageID
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IDType|null
     */
    public function getLanguageID()
    {
        return $this->languageID;
    }

    /**
     * Sets a new languageID
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IDType|null $languageID
     * @return self
     */
    public function setLanguageID(?\horstoeko\zugferd\entities\extended\udt\IDType $languageID = null)
    {
        $this->languageID = $languageID;
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
     * @param  \horstoeko\zugferd\entities\extended\ram\NoteType[]|null $includedNote
     * @return self
     */
    public function setIncludedNote(?array $includedNote = null)
    {
        $this->includedNote = $includedNote;
        return $this;
    }

    /**
     * Gets as effectiveSpecifiedPeriod
     *
     * @return \horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType|null
     */
    public function getEffectiveSpecifiedPeriod()
    {
        return $this->effectiveSpecifiedPeriod;
    }

    /**
     * Sets a new effectiveSpecifiedPeriod
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType|null $effectiveSpecifiedPeriod
     * @return self
     */
    public function setEffectiveSpecifiedPeriod(?\horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType $effectiveSpecifiedPeriod = null)
    {
        $this->effectiveSpecifiedPeriod = $effectiveSpecifiedPeriod;
        return $this;
    }
}
