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
 * Class representing an exception for unsupported mimetype
 *
 * @category Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
 */
class ZugferdUnsupportedMimetype extends ZugferdBaseException
{
    /**
     * Constructor
     *
     * @param null|Throwable $previous
     */
    public function __construct(string $mimetype, ?Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Mimetype %s is not supported', $mimetype),
            ZugferdExceptionCodes::UNSUPPORTEDMIMETYPE,
            $previous,
        );
    }
}
