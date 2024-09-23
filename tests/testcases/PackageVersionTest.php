<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\ZugferdPackageVersion;
use horstoeko\zugferd\tests\TestCase;

class PackageVersionTest extends TestCase
{
    public function testVersion(): void
    {
        $this->assertNotEmpty(ZugferdPackageVersion::getInstalledVersion());
    }
}
