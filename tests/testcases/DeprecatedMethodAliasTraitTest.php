<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\traits\ZugferdDeprecatedMethodAliasTrait;

class DeprecatedMethodAliasTraitTest extends TestCase
{
    public function testCallingDeprecatedMethodTriggersDeprecationAndReturnsResult(): void
    {
        $object = new class () {
            use ZugferdDeprecatedMethodAliasTrait;

            protected function getDeprecatedMethodAliases(): array
            {
                return [
                    'oldMethod' => 'newMethod',
                ];
            }

            public function newMethod(): string
            {
                return 'result';
            }
        };

        $deprecationTriggered = false;
        $deprecationMessage = '';

        set_error_handler(
            static function (int $errno, string $errstr) use (&$deprecationTriggered, &$deprecationMessage): bool {
                if ($errno === E_USER_DEPRECATED) {
                    $deprecationTriggered = true;
                    $deprecationMessage = $errstr;
                    return true;
                }

                return false;
            }
        );

        $result = $object->oldMethod();

        restore_error_handler();

        $this->assertTrue($deprecationTriggered);
        $this->assertStringContainsString('oldMethod()', $deprecationMessage);
        $this->assertStringContainsString('newMethod()', $deprecationMessage);
        $this->assertSame('result', $result);
    }

    public function testCallingNonExistentMethodThrowsBadMethodCallException(): void
    {
        $object = new class () {
            use ZugferdDeprecatedMethodAliasTrait;

            protected function getDeprecatedMethodAliases(): array
            {
                return [];
            }
        };

        $this->expectException(\BadMethodCallException::class);

        $object->nonExistentMethod();
    }

    public function testDeprecatedMethodPassesArguments(): void
    {
        $object = new class () {
            use ZugferdDeprecatedMethodAliasTrait;

            protected function getDeprecatedMethodAliases(): array
            {
                return [
                    'oldAdd' => 'newAdd',
                ];
            }

            public function newAdd(int $a, int $b): int
            {
                return $a + $b;
            }
        };

        set_error_handler(
            static function (int $errno, string $errstr): bool {
                return $errno === E_USER_DEPRECATED;
            }
        );

        $result = $object->oldAdd(3, 4);

        restore_error_handler();

        $this->assertSame(7, $result);
    }
}
