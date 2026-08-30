<?php

declare(strict_types=1);

namespace Symfony\Component\Process;

/**
 * PHPStan symbol definition for the Symfony Process API used by the project.
 */
class Process
{
    /**
     * @param array<int, string> $command
     * @param mixed              $input
     *
     * @throws \Throwable
     */
    public function __construct(array $command, ?string $cwd = null, ?array $env = null, $input = null, ?float $timeout = 60)
    {
    }

    public function setTimeout(?float $timeout): self
    {
        return $this;
    }

    public function setWorkingDirectory(string $cwd): self
    {
        return $this;
    }

    /**
     * @param null|callable(string, string): void $callback
     * @param array<string, string>               $env
     */
    public function run(?callable $callback = null, array $env = []): int
    {
        return 0;
    }

    public function getOutput(): string
    {
        return '';
    }

    public function isSuccessful(): bool
    {
        return true;
    }

    public function getExitCode(): ?int
    {
        return 0;
    }
}
