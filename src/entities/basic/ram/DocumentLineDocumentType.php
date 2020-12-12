<?php

namespace horstoeko\zugferd\entities\basic\ram;

/**
 * Class representing DocumentLineDocumentType
 *
 *
 * XSD Type: DocumentLineDocumentType
 */
class DocumentLineDocumentType
{

    /**
     * @var \horstoeko\zugferd\entities\basic\udt\IDType $lineID
     */
    private $lineID = null;

    /**
     * Gets as lineID
     *
     * @return \horstoeko\zugferd\entities\basic\udt\IDType
     */
    public function getLineID()
    {
        return $this->lineID;
    }

    /**
     * Sets a new lineID
     *
     * @param \horstoeko\zugferd\entities\basic\udt\IDType $lineID
     * @return self
     */
    public function setLineID(\horstoeko\zugferd\entities\basic\udt\IDType $lineID)
    {
        $this->lineID = $lineID;
        return $this;
    }
}
