<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use Exception;
use horstoeko\zugferd\ZugferdDocumentPdfBuilderAbstract;
use horstoeko\zugferd\ZugferdProfileResolver;

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
                throw new Exception('Could read XML file...');
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
        return $this->getProfileDefinition()['attachmentfilename'];
    }

    /**
     * @inheritDoc
     */
    protected function getXmlAttachmentXmpName(): string
    {
        return $this->getProfileDefinition()["xmpname"];
    }

    /**
     * Returns true if the submitted $xmlDataOrFilename is a valid file.
     * Otherwise it will return false
     *
     * @return boolean
     */
    private function xmlDataIsFile(): bool
    {
        try {
            return @is_file($this->xmlDataOrFilename);
        } catch (\TypeError $ex) {
            return false;
        }
    }

    /**
     * Guess the profile type of the readden xml document
     *
     * @codeCoverageIgnore
     *
     * @return array
     * @throws Exception
     */
    private function getProfileDefinition(): array
    {
        return ZugferdProfileResolver::resolveProfileDef($this->getXmlContent());
    }
}
