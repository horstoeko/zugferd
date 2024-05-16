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
 * Class representing an exception for missing a file
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdFileNotFoundException extends Exception
{
    /**
     * The context of the type element
     *
     * @var string
     */
    private $filePath = "";

    /**
     * Constructor
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;

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
        return sprintf("The filer %s is missing", $this->filePath);
    }
}
