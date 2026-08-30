<?php

declare(strict_types=1);

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
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
 */
class ZugferdSettings
{
    /**
     * The number of decimals for amount values
     *
     * @var int
     */
    protected static $amountDecimals = 2;

    /**
     * The number of decimals for quantity values
     *
     * @var int
     */
    protected static $quantityDecimals = 2;

    /**
     * The number of decimals for percent values
     *
     * @var int
     */
    protected static $percentDecimals = 2;

    /**
     * The number of decimals for measure values
     *
     * @var int
     */
    protected static $measureDecimals = 2;

    /**
     * The decimal separator
     *
     * @var string
     */
    protected static $decimalSeparator = '.';

    /**
     * The thousands seperator
     *
     * @var string
     */
    protected static $thousandsSeparator = '';

    /**
     * The filename of a ICC profile
     *
     * @var string
     */
    protected static $iccProfileFilename = 'sRGB2014.icc';

    /**
     * The filename of the XMP meta data
     *
     * @var string
     */
    protected static $xmpMetaDataFilename = 'facturx_extension_schema.xmp';

    /**
     * Node paths which present an amount. Used for special amount formatting
     *
     * @var array<string,int>
     */
    protected static $specialDecimalPlacesMaps = [];

    /**
     * The configured cache directory for the serializer
     *
     * @var string
     */
    protected static $serializerCacheDirectory = '';

    /**
     * Get the number of decimals to use for amount values
     *
     * @return int
     */
    public static function getAmountDecimals(): int
    {
        return self::$amountDecimals;
    }

    /**
     * Set the number of decimals to use for amount values
     *
     * @param  int  $amountDecimals
     * @return void
     */
    public static function setAmountDecimals(int $amountDecimals): void
    {
        self::$amountDecimals = $amountDecimals;
    }

    /**
     * Get the number of decimals to use for amount values
     *
     * @return int
     */
    public static function getQuantityDecimals(): int
    {
        return self::$quantityDecimals;
    }

    /**
     * Set the number of decimals to use for quantity values
     *
     * @param  int  $quantityDecimals
     * @return void
     */
    public static function setQuantityDecimals(int $quantityDecimals): void
    {
        self::$quantityDecimals = $quantityDecimals;
    }

    /**
     * Get the number of decimals to use for percent values
     *
     * @return int
     */
    public static function getPercentDecimals(): int
    {
        return self::$percentDecimals;
    }

    /**
     * Set the number of decimals to use for percent values
     *
     * @param  int  $percentDecimals
     * @return void
     */
    public static function setPercentDecimals(int $percentDecimals): void
    {
        self::$percentDecimals = $percentDecimals;
    }

    /**
     * Get the number of decimals to use for measure values
     *
     * @return int
     */
    public static function getMeasureDecimals(): int
    {
        return self::$measureDecimals;
    }

    /**
     * Set the number of decimals to use for measure values
     *
     * @param  int  $measureDecimals
     * @return void
     */
    public static function setMeasureDecimals(int $measureDecimals): void
    {
        self::$measureDecimals = $measureDecimals;
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
     * Get the filename for the XMP meta data
     *
     * @return string
     */
    public static function getXmpMetaDataFilename(): string
    {
        return self::$xmpMetaDataFilename;
    }

    /**
     * Set the filename for the XMP meta data
     *
     * @param  string $xmpMetaDataFilename
     * @return void
     */
    public static function setXmpMetaDataFilename(string $xmpMetaDataFilename): void
    {
        self::$xmpMetaDataFilename = $xmpMetaDataFilename;
    }

    /**
     * Returns a list of node paths which have a special number of decimal places
     *
     * @return array<string,int>
     */
    public static function getSpecialDecimalPlacesMaps(): array
    {
        return self::$specialDecimalPlacesMaps;
    }

    /**
     * Get a specific map for node paths with a special number of decimal places. If not map
     * is found then the default value is returns
     *
     * @param  string $nodePath
     * @param  int    $defaultDecimalPlaces
     * @return int
     */
    public static function getSpecialDecimalPlacesMap(string $nodePath, int $defaultDecimalPlaces): int
    {
        $nodePath = preg_replace('@\[\d+\]@', '', $nodePath);

        return self::$specialDecimalPlacesMaps[$nodePath] ?? $defaultDecimalPlaces;
    }

    /**
     * Update the map of node paths which have a special number of decimal places
     *
     * @param  array<string,int> $specialDecimalPlacesMaps
     * @return void
     */
    public static function setSpecialDecimalPlacesMaps(array $specialDecimalPlacesMaps): void
    {
        self::$specialDecimalPlacesMaps = $specialDecimalPlacesMaps;
    }

    /**
     * Add a new map for a node path with a special number of decimal places
     *
     * @param  string $nodePath
     * @param  int    $defaultDecimalPlaces
     * @return void
     */
    public static function addSpecialDecimalPlacesMap(string $nodePath, int $defaultDecimalPlaces): void
    {
        $nodePath = preg_replace('@\[\d+\]@', '', $nodePath);
        self::$specialDecimalPlacesMaps[$nodePath] = $defaultDecimalPlaces;
    }

    /**
     * Set the number of decimals to use for unit single amount (unit prices) values
     *
     * @param  int  $defaultDecimalPlaces
     * @return void
     */
    public static function setUnitAmountDecimals(int $defaultDecimalPlaces): void
    {
        self::addSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', $defaultDecimalPlaces);
        self::addSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:ChargeAmount', $defaultDecimalPlaces);
    }

    /**
     * Set the cache directory for the internal serializer
     *
     * @param  string $serializerCacheDirectoty
     * @return void
     */
    public static function setSerializerCacheDirectory(string $serializerCacheDirectoty): void
    {
        self::$serializerCacheDirectory = $serializerCacheDirectoty;
    }

    /**
     * Returns the cache directory for the internal serializer. This might be empty
     *
     * @return string
     */
    public static function getSerializerCacheDirectory(): string
    {
        return self::$serializerCacheDirectory;
    }

    /**
     * Returns true if a cache directory for the internal serializer is configured, otherwise false
     *
     * @return bool
     */
    public static function hasSerializerCacheDirectory(): bool
    {
        return false === StringUtils::stringIsNullOrEmpty(self::$serializerCacheDirectory);
    }

    /**
     * Get root directory
     *
     * @return string
     */
    public static function getRootDirectory(): string
    {
        return PathUtils::combineAllPaths(__DIR__, '..');
    }

    /**
     * Get the directory where all the sources are stored
     *
     * @return string
     */
    public static function getSourceDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getRootDirectory(), 'src');
    }

    /**
     * Get the directory where all the assets are stored
     *
     * @return string
     */
    public static function getAssetDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSourceDirectory(), 'assets');
    }

    /**
     * Get the directory where all the assets are stored
     *
     * @return string
     */
    public static function getYamlDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSourceDirectory(), 'yaml');
    }

    /**
     * Get the directory where all the validation files are located
     *
     * @return string
     */
    public static function getValidationDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSourceDirectory(), 'validation');
    }

    /**
     * Get the directory where all the schema (XSD) files are located
     *
     * @return string
     */
    public static function getSchemaDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSourceDirectory(), 'schema');
    }

    /**
     * Get the directory where all the stylesheets (XSLT) files are located
     *
     * @return string
     */
    public static function getSchematronDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSchemaDirectory(), 'schematron');
    }

    /**
     * Get the directory where all the stylesheets (XSLT) files are located
     *
     * @return string
     */
    public static function getXsltDirectory(): string
    {
        return PathUtils::combineAllPaths(self::getSchemaDirectory(), 'xslt');
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

    /**
     * Get the full filename containg the XNP information to user
     *
     * @return string
     */
    public static function getFullXmpMetaDataFilename(): string
    {
        return PathUtils::combinePathWithFile(self::getAssetDirectory(), self::$xmpMetaDataFilename);
    }
}
