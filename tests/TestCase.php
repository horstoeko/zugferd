<?php

namespace horstoeko\zugferd\tests;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

class TestCase extends PhpUnitTestCase
{
    /**
     * Registered files
     *
     * @var array<string>
     */

    private $registeredFiles = [];

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registeredFiles = [];
    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        foreach ($this->registeredFiles as $registeredFile) {
            if (file_exists($registeredFile)) {
                @unlink($registeredFile);
            }
        }

        parent::tearDown();
    }

    /**
     * Expect a notice or warning from the closure
     *
     * @param  \Closure $run
     * @return void
     */
    public function expectNoticeOrWarningExt(\Closure $run): void
    {
        set_error_handler(
            static function (int $errno, string $errstr): void {
                throw new \Exception($errstr, $errno);
            },
            E_ALL
        );

        $this->expectException(\Exception::class);

        try {
            call_user_func($run);
        } finally {
            restore_error_handler();
        }
    }

    /**
     * Access to private properties
     *
     * @param  string $className
     * @param  string $propertyName
     * @return ReflectionProperty
     */
    public function getPrivatePropertyFromClassname(string $className, string $propertyName): ReflectionProperty
    {
        $reflector = new ReflectionClass($className);
        return $reflector->getProperty($propertyName);
    }

    /**
     * Access to private properties
     *
     * @param  object $object
     * @param  string $propertyName
     * @return ReflectionProperty
     */
    public function getPrivatePropertyFromObject(object $object, string $propertyName): ReflectionProperty
    {
        $reflector = new ReflectionClass($object);
        return $reflector->getProperty($propertyName);
    }

    /**
     * Access to private method
     *
     * @param  string $className
     * @param  string $methodName
     * @return ReflectionMethod
     */
    public function getPrivateMethodFromClassname(string $className, string $methodName): ReflectionMethod
    {
        $reflector = new ReflectionClass($className);
        return $reflector->getMethod($methodName);
    }

    /**
     * Access to private method
     *
     * @param  object $object
     * @param  string $methodName
     * @return ReflectionMethod
     */
    public function getPrivateMethodFromObject(object $object, string $methodName): ReflectionMethod
    {
        $reflector = new ReflectionClass($object);
        return $reflector->getMethod($methodName);
    }

    /**
     * Access to private method and invoke it
     *
     * @param  object $object
     * @param  string $methodName
     * @param  array  $args
     * @return mixed
     */
    public function invokePrivateMethodFromObject($object, string $methodName, ...$args)
    {
        $method = $this->getPrivateMethodFromObject($object, $methodName);
        return $method->invoke($object, ...$args);
    }

    /**
     * Register a file for teardown
     *
     * @param  string $filename
     * @return void
     */
    protected function registerFileForTeardown(string $filename): void
    {
        $this->registeredFiles[] = $filename;
    }
}
