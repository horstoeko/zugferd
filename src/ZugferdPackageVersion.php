<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use \Composer\InstalledVersions as ComposerInstalledVersions;

/**
 * Class representing some tools for getting the package version
 * of this package
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdPackageVersion
{
    public static function getInstalledVersion(): string
    {
        return ComposerInstalledVersions::getVersion('horstoeko/zugferd');
    }
}
