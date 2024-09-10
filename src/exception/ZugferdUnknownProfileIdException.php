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
 * Class representing an exception for unknown profile id
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdUnknownProfileIdException extends Exception
{
    /**
     * The context of the type element
     *
     * @var integer
     */
    private $profileId = 0;

    /**
     * Constructor
     *
     * @param integer $profileId
     */
    public function __construct(int $profileId)
    {
        $this->profileId = $profileId;

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
        return sprintf("The profile id %s is uknown", $this->profileId);
    }
}
