<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing NoteType
 *
 *
 * XSD Type: NoteType
 */
class NoteType
{

    /**
     * @property \horstoeko\zugferd\udt\CodeType $contentCode
     */
    private $contentCode = null;

    /**
     * @property string $content
     */
    private $content = null;

    /**
     * @property \horstoeko\zugferd\udt\CodeType $subjectCode
     */
    private $subjectCode = null;

    /**
     * Gets as contentCode
     *
     * @return \horstoeko\zugferd\udt\CodeType
     */
    public function getContentCode()
    {
        return $this->contentCode;
    }

    /**
     * Sets a new contentCode
     *
     * @param \horstoeko\zugferd\udt\CodeType $contentCode
     * @return self
     */
    public function setContentCode(\horstoeko\zugferd\udt\CodeType $contentCode)
    {
        $this->contentCode = $contentCode;
        return $this;
    }

    /**
     * Gets as content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets a new content
     *
     * @param string $content
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Gets as subjectCode
     *
     * @return \horstoeko\zugferd\udt\CodeType
     */
    public function getSubjectCode()
    {
        return $this->subjectCode;
    }

    /**
     * Sets a new subjectCode
     *
     * @param \horstoeko\zugferd\udt\CodeType $subjectCode
     * @return self
     */
    public function setSubjectCode(\horstoeko\zugferd\udt\CodeType $subjectCode)
    {
        $this->subjectCode = $subjectCode;
        return $this;
    }


}

