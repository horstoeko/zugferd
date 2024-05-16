<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\exception;

use Exception;

/**
 * Class representing an exception for unknown profile
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdUnknownProfileException extends Exception
{
    /**
     * The context of the type element
     *
     * @var string
     */
    private $contextElement = "";

    /**
     * Constructor
     *
     * @param string $contextElement
     */
    public function __construct(string $contextElement)
    {
        $this->contextElement = $contextElement;

        parent::__construct($this->buildMessage());
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * Build the message
     *
     * @return string
     */
    private function buildMessage(): string
    {
        return sprintf("A context parameter was found, but the content of \"%s\" is not a valid profile", $this->contextElement);
    }
}
