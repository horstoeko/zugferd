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
 * @inheritDoc
 */
class ZugferdQuickDescriptorEn16931 extends ZugferdQuickDescriptor
{
    /**
     *@inheritDoc
     */
    protected static function getProfile(): int
    {
        return ZugferdProfiles::PROFILE_EN16931;
    }
}
