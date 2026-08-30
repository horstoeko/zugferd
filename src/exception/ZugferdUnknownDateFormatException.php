<?php

declare(strict_types=1);

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\exception;

use Throwable;

/**
 * Class representing an exception for unknown date formates
 *
 * @category Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
 */
class ZugferdUnknownDateFormatException extends ZugferdBaseException
{
    public function __construct(string $dateFormatCode, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Invalid date format %s', $dateFormatCode), ZugferdExceptionCodes::UNKNOWNDATEFORMAT, $previous);
    }
}
