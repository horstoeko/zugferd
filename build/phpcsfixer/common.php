<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfig;

return static function (array $rules, $enableParallel) {
    $rootDir = __DIR__ . '/../..';

    $finder = (new Finder())
        ->in([
            $rootDir . '/examples',
            $rootDir . '/src',
            $rootDir . '/make',
            $rootDir . '/tests',
        ])
        ->name('*.php')
        ->ignoreVCS(true)
        ->ignoreDotFiles(true)
        ->exclude([
            'vendor',
            'node_modules',
            'var',
            'storage',
            'cache',
            'entities',
            'codelistsenum',
            'build',
            '.git',
            '.idea',
        ]);

    $config = (new Config())
        ->setRiskyAllowed(true)
        ->setUsingCache(true)
        ->setCacheFile($rootDir . '/build/phpcsfixer-cache/.php-cs-fixer.cache')
        ->setFinder($finder)
        ->setIndent("    ")
        ->setLineEnding("\n")
        ->setRules($rules);

    if ($enableParallel && class_exists(ParallelConfig::class) && method_exists($config, 'setParallelConfig')) {
        $config->setParallelConfig(new ParallelConfig(4, 20, 60000));
    }

    return $config;
};
