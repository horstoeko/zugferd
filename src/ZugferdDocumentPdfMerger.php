<?php

declare(strict_types=1);

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use horstoeko\zugferd\exception\ZugferdFileNotReadableException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;
use horstoeko\zugferd\exception\ZugferdUnknownXmlContentException;

/**
 * Class representing the facillity adding existing XML data (file or data-string)
 * to an existing PDF with conversion to PDF/A
 *
 * @category Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
 *
 * @phpstan-import-type ZugferdProfileDefinition from ZugferdProfiles
 */
class ZugferdDocumentPdfMerger extends ZugferdDocumentPdfBuilderAbstract
{
    /**
     * Internal reference to the xml data (file or data-string)
     *
     * @var string
     */
    private $xmlDataOrFilename = '';

    /**
     * Cached XML data
     *
     * @var string
     */
    private $xmlDataCache = '';

    /**
     * Constructor
     *
     * @param string $xmlDataOrFilename
     *                                  The XML data as a string or the full qualified path to an XML-File
     *                                  containing the XML-data
     * @param string $pdfData
     *                                  The full filename or a string containing the binary pdf data. This
     *                                  is the original PDF (e.g. created by a ERP system)
     */
    public function __construct(string $xmlDataOrFilename, string $pdfData)
    {
        $this->xmlDataOrFilename = $xmlDataOrFilename;

        parent::__construct($pdfData);
    }

    /**
     * {@inheritDoc}
     *
     * @throws ZugferdFileNotReadableException
     */
    protected function getXmlContent(): string
    {
        if ('' !== $this->xmlDataCache) {
            return $this->xmlDataCache;
        }

        if ($this->xmlDataIsFile()) {
            $xmlContent = file_get_contents($this->xmlDataOrFilename);

            if (false === $xmlContent) {
                throw new ZugferdFileNotReadableException($this->xmlDataOrFilename);
            }
        } else {
            $xmlContent = $this->xmlDataOrFilename;
        }

        $this->xmlDataCache = $xmlContent;

        return $xmlContent;
    }

    /**
     * {@inheritDoc}
     *
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    protected function getXmlAttachmentFilename(): string
    {
        return $this->getProfileDefinitionParameter('attachmentfilename');
    }

    /**
     * {@inheritDoc}
     *
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    protected function getXmlAttachmentXmpName(): string
    {
        return $this->getProfileDefinitionParameter('xmpname');
    }

    /**
     * {@inheritDoc}
     *
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    protected function getXmlAttachmentXmpVersion(): string
    {
        return $this->getProfileDefinitionParameter('xmpversion');
    }

    /**
     * Returns true if the submitted $xmlDataOrFilename is a valid file.
     * Otherwise it will return false
     *
     * @return bool
     */
    protected function xmlDataIsFile(): bool
    {
        return @is_file($this->xmlDataOrFilename);
    }

    /**
     * Guess the profile type of the readden xml document
     *
     * @return ZugferdProfileDefinition
     *
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownXmlContentException
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
     *
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
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
