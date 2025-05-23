<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing NoteType
 *
 * XSD Type: NoteType
 */
class NoteType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\CodeType $contentCode
     */
    private $contentCode = null;

    /**
     * @var string $content
     */
    private $content = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\CodeType $subjectCode
     */
    private $subjectCode = null;

    /**
     * Gets as contentCode
     *
     * @return \horstoeko\zugferd\entities\extended\udt\CodeType
     */
    public function getContentCode()
    {
        return $this->contentCode;
    }

    /**
     * Sets a new contentCode
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\CodeType $contentCode
     * @return self
     */
    public function setContentCode(?\horstoeko\zugferd\entities\extended\udt\CodeType $contentCode = null)
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
     * @return \horstoeko\zugferd\entities\extended\udt\CodeType
     */
    public function getSubjectCode()
    {
        return $this->subjectCode;
    }

    /**
     * Sets a new subjectCode
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\CodeType $subjectCode
     * @return self
     */
    public function setSubjectCode(?\horstoeko\zugferd\entities\extended\udt\CodeType $subjectCode = null)
    {
        $this->subjectCode = $subjectCode;
        return $this;
    }
}
