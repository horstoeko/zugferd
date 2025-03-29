<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use horstoeko\stringmanagement\PathUtils;
use horstoeko\stringmanagement\StringUtils;

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
     * The number of decimals for measure values
     *
     * @var integer
     */
    protected static $measureDecimals = 2;

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
    protected static $iccProfileFilename = "sRGB2014.icc";

    /**
     * The filename of the XMP meta data
     *
     * @var string
     */
    protected static $xmpMetaDataFilename = "facturx_extension_schema.xmp";

    /**
     * Node paths which present an amount. Used for special amount formatting
     *
     * @var array<string,integer>
     */
    protected static $specialDecimalPlacesMaps = [];

    /**
     * The configured cache directory for the serializer
     *
     * @var string
     */
    protected static $serializerCacheDirectory = "";

    /**
     * Get the number of decimals to use for amount values
     *
     * @return integer
     */
    public static function getAmountDecimals(): int
    {
        return static::$amountDecimals;
    }

    /**
     * Set the number of decimals to use for amount values
     *
     * @param  integer $amountDecimals
     * @return void
     */
    public static function setAmountDecimals(int $amountDecimals): void
    {
        static::$amountDecimals = $amountDecimals;
    }

    /**
     * Get the number of decimals to use for amount values
     *
     * @return integer
     */
    public static function getQuantityDecimals(): int
    {
        return static::$quantityDecimals;
    }

    /**
     * Set the number of decimals to use for quantity values
     *
     * @param  integer $quantityDecimals
     * @return void
     */
    public static function setQuantityDecimals(int $quantityDecimals): void
    {
        static::$quantityDecimals = $quantityDecimals;
    }

    /**
     * Get the number of decimals to use for percent values
     *
     * @return integer
     */
    public static function getPercentDecimals(): int
    {
        return static::$percentDecimals;
    }

    /**
     * Set the number of decimals to use for percent values
     *
     * @param  integer $percentDecimals
     * @return void
     */
    public static function setPercentDecimals(int $percentDecimals): void
    {
        static::$percentDecimals = $percentDecimals;
    }

    /**
     * Get the number of decimals to use for measure values
     *
     * @return integer
     */
    public static function getMeasureDecimals(): int
    {
        return static::$measureDecimals;
    }

    /**
     * Set the number of decimals to use for measure values
     *
     * @param  integer $measureDecimals
     * @return void
     */
    public static function setMeasureDecimals(int $measureDecimals): void
    {
        static::$measureDecimals = $measureDecimals;
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
     * @param  string $xmpMetaDataFilename
     * @return void
     */
    public static function setXmpMetaDataFilename(string $xmpMetaDataFilename): void
    {
        static::$xmpMetaDataFilename = $xmpMetaDataFilename;
    }

    /**
     * Returns a list of node paths which have a special number of decimal places
     *
     * @return array
     */
    public static function getSpecialDecimalPlacesMaps(): array
    {
        return static::$specialDecimalPlacesMaps;
    }

    /**
     * Get a specific map for node paths with a special number of decimal places. If not map
     * is found then the default value is returns
     *
     * @param  string  $nodePath
     * @param  integer $defaultDecimalPlaces
     * @return integer
     */
    public static function getSpecialDecimalPlacesMap(string $nodePath, int $defaultDecimalPlaces): int
    {
        $nodePath = preg_replace('@\[\d+\]@', '', $nodePath);
        return static::$specialDecimalPlacesMaps[$nodePath] ?? $defaultDecimalPlaces;
    }

    /**
     * Update the map of node paths which have a special number of decimal places
     *
     * @param  array $specialDecimalPlacesMaps
     * @return void
     */
    public static function setSpecialDecimalPlacesMaps(array $specialDecimalPlacesMaps): void
    {
        static::$specialDecimalPlacesMaps = $specialDecimalPlacesMaps;
    }

    /**
     * Add a new map for a node path with a special number of decimal places
     *
     * @param  string  $nodePath
     * @param  integer $defaultDecimalPlaces
     * @return void
     */
    public static function addSpecialDecimalPlacesMap(string $nodePath, int $defaultDecimalPlaces): void
    {
        $nodePath = preg_replace('@\[\d+\]@', '', $nodePath);
        static::$specialDecimalPlacesMaps[$nodePath] = $defaultDecimalPlaces;
    }

    /**
     * Set the number of decimals to use for unit single amount (unit prices) values
     *
     * @param  integer $defaultDecimalPlaces
     * @return void
     */
    public static function setUnitAmountDecimals(int $defaultDecimalPlaces): void
    {
        static::addSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', $defaultDecimalPlaces);
        static::addSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:ChargeAmount', $defaultDecimalPlaces);
    }

    /**
     * Set the cache directory for the internal serializer
     *
     * @param  string $serializerCacheDirectoty
     * @return void
     */
    public static function setSerializerCacheDirectory(string $serializerCacheDirectoty): void
    {
        static::$serializerCacheDirectory = $serializerCacheDirectoty;
    }

    /**
     * Returns the cache directory for the internal serializer. This might be empty
     *
     * @return string
     */
    public static function getSerializerCacheDirectory(): string
    {
        return static::$serializerCacheDirectory;
    }

    /**
     * Returns true if a cache directory for the internal serializer is configured, otherwise false
     *
     * @return boolean
     */
    public static function hasSerializerCacheDirectory(): bool
    {
        return StringUtils::stringIsNullOrEmpty(static::$serializerCacheDirectory) === false;
    }

    /**
     * Get root directory
     *
     * @return string
     */
    public static function getRootDirectory(): string
    {
        return PathUtils::combineAllPaths(__DIR__, "..");
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
     * Get the directory where all the stylesheets (XSLT) files are located
     *
     * @return string
     */
    public static function getSchematronDirectory(): string
    {
        return PathUtils::combineAllPaths(static::getSchemaDirectory(), "schematron");
    }

    /**
     * Get the directory where all the stylesheets (XSLT) files are located
     *
     * @return string
     */
    public static function getXsltDirectory(): string
    {
        return PathUtils::combineAllPaths(static::getSchemaDirectory(), "xslt");
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
