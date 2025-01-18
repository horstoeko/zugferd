<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\exception;

/**
 * Class representing the internal coes for Order-X-Exceptions
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdExceptionCodes
{
    public const CANNOTFINDPROFILESTRING = -1101;

    public const UNKNOWNPROFILE = -1102;

    public const MIMETYPENOTSUPPORTED = -1103;

    public const UNKNOWNDATEFORMAT = -1104;

    public const NOVALIDATTACHMENTFOUNDINPDF = -1105;

    public const UNKNOWNPROFILEPARAMETER = -1106;

    public const UNKNOWNSYNTAX = -1107;

    public const UNKNOWNMIMETYPE = -1108;

    public const UNSUPPORTEDMIMETYPE = -1109;

    public const NOPDFATTACHMENTFOUND = -1110;

    public const FILENOTFOUND = -2000;

    public const FILENOTREADABLE = -2001;

    public const INVALIDARGUMENT = -3000;
}
