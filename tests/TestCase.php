<?php

namespace horstoeko\zugferd\tests;

use \PHPUnit\Framework\TestCase as PhpUnitTestCase;

class TestCase extends PhpUnitTestCase
{
    /**
     * Expect notice on php version smaller than 8
     * Expect warning on php version greater or equal than 8
     *
     * @return void
     */
    public function expectNoticeOrWarning(): void
    {
        if (version_compare(phpversion(), '8', '>=')) {
            $this->expectWarning();
        } else {
            $this->expectNotice();
        }
    }

    /**
     * Use this with PHPunit 10
     *
     * @param \Closure $run
     * @return void
     */
    public function expectNoticeOrWarningExt(\Closure $run): void
    {
        set_error_handler(static function (int $errno, string $errstr): never {
            throw new \Exception($errstr, $errno);
        }, E_ALL);

        $this->expectException(\Exception::class);

        call_user_func($run);

        restore_error_handler();
    }
}
