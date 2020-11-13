<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\quick;

use DateTime;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\quick\ZugferdQuickDescriptor;

/**
 * Class representing the document descriptor for outgoing documents.
 * Creating them in a simple and common way in EN16931 profile
 * This class is slightly inspired by the invoicedescriptor of the
 * https://github.com/stephanstapel/ZUGFeRD-csharp project
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdQuickDescriptorXRechnung extends ZugferdQuickDescriptor
{
    /**
     * Returns the profile of the descriptor
     *
     * @return integer
     */
    protected static function getProfile(): int
    {
        return ZugferdProfiles::PROFILE_XRECHNUNG;
    }
}
