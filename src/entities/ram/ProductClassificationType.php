<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing ProductClassificationType
 *
 *
 * XSD Type: ProductClassificationType
 */
class ProductClassificationType
{

    /**
     * @property \horstoeko\zugferd\udt\CodeType $classCode
     */
    private $classCode = null;

    /**
     * @property string $className
     */
    private $className = null;

    /**
     * Gets as classCode
     *
     * @return \horstoeko\zugferd\udt\CodeType
     */
    public function getClassCode()
    {
        return $this->classCode;
    }

    /**
     * Sets a new classCode
     *
     * @param \horstoeko\zugferd\udt\CodeType $classCode
     * @return self
     */
    public function setClassCode(\horstoeko\zugferd\udt\CodeType $classCode)
    {
        $this->classCode = $classCode;
        return $this;
    }

    /**
     * Gets as className
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Sets a new className
     *
     * @param string $className
     * @return self
     */
    public function setClassName($className)
    {
        $this->className = $className;
        return $this;
    }


}

