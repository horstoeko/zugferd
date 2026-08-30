<?php

declare(strict_types=1);

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use horstoeko\stringmanagement\PathUtils;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class representing the document validator for incoming documents
 *
 * @category Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
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
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Constructor
     *
     * @param ZugferdDocument $document
     *
     * @throws ZugferdUnknownProfileParameterException
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
     *
     * @throws ZugferdUnknownProfileParameterException
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
     * @param  string             $pattern
     * @param  int                $flags
     * @return array<int, string>
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
        return $this->document->getInvoiceObject();
    }
}
