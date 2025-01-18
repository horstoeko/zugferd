<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use DOMDocument;
use Exception;
use LibXMLError;
use Throwable;
use horstoeko\stringmanagement\PathUtils;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\ZugferdDocument;
use horstoeko\zugferd\ZugferdSettings;

/**
 * Class representing the validator against XSD for documents
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdXsdValidator
{
    /**
     * The invoice document reference
     *
     * @var ZugferdDocument
     */
    private $document;

    /**
     * Internal error bag
     *
     * @var array
     */
    private $errorBag = [];

    /**
     * Constructor
     *
     * @param ZugferdDocument $document
     */
    public function __construct(ZugferdDocument $document)
    {
        $this->document = $document;
    }

    /**
     * Perform validation of document
     *
     * @return ZugferdXsdValidator
     */
    public function validate(): ZugferdXsdValidator
    {
        $this->clearErrorBag();
        $this->initLibXml();

        try {
            if (!$this->getDocumentContentAsDomDocument()->schemaValidate($this->getDocumentXsdFilename())) {
                $this->pushLibXmlErrorsToErrorBag();
            }
        } catch (Exception $exception) {
            $this->addToErrorBag($exception);
        } finally {
            $this->finalizeLibXml();
        }

        return $this;
    }

    /**
     * Returns true if validation passed otherwise false
     *
     * @deprecated 1.0.65 Use hasNoValidationErrors instead
     * @return     boolean
     */
    public function validationPased(): bool
    {
        return $this->errorBag === [];
    }

    /**
     * Returns true if validation failed otherwise false
     *
     * @deprecated 1.0.65 Use hasValidationErrors instead
     * @return     boolean
     */
    public function validationFailed(): bool
    {
        return !$this->validationPased();
    }

    /**
     * Returns true if validation passed otherwise false
     *
     * @return boolean
     */
    public function hasNoValidationErrors(): bool
    {
        return $this->errorBag === [];
    }

    /**
     * Returns true if validation errors are present otherwise false
     *
     * @return boolean
     */
    public function hasValidationErrors(): bool
    {
        return !$this->hasNoValidationErrors();
    }

    /**
     * Returns an array of all validation errors
     *
     * @return array
     */
    public function validationErrors(): array
    {
        return $this->errorBag;
    }

    /**
     * Initialize LibXML
     *
     * @return void
     */
    private function initLibXml(): void
    {
        libxml_use_internal_errors(true);
    }

    /**
     * Finalize LibXML
     *
     * @return void
     */
    private function finalizeLibXml(): void
    {
        libxml_clear_errors();
        libxml_use_internal_errors(false);
    }

    /**
     * Get the content of the document
     *
     * @return string
     */
    private function getDocumentContent(): string
    {
        return $this->document->serializeAsXml();
    }

    /**
     * Get the content of the document as a DOMDocument
     *
     * @return DOMDocument
     */
    private function getDocumentContentAsDomDocument(): DOMDocument
    {
        $doc = new DOMDocument();
        $doc->loadXML($this->getDocumentContent());

        return $doc;
    }

    /**
     * Get the XSD file (schema definition) for the document
     *
     * @return string
     */
    private function getDocumentXsdFilename(): string
    {
        $xsdFilename = PathUtils::combineAllPaths(
            ZugferdSettings::getSchemaDirectory(),
            $this->document->getProfileDefinitionParameter('xsdfilename')
        );

        if (!file_exists($xsdFilename)) {
            throw new ZugferdFileNotFoundException($xsdFilename);
        }

        return $xsdFilename;
    }

    /**
     * Clear the internal error bag
     *
     * @return void
     */
    private function clearErrorBag(): void
    {
        $this->errorBag = [];
    }

    /**
     * Add message to error bag
     *
     * @param  string|Exception|Throwable|LibXMLError $error
     * @return void
     */
    private function addToErrorBag($error): void
    {
        if (is_string($error)) {
            $this->errorBag[] = $error;
        } elseif ($error instanceof Exception) {
            $this->errorBag[] = $error->getMessage();
        } elseif ($error instanceof Throwable) {
            $this->errorBag[] = $error->getMessage();
        } elseif ($error instanceof LibXMLError) {
            $this->errorBag[] = sprintf('[line %d] %s : %s', $error->line, $error->code, $error->message);
        }
    }

    /**
     * Pushes validation errors to error bag
     *
     * @return void
     */
    private function pushLibXmlErrorsToErrorBag(): void
    {
        foreach (libxml_get_errors() as $xmlError) {
            $this->addToErrorBag($xmlError);
        }
    }
}
