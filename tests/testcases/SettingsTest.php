<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\ZugferdSettings;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\stringmanagement\FileUtils;
use horstoeko\stringmanagement\PathUtils;

class SettingsTest extends TestCase
{
    /**
     * @inheritDoc
     */
    public static function tearDownAfterClass(): void
    {
        ZugferdSettings::setAmountDecimals(2);
        ZugferdSettings::setQuantityDecimals(2);
        ZugferdSettings::setPercentDecimals(2);
        ZugferdSettings::setMeasureDecimals(2);
        ZugferdSettings::setDecimalSeparator(".");
        ZugferdSettings::setThousandsSeparator("");
        ZugferdSettings::setIccProfileFilename("sRGB2014.icc");
    }

    public function testAmountDecimals(): void
    {
        $this->assertSame(2, ZugferdSettings::getAmountDecimals());

        ZugferdSettings::setAmountDecimals(3);

        $this->assertSame(3, ZugferdSettings::getAmountDecimals());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "amountDecimals");

        $this->assertEquals(3, $property->getValue());
    }

    public function testQuantityDecimals(): void
    {
        $this->assertSame(2, ZugferdSettings::getQuantityDecimals());

        ZugferdSettings::setQuantityDecimals(3);

        $this->assertSame(3, ZugferdSettings::getQuantityDecimals());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "quantityDecimals");

        $this->assertEquals(3, $property->getValue());
    }

    public function testPercentDecimals(): void
    {
        $this->assertSame(2, ZugferdSettings::getPercentDecimals());

        ZugferdSettings::setPercentDecimals(3);

        $this->assertSame(3, ZugferdSettings::getPercentDecimals());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "percentDecimals");

        $this->assertEquals(3, $property->getValue());
    }

    public function testMeasureDecimals(): void
    {
        $this->assertSame(2, ZugferdSettings::getMeasureDecimals());

        ZugferdSettings::setMeasureDecimals(3);

        $this->assertSame(3, ZugferdSettings::getMeasureDecimals());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "measureDecimals");

        $this->assertEquals(3, $property->getValue());
    }

    public function testDecimalSeparator(): void
    {
        $this->assertSame(".", ZugferdSettings::getDecimalSeparator());

        ZugferdSettings::setDecimalSeparator(",");

        $this->assertSame(",", ZugferdSettings::getDecimalSeparator());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "decimalSeparator");

        $this->assertEquals(",", $property->getValue());
    }

    public function testThousandsSeparator(): void
    {
        $this->assertSame("", ZugferdSettings::getThousandsSeparator());

        ZugferdSettings::setThousandsSeparator(",");

        $this->assertSame(",", ZugferdSettings::getThousandsSeparator());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "thousandsSeparator");

        $this->assertEquals(",", $property->getValue());
    }

    public function testIccProfileFilename(): void
    {
        $this->assertSame("sRGB2014.icc", ZugferdSettings::getIccProfileFilename());

        ZugferdSettings::setIccProfileFilename("sRGB_v5_ICC.icc");

        $this->assertSame("sRGB_v5_ICC.icc", ZugferdSettings::getIccProfileFilename());

        $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "iccProfileFilename");
    }

    public function testGetRootDirectory(): void
    {
        $this->assertEquals(
            realpath(__DIR__ . "/../../"),
            realpath(ZugferdSettings::getRootDirectory())
        );
    }

    public function testGetSourceDirectory(): void
    {
        $this->assertEquals(
            realpath(__DIR__ . "/../../src/"),
            realpath(ZugferdSettings::getSourceDirectory())
        );
    }

    public function testGetAssetDirectory(): void
    {
        $this->assertEquals(
            realpath(__DIR__ . "/../../src/assets/"),
            realpath(ZugferdSettings::getAssetDirectory())
        );
    }

    public function testGetYamlDirectory(): void
    {
        $this->assertEquals(
            realpath(__DIR__ . "/../../src/yaml/"),
            realpath(ZugferdSettings::getYamlDirectory())
        );
    }

    public function testGetValidationDirectory(): void
    {
        $this->assertEquals(
            realpath(__DIR__ . "/../../src/validation/"),
            realpath(ZugferdSettings::getValidationDirectory())
        );
    }

    public function testGetFullIccProfileFilename(): void
    {
        $expected = PathUtils::combinePathWithFile(
            realpath(__DIR__ . "/../../src/assets/"),
            "sRGB_v5_ICC.icc"
        );
        $actual = PathUtils::combinePathWithFile(
            realpath(FileUtils::getFileDirectory(ZugferdSettings::getFullIccProfileFilename())),
            "sRGB_v5_ICC.icc"
        );

        $this->assertSame(
            $expected,
            $actual
        );
    }

    public function testSpecialDecimalPlacesMaps(): void
    {
        $this->assertSame(2, ZugferdSettings::getSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', 2));
        $this->assertSame(2, ZugferdSettings::getSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:ChargeAmount', 2));

        ZugferdSettings::addSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', 5);

        $this->assertSame(5, ZugferdSettings::getSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', 2));
        $this->assertSame(2, ZugferdSettings::getSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:ChargeAmount', 2));

        ZugferdSettings::setSpecialDecimalPlacesMaps(
            [
            '/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount' => 6,
            '/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:ChargeAmount' => 6
            ]
        );

        $this->assertSame(6, ZugferdSettings::getSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:GrossPriceProductTradePrice/ram:ChargeAmount', 2));
        $this->assertSame(6, ZugferdSettings::getSpecialDecimalPlacesMap('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:IncludedSupplyChainTradeLineItem/ram:SpecifiedLineTradeAgreement/ram:NetPriceProductTradePrice/ram:ChargeAmount', 2));
    }

    public function testSerializerCacheDirectory(): void
    {
        $this->assertSame('', ZugferdSettings::getSerializerCacheDirectory());
        $this->assertFalse(ZugferdSettings::hasSerializerCacheDirectory());

        ZugferdSettings::setSerializerCacheDirectory(sys_get_temp_dir());

        $this->assertSame(sys_get_temp_dir(), ZugferdSettings::getSerializerCacheDirectory());
        $this->assertTrue(ZugferdSettings::hasSerializerCacheDirectory());

        ZugferdSettings::setSerializerCacheDirectory('');

        $this->assertSame('', ZugferdSettings::getSerializerCacheDirectory());
        $this->assertFalse(ZugferdSettings::hasSerializerCacheDirectory());
    }
}
