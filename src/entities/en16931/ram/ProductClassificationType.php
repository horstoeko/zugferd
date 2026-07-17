<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing ProductClassificationType
 *
 * XSD Type: ProductClassificationType
 */
class ProductClassificationType
{

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\CodeType|null $classCode
     */
    private $classCode = null;

    /**
     * Gets as classCode
     *
     * @return \horstoeko\zugferd\entities\en16931\udt\CodeType|null
     */
    public function getClassCode()
    {
        return $this->classCode;
    }

    /**
     * Sets a new classCode
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\CodeType|null $classCode
     * @return self
     */
    public function setClassCode(?\horstoeko\zugferd\entities\en16931\udt\CodeType $classCode = null)
    {
        $this->classCode = $classCode;
        return $this;
    }
}
