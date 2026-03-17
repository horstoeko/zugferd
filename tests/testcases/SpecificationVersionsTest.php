<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdSpecificationVersions;

class SpecificationVersionsTest extends TestCase
{
    public function testZugferdVersionIsDefined(): void
    {
        self::assertNotEmpty(ZugferdSpecificationVersions::VERSION_ZUGFERD);
        self::assertIsString(ZugferdSpecificationVersions::VERSION_ZUGFERD);
    }

    public function testFacturxVersionIsDefined(): void
    {
        self::assertNotEmpty(ZugferdSpecificationVersions::VERSION_FACTURX);
        self::assertIsString(ZugferdSpecificationVersions::VERSION_FACTURX);
    }

    public function testXRechnungVersionIsDefined(): void
    {
        self::assertNotEmpty(ZugferdSpecificationVersions::VERSION_XRECHNUNG);
        self::assertIsString(ZugferdSpecificationVersions::VERSION_XRECHNUNG);
    }

    public function testVersionFormats(): void
    {
        self::assertMatchesRegularExpression('/^\d+\.\d+(\.\d+)?$/', ZugferdSpecificationVersions::VERSION_ZUGFERD);
        self::assertMatchesRegularExpression('/^\d+\.\d+(\.\d+)?$/', ZugferdSpecificationVersions::VERSION_FACTURX);
        self::assertMatchesRegularExpression('/^\d+\.\d+(\.\d+)?$/', ZugferdSpecificationVersions::VERSION_XRECHNUNG);
    }
}
