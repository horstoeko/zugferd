<?php

declare(strict_types=1);

namespace horstoeko\zugferd\tests\traits;

use Symfony\Component\Process\ExecutableFinder;
use Throwable;

trait RunsOnlyWithJavaEnvironmentTrait
{
    /**
     * Status of JAVA checks
     *
     * @var null|bool
     */
    private $javaAvailable;

    /**
     * Checking availability of Java
     *
     * @return bool
     */
    private function isJavaAvailable(): bool
    {
        if (!is_null($this->javaAvailable)) {
            return $this->javaAvailable;
        }

        try {
            $executableFinder = new ExecutableFinder();
            $this->javaAvailable = !is_null($executableFinder->find('java'));
        } catch (Throwable $throwable) {
            $this->javaAvailable = false;
        }

        return $this->javaAvailable;
    }

    /**
     * Mark a test as skipped
     *
     * @return void
     */
    private function markAsSkippedIfJavaIsNotAvailable(): void
    {
        if (false === $this->isJavaAvailable()) {
            $this->markTestSkipped('Java environment not available. Test is skipped.');
        }
    }
}
