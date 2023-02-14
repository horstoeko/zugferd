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
        ZugferdSettings::setDecimalSeparator(".");
        ZugferdSettings::setThousandsSeparator("");
        ZugferdSettings::setIccProfileFilename("sRGB_v4_ICC.icc");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testAmountDecimals(): void
    {
        $this->assertEquals(2, ZugferdSettings::getAmountDecimals());

        ZugferdSettings::setAmountDecimals(3);

        $this->assertEquals(3, ZugferdSettings::getAmountDecimals());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "amountDecimals");

        $this->assertEquals(3, $property->getValue());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testQuantityDecimals(): void
    {
        $this->assertEquals(2, ZugferdSettings::getQuantityDecimals());

        ZugferdSettings::setQuantityDecimals(3);

        $this->assertEquals(3, ZugferdSettings::getQuantityDecimals());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "quantityDecimals");

        $this->assertEquals(3, $property->getValue());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testPercentDecimals(): void
    {
        $this->assertEquals(2, ZugferdSettings::getPercentDecimals());

        ZugferdSettings::setPercentDecimals(3);

        $this->assertEquals(3, ZugferdSettings::getPercentDecimals());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "percentDecimals");

        $this->assertEquals(3, $property->getValue());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testDecimalSeparator(): void
    {
        $this->assertEquals(".", ZugferdSettings::getDecimalSeparator());

        ZugferdSettings::setDecimalSeparator(",");

        $this->assertEquals(",", ZugferdSettings::getDecimalSeparator());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "decimalSeparator");

        $this->assertEquals(",", $property->getValue());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testThousandsSeparator(): void
    {
        $this->assertEquals("", ZugferdSettings::getThousandsSeparator());

        ZugferdSettings::setThousandsSeparator(",");

        $this->assertEquals(",", ZugferdSettings::getThousandsSeparator());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "thousandsSeparator");

        $this->assertEquals(",", $property->getValue());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testIccProfileFilename(): void
    {
        $this->assertEquals("sRGB_v4_ICC.icc", ZugferdSettings::getIccProfileFilename());

        ZugferdSettings::setIccProfileFilename("sRGB_v5_ICC.icc");

        $this->assertEquals("sRGB_v5_ICC.icc", ZugferdSettings::getIccProfileFilename());

        $property = $this->getPrivatePropertyFromClassname(ZugferdSettings::class, "iccProfileFilename");
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testGetRootDirectory(): void
    {
        $this->assertEquals(
            realpath(dirname(__FILE__) . "/../../"),
            realpath(ZugferdSettings::getRootDirectory())
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testGetSourceDirectory(): void
    {
        $this->assertEquals(
            realpath(dirname(__FILE__) . "/../../src/"),
            realpath(ZugferdSettings::getSourceDirectory())
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testGetAssetDirectory(): void
    {
        $this->assertEquals(
            realpath(dirname(__FILE__) . "/../../src/assets/"),
            realpath(ZugferdSettings::getAssetDirectory())
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testGetYamlDirectory(): void
    {
        $this->assertEquals(
            realpath(dirname(__FILE__) . "/../../src/yaml/"),
            realpath(ZugferdSettings::getYamlDirectory())
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testGetValidationDirectory(): void
    {
        $this->assertEquals(
            realpath(dirname(__FILE__) . "/../../src/validation/"),
            realpath(ZugferdSettings::getValidationDirectory())
        );
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdSettings
     */
    public function testGetFullIccProfileFilename(): void
    {
        $expected = PathUtils::combinePathWithFile(
            realpath(dirname(__FILE__) . "/../../src/assets/"),
            "sRGB_v5_ICC.icc"
        );
        $actual = PathUtils::combinePathWithFile(
            realpath(FileUtils::getFileDirectory(ZugferdSettings::getFullIccProfileFilename())),
            "sRGB_v5_ICC.icc"
        );

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}
