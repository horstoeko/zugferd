<?php

namespace horstoeko\zugferd;

use \Symfony\Component\Validator\Validation;
use \Symfony\Component\Validator\ConstraintViolationListInterface;
use \Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Class representing the document validator for incoming documents
 */
class ZugferdDocumentValidator
{
    /**
     * The invoice document reference
     *
     * @var ZugferdDocument
     */
    private $document;

    /**
     * The validator instance
     *
     * @var RecursiveValidator;
     */
    private $validator = null;

    /**
     * Constructor
     *
     * @codeCoverageIgnore
     * @param ZugferdDocument $document
     */
    public function __construct(ZugferdDocument $document)
    {
        $this->document = $document;
        $this->initValidator();
    }

    /**
     * Perform the validation of the document
     *
     * @return ConstraintViolationListInterface
     */
    public function validateDocument(): ConstraintViolationListInterface
    {
        return $this->validator->validate($this->document->getInvoiceObject(), null, ['xsd_rules']);
    }

    /**
     * Initialize the internal validator object
     *
     * @codeCoverageIgnore
     * @return void
     */
    private function initValidator(): void
    {
        $validatorBuilder = Validation::createValidatorBuilder();
        $dirname = dirname(__FILE__) . '/validation/' . $this->document->profiledef['name'] . '/*.yml';
        $files = $this->globRecursive($dirname);

        foreach ($files as $file) {
            $validatorBuilder->addYamlMapping($file);
        }

        $this->validator = $validatorBuilder->getValidator();
    }

    /**
     * Helper for find all files by pattern
     *
     * @codeCoverageIgnore
     * @param string $pattern
     * @param integer $flags
     * @return array
     */
    private function globRecursive(string $pattern, int $flags = 0): array
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, $this->globRecursive($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }
}
