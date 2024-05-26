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
     * @var array
     */
    private static $amountDecimals = [];

    /**
     * The number of decimals for quantity values
     *
     * @var array
     */
    private static $quantityDecimals = [];

    /**
     * The number of decimals for percent values
     *
     * @var array
     */
    private static $percentDecimals = [];

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
     * The filename of the XMP meta data
     *
     * @var string
     */
    protected static $xmpMetaDataFilename = "facturx_extension_schema.xmp";

    /**
     * Get the number of decimals to use for amount values
     *
     * @param  string|null $tagName  The tag name, e.g. "ram:ChargeAmount", or null for the rest
     * @return integer
     */
    public static function getAmountDecimals(?string $tagName=null): int
    {
        return static::$amountDecimals[$tagName??""] ?? 2;
    }

    /**
     * Set the number of decimals to use for amount values
     *
     * @param  integer $amountDecimals
     * @param  string|null $tagName  The tag name, e.g. "ram:ChargeAmount", or null for the rest
     * @return void
     */
    public static function setAmountDecimals(int $amountDecimals, ?string $tagName=null): void
    {
        static::$amountDecimals[$tagName??""] = $amountDecimals;
    }

    /**
     * Get the number of decimals to use for amount values
     *
     * @param  string|null $tagName  The tag name, e.g. "ram:ChargeAmount", or null for the rest
     * @return integer
     */
    public static function getQuantityDecimals(?string $tagName=null): int
    {
        return static::$quantityDecimals[$tagName??""] ?? 2;
    }

    /**
     * Set the number of decimals to use for quantity values
     *
     * @param  integer $quantityDecimals
     * @param  string|null $tagName  The tag name, e.g. "ram:ChargeAmount", or null for the rest
     * @return void
     */
    public static function setQuantityDecimals(int $quantityDecimals, ?string $tagName=null): void
    {
        static::$quantityDecimals[$tagName??""] = $quantityDecimals;
    }

    /**
     * Get the number of decimals to use for percent values
     *
     * @param  string|null $tagName  The tag name, e.g. "ram:ChargeAmount", or null for the rest
     * @return integer
     */
    public static function getPercentDecimals(?string $tagName=null): int
    {
        return static::$percentDecimals[$tagName??""] ?? 2;
    }

    /**
     * Set the number of decimals to use for percent values
     *
     * @param  integer $percentDecimals
     * @param  string|null $tagName  The tag name, e.g. "ram:ChargeAmount", or null for the rest
     * @return void
     */
    public static function setPercentDecimals(int $percentDecimals, ?string $tagName=null): void
    {
        static::$percentDecimals[$tagName??""] = $percentDecimals;
    }

    /**
     * Get the decimal separator
     *
     * @return string
     */
    public static function getDecimalSeparator(): string
    {
        return static::$decimalSeparator;
    }

    /**
     * Set the decimal separator
     *
     * @param  string $decimalSeparator
     * @return void
     */
    public static function setDecimalSeparator(string $decimalSeparator): void
    {
        static::$decimalSeparator = $decimalSeparator;
    }

    /**
     * Get the thousands separator
     *
     * @return string
     */
    public static function getThousandsSeparator(): string
    {
        return static::$thousandsSeparator;
    }

    /**
     * Set the thousands separator
     *
     * @param  string $thousandsSeparator
     * @return void
     */
    public static function setThousandsSeparator(string $thousandsSeparator): void
    {
        static::$thousandsSeparator = $thousandsSeparator;
    }

    /**
     * Get the filename of the ICC Profile
     *
     * @return string
     */
    public static function getIccProfileFilename(): string
    {
        return static::$iccProfileFilename;
    }

    /**
     * Set the filename of the ICC Profile
     *
     * @param  string $iccProfileFilename
     * @return void
     */
    public static function setIccProfileFilename(string $iccProfileFilename): void
    {
        static::$iccProfileFilename = $iccProfileFilename;
    }

    /**
     * Get the filename for the XMP meta data
     *
     * @return string
     */
    public static function getXmpMetaDataFilename(): string
    {
        return static::$xmpMetaDataFilename;
    }

    /**
     * Set the filename for the XMP meta data
     *
     * @param string $xmpMetaDataFilename
     * @return void
     */
    public static function setXmpMetaDataFilename(string $xmpMetaDataFilename): void
    {
        static::$xmpMetaDataFilename = $xmpMetaDataFilename;
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
        return PathUtils::combineAllPaths(static::getRootDirectory(), "src");
    }

    /**
     * Get the directory where all the assets are stored
     *
     * @return string
     */
    public static function getAssetDirectory(): string
    {
        return PathUtils::combineAllPaths(static::getSourceDirectory(), "assets");
    }

    /**
     * Get the directory where all the assets are stored
     *
     * @return string
     */
    public static function getYamlDirectory(): string
    {
        return PathUtils::combineAllPaths(static::getSourceDirectory(), "yaml");
    }

    /**
     * Get the directory where all the validation files are located
     *
     * @return string
     */
    public static function getValidationDirectory(): string
    {
        return PathUtils::combineAllPaths(static::getSourceDirectory(), "validation");
    }

    /**
     * Get the directory where all the schema (XSD) files are located
     *
     * @return string
     */
    public static function getSchemaDirectory(): string
    {
        return PathUtils::combineAllPaths(static::getSourceDirectory(), "schema");
    }

    /**
     * Get the full filename of the ICC profile to use
     *
     * @return string
     */
    public static function getFullIccProfileFilename(): string
    {
        return PathUtils::combinePathWithFile(static::getAssetDirectory(), static::$iccProfileFilename);
    }

    /**
     * Get the full filename containg the XNP information to user
     *
     * @return string
     */
    public static function getFullXmpMetaDataFilename(): string
    {
        return PathUtils::combinePathWithFile(static::getAssetDirectory(), static::$xmpMetaDataFilename);
    }
}
