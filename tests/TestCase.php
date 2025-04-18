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

        call_user_func($run);

        restore_error_handler();
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
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        return $property;
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
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        return $property;
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
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
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
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
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
