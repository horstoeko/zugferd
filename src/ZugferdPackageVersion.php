<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use Composer\InstalledVersions as ComposerInstalledVersions;
use OutOfBoundsException;

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
final class ZugferdPackageVersion
{
    /**
     * Get the installed version of this library
     *
     * @return string
     */
    public static function getInstalledVersion(): string
    {
        try {
            return ComposerInstalledVersions::getVersion('horstoeko/zugferd') ?? self::getDefaultVersion();
        } catch (OutOfBoundsException $outOfBoundsException) {
            return self::getDefaultVersion();
        }
    }

    /**
     * Return the default version used for this package, when no installation was found
     *
     * @return string
     */
    private static function getDefaultVersion(): string
    {
        return "1.0.x";
    }
}
