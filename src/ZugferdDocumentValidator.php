<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use horstoeko\stringmanagement\PathUtils;
use horstoeko\zugferd\ZugferdSettings;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class representing the document validator for incoming documents
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentValidator
{
    /**
     * The invoice document reference
     */
    private $document;

    /**
     * The validator instance
     */
    private $validator;

    /**
     * Constructor
     *
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
        return $this->validator->validate($this->getDocumentInvoiceObject(), null, ['xsd_rules']);
    }

    /**
     * Initialize the internal validator object
     *
     * @return void
     */
    private function initValidator(): void
    {
        $validatorBuilder = Validation::createValidatorBuilder();

        $validatorYamlFiles = PathUtils::combinePathWithFile(
            PathUtils::combineAllPaths(
                ZugferdSettings::getValidationDirectory(),
                $this->document->getProfileDefinitionParameter('name')
            ),
            '*.yml'
        );

        $validatorYamlFiles = $this->globRecursive($validatorYamlFiles);

        foreach ($validatorYamlFiles as $validatorYamlFile) {
            $validatorBuilder->addYamlMapping($validatorYamlFile);
        }

        $this->validator = $validatorBuilder->getValidator();
    }

    /**
     * Helper for find all files by pattern
     *
     * @param  string  $pattern
     * @param  integer $flags
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

    /**
     * Returns the internal invoice object from the document
     *
     * @return object
     */
    private function getDocumentInvoiceObject()
    {
        $reflector = new \ReflectionClass($this->document);

        $method = $reflector->getMethod('getInvoiceObject');
        $method->setAccessible(true);

        return $method->invoke($this->document);
    }
}
