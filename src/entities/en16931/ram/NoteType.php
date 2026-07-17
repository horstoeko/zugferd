<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing NoteType
 *
 * XSD Type: NoteType
 */
class NoteType
{

    /**
     * @var string|null $content
     */
    private $content = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\udt\CodeType|null $subjectCode
     */
    private $subjectCode = null;

    /**
     * Gets as content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets a new content
     *
     * @param  string $content
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
     * @return \horstoeko\zugferd\entities\en16931\udt\CodeType|null
     */
    public function getSubjectCode()
    {
        return $this->subjectCode;
    }

    /**
     * Sets a new subjectCode
     *
     * @param  \horstoeko\zugferd\entities\en16931\udt\CodeType|null $subjectCode
     * @return self
     */
    public function setSubjectCode(?\horstoeko\zugferd\entities\en16931\udt\CodeType $subjectCode = null)
    {
        $this->subjectCode = $subjectCode;
        return $this;
    }
}
