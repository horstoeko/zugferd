<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing DocumentLineDocumentType
 *
 *
 * XSD Type: DocumentLineDocumentType
 */
class DocumentLineDocumentType
{

    /**
     * @var \horstoeko\zugferd\basic\udt\IDType $lineID
     */
    private $lineID = null;

    /**
     * Gets as lineID
     *
     * @return \horstoeko\zugferd\basic\udt\IDType
     */
    public function getLineID()
    {
        return $this->lineID;
    }

    /**
     * Sets a new lineID
     *
     * @param \horstoeko\zugferd\basic\udt\IDType $lineID
     * @return self
     */
    public function setLineID(\horstoeko\zugferd\basic\udt\IDType $lineID)
    {
        $this->lineID = $lineID;
        return $this;
    }


}

