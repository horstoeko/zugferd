<?php

namespace horstoeko\zugferd\entities\basic\ram;

/**
 * Class representing DocumentLineDocumentType
 *
 * XSD Type: DocumentLineDocumentType
 */
class DocumentLineDocumentType
{

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\IDType|null $lineID
     */
    private $lineID = null;

    /**
     * @var \horstoeko\zugferd\entities\basic\ram\NoteType|null $includedNote
     */
    private $includedNote = null;

    /**
     * Gets as lineID
     *
     * @return \horstoeko\zugferd\entities\basic\udt\IDType|null
     */
    public function getLineID()
    {
        return $this->lineID;
    }

    /**
     * Sets a new lineID
     *
     * @param  \horstoeko\zugferd\entities\basic\udt\IDType $lineID
     * @return self
     */
    public function setLineID(\horstoeko\zugferd\entities\basic\udt\IDType $lineID)
    {
        $this->lineID = $lineID;
        return $this;
    }

    /**
     * Gets as includedNote
     *
     * @return \horstoeko\zugferd\entities\basic\ram\NoteType|null
     */
    public function getIncludedNote()
    {
        return $this->includedNote;
    }

    /**
     * Sets a new includedNote
     *
     * @param  \horstoeko\zugferd\entities\basic\ram\NoteType|null $includedNote
     * @return self
     */
    public function setIncludedNote(?\horstoeko\zugferd\entities\basic\ram\NoteType $includedNote = null)
    {
        $this->includedNote = $includedNote;
        return $this;
    }
}
