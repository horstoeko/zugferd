<?php

namespace horstoeko\zugferd\tests\traits;

use Throwable;
use Symfony\Component\Process\ExecutableFinder;

trait RunsOnlyWithJavaEnvironmentTrait
{
    /**
     * Status of JAVA checks
     *
     * @var null|boolean
     */
    private $javaAvailable;

    /**
     * Checking availability of Java
     *
     * @return boolean
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
        if ($this->isJavaAvailable() === false) {
            $this->markTestSkipped('Java environment not available. Test is skipped.');
        }
    }
}
