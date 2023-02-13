<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use horstoeko\stringmanagement\PathUtils;

/**
 * Class representing the general settings
 *
 * @category Zugferd
 * @package  zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdSettings
{
    /**
     * The number of decimals for amount values
     *
     * @var integer
     */
    protected static $amountDecimals = 2;

    /**
     * The number of decimals for quantity values
     *
     * @var integer
     */
    protected static $quantityDecimals = 2;

    /**
     * The number of decimals for percent values
     *
     * @var integer
     */
    protected static $percentDecimals = 2;

    /**
     * The decimal separator
     *
     * @var string
     */
    protected static $decimalSeparator = ".";

    /**
     * The thousands seperator
     *
     * @var string
     */
    protected static $thousandsSeparator = "";

    /**
     * The filename of a ICC profile
     *
     * @var string
     */
    protected static $iccProfileFilename = "sRGB_v4_ICC.icc";

    /**
     * Get the number of decimals to use for amount values
     *
     * @return integer
     */
    public static function getAmountDecimals(): int
    {
        return self::$amountDecimals;
    }

    /**
     * Set the number of decimals to use for amount values
     *
     * @param  integer $amountDecimals
     * @return void
     */
    public static function setAmountDecimals(int $amountDecimals): void
    {
        self::$amountDecimals = $amountDecimals;
    }

    /**
     * Get the number of decimals to use for amount values
     *
     * @return integer
     */
    public static function getQuantityDecimals(): int
    {
        return self::$quantityDecimals;
    }

    /**
     * Set the number of decimals to use for quantity values
     *
     * @param  integer $quantityDecimals
     * @return void
     */
    public static function setQuantityDecimals(int $quantityDecimals): void
    {
        self::$quantityDecimals = $quantityDecimals;
    }

    /**
     * Get the number of decimals to use for percent values
     *
     * @return integer
     */
    public static function getPercentDecimals(): int
    {
        return self::$percentDecimals;
    }

    /**
     * Set the number of decimals to use for percent values
     *
     * @param  integer $percentDecimals
     * @return void
     */
    public static function setPercentDecimals(int $percentDecimals): void
    {
        self::$percentDecimals = $percentDecimals;
    }

    /**
     * Get the decimal separator
     *
     * @return string
     */
    public static function getDecimalSeparator(): string
    {
        return self::$decimalSeparator;
    }

    /**
     * Set the decimal separator
     *
     * @param  string $decimalSeparator
     * @return void
     */
    public static function setDecimalSeparator(string $decimalSeparator): void
    {
        self::$decimalSeparator = $decimalSeparator;
    }

    /**
     * Get the thousands separator
     *
     * @return string
     */
    public static function getThousandsSeparator(): string
    {
        return self::$thousandsSeparator;
    }

    /**
     * Set the thousands separator
     *
     * @param  string $thousandsSeparator
     * @return void
     */
    public static function setThousandsSeparator(string $thousandsSeparator): void
    {
        self::$thousandsSeparator = $thousandsSeparator;
    }

    /**
     * Get the filename of the ICC Profile
     *
     * @return string
     */
    public static function getIccProfileFilename(): string
    {
        return self::$iccProfileFilename;
    }

    /**
     * Set the filename of the ICC Profile
     *
     * @param  string $iccProfileFilename
     * @return void
     */
    public static function setIccProfileFilename(string $iccProfileFilename): void
    {
        self::$iccProfileFilename = $iccProfileFilename;
    }

    /**
     * Get root directory
     *
     * @return string
     */
    public static function getRootDirectory(): string
    {
        return PathUtils::combineAllPaths(dirname(__FILE__), "..");
    }

    /**
     * Get the directory where all the sources are stored
     *
     * @return string
     */
    public static function getSourceDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getRootDirectory(), "src");
    }

    /**
     * Get the directory where all the assets are stored
     *
     * @return string
     */
    public static function getAssetDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSourceDirectory(), "assets");
    }

    /**
     * Get the directory where all the assets are stored
     *
     * @return string
     */
    public static function getYamlDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSourceDirectory(), "yaml");
    }

    /**
     * Get the directory where all the validation files are located
     *
     * @return string
     */
    public static function getValidationDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSourceDirectory(), "validation");
    }

    /**
     * Get the full filename of the ICC profile to use
     *
     * @return string
     */
    public static function getFullIccProfileFilename(): string
    {
        return PathUtils::combinePathWithFile(self::getAssetDirectory(), self::$iccProfileFilename);
    }
}
