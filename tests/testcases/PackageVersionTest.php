<?php

declare(strict_types=1);

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdPackageVersion;

final class PackageVersionTest extends TestCase
{
    public function testVersion(): void
    {
        $this->assertNotEmpty(ZugferdPackageVersion::getInstalledVersion());
    }
}
