<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\exception;

/**
 * Class representing the exception when a validation of the XML data failed
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdValidationFailed extends \Exception
{
    private $errorList = [];

    /**
     * Constructur
     *
     * @param array $errorList
     */
    public function __construct(array $errorList = [])
    {
        $this->errorList = $errorList;
        parent::__construct("Validation failed.");
    }

    /**
     * Returns the list of validation errors
     *
     * @return array
     */
    public function getValidationErrorList(): array
    {
        return $this->errorList;
    }
}
