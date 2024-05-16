<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\exception;

use Exception;
use Throwable;

/**
 * Class representing an exception for unknown profile
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdUnknownXmlContentException extends Exception
{
    /**
     * Constructor
     */
    public function __construct()
    {
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
        return "The XML does not match the requirements for an XML in CII-Syntax";
    }
}
