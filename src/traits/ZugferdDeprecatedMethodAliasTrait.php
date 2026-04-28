<?php

namespace horstoeko\zugferd\traits;

trait ZugferdDeprecatedMethodAliasTrait
{
    /**
     * Returns a map of deprecated method names to their correct replacements.
     *
     * @return array<string, string>
     */
    abstract protected function getDeprecatedMethodAliases(): array;

    /**
     * Routes calls to deprecated method names to their correct replacements.
     *
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        $aliases = $this->getDeprecatedMethodAliases();

        if (isset($aliases[$name])) {
            trigger_error(
                sprintf(
                    'Method %s::%s() is deprecated, please use %s() instead.',
                    static::class,
                    $name,
                    $aliases[$name]
                ),
                E_USER_DEPRECATED
            );

            return $this->{$aliases[$name]}(...$arguments);
        }

        throw new \BadMethodCallException(
            sprintf('Method %s::%s() does not exist', static::class, $name)
        );
    }
}
