<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use Throwable;
use horstoeko\zugferd\ZugferdProfileResolver;
use horstoeko\zugferd\ZugferdDocumentPdfBuilderAbstract;
use horstoeko\zugferd\exception\ZugferdUnknownProfileException;
use horstoeko\zugferd\exception\ZugferdFileNotReadableException;
use horstoeko\zugferd\exception\ZugferdUnknownXmlContentException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;

/**
 * Class representing the facillity adding existing XML data (file or data-string)
 * to an existing PDF with conversion to PDF/A
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentPdfMerger extends ZugferdDocumentPdfBuilderAbstract
{
    /**
     * Internal reference to the xml data (file or data-string)
     *
     * @var string
     */
    private $xmlDataOrFilename = "";

    /**
     * Cached XML data
     *
     * @var string
     */
    private $xmlDataCache = "";

    /**
     * Constructor
     *
     * @param string $xmlDataOrFilename
     * The XML data as a string or the full qualified path to an XML-File
     * containing the XML-data
     * @param string $pdfData
     * The full filename or a string containing the binary pdf data. This
     * is the original PDF (e.g. created by a ERP system)
     */
    public function __construct(string $xmlDataOrFilename, string $pdfData)
    {
        $this->xmlDataOrFilename = $xmlDataOrFilename;

        parent::__construct($pdfData);
    }

    /**
     * @inheritDoc
     */
    protected function getXmlContent(): string
    {
        if ($this->xmlDataCache) {
            return $this->xmlDataCache;
        }

        if ($this->xmlDataIsFile()) {
            $xmlContent = file_get_contents($this->xmlDataOrFilename);
            if ($xmlContent === false) {
                throw new ZugferdFileNotReadableException($this->xmlDataOrFilename);
            }
        } else {
            $xmlContent = $this->xmlDataOrFilename;
        }

        $this->xmlDataCache = $xmlContent;

        return $xmlContent;
    }

    /**
     * @inheritDoc
     */
    protected function getXmlAttachmentFilename(): string
    {
        return $this->getProfileDefinitionParameter('attachmentfilename');
    }

    /**
     * @inheritDoc
     */
    protected function getXmlAttachmentXmpName(): string
    {
        return $this->getProfileDefinitionParameter("xmpname");
    }

    /**
     * @inheritDoc
     */
    protected function getXmlAttachmentXmpVersion(): string
    {
        return $this->getProfileDefinitionParameter("xmpversion");
    }

    /**
     * Returns true if the submitted $xmlDataOrFilename is a valid file.
     * Otherwise it will return false
     *
     * @return boolean
     */
    protected function xmlDataIsFile(): bool
    {
        try {
            return @is_file($this->xmlDataOrFilename);
        } catch (Throwable $throwable) {
            return false;
        }
    }

    /**
     * Guess the profile type of the readden xml document
     *
     * @return array
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     */
    private function getProfileDefinition(): array
    {
        return ZugferdProfileResolver::resolveProfileDef($this->getXmlContent());
    }

    /**
     * Get a parameter from profile definition
     *
     * @param  string $parameterName
     * @return mixed
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     */
    private function getProfileDefinitionParameter(string $parameterName)
    {
        $profileDefinition = $this->getProfileDefinition();

        if (isset($profileDefinition[$parameterName])) {
            return $profileDefinition[$parameterName];
        }

        throw new ZugferdUnknownProfileParameterException($parameterName);
    }
}
