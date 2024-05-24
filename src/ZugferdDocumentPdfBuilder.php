<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use horstoeko\zugferd\ZugferdDocumentPdfBuilderAbstract;
use horstoeko\zugferd\ZugferdDocumentBuilder;

/**
 * Class representing the facillity adding XML data from ZugferdDocumentBuilder
 * to an existing PDF with conversion to PDF/A
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentPdfBuilder extends ZugferdDocumentPdfBuilderAbstract
{
    /**
     * Internal reference to the xml builder instance
     *
     * @var ZugferdDocumentBuilder
     */
    private $documentBuilder = null;

    /**
     * Cached XML data
     *
     * @var string
     */
    private $xmlDataCache = "";

    /**
     * @see self::__construct
     */
    public static function fromPdfFile(ZugferdDocumentBuilder $documentBuilder, string $pdfData): self
    {
        if (!is_file($pdfData)) {
            throw new \InvalidArgumentException("The given PDF file does not exist.");
        }
        return new self($documentBuilder, $pdfData);
    }
    
    /**
     * Constructor
     *
     * @param ZugferdDocumentBuilder $documentBuilder
     * The instance of the document builder. Needed to get the XML data
     * @param string                 $pdfData
     * The full filename or a string containing the binary pdf data. This
     * is the original PDF (e.g. created by a ERP system)
     */
    public function __construct(ZugferdDocumentBuilder $documentBuilder, string $pdfData)
    {
        $this->documentBuilder = $documentBuilder;

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

        $this->xmlDataCache = $this->documentBuilder->getContentAsDomDocument()->saveXML();

        return $this->xmlDataCache;
    }

    /**
     * @inheritDoc
     */
    protected function getXmlAttachmentFilename(): string
    {
        return $this->documentBuilder->getProfileDefinitionParameter('attachmentfilename');
    }

    /**
     * @inheritDoc
     */
    protected function getXmlAttachmentXmpName(): string
    {
        return $this->documentBuilder->getProfileDefinitionParameter("xmpname");
    }
}
