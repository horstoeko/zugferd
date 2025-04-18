<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

/**
 * Class representing the information source of the used specification versions
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdSpecificationVersions
{
    /**
     * The latest ZUGFeRD version used
     */
    public const VERSION_ZUGFERD = "2.3.2";

    /**
     * The latest Factur-X version used
     */
    public const VERSION_FACTURX = "1.07.2";

    /**
     * The latest XRechnung version used
     */
    public const VERSION_XRECHNUNG = "3.0.2";
}
