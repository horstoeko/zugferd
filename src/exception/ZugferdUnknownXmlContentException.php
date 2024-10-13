<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\exception;

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
class ZugferdUnknownXmlContentException extends ZugferdBaseException
{
    /**
     * Constructor
     *
     * @param Throwable|null $previous
     */
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("The XML does not match the requirements for an XML in CII-Syntax", ZugferdExceptionCodes::UNKNOWNSYNTAX, $previous);
    }
}
