<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\quick;

use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\quick\ZugferdQuickDescriptor;

/**
 * Class representing the document descriptor for outgoing documents in EXTENDED profile
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdQuickDescriptorExtended extends ZugferdQuickDescriptor
{
    /**
     * @inheritDoc
     */
    protected static function getProfile(): int
    {
        return ZugferdProfiles::PROFILE_EXTENDED;
    }
}
