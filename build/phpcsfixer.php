<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfig;

$rootDir = __DIR__ . '/..';

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
    ->exclude(
        [
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
        ]
    );

$config = (new Config())
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile($rootDir . '/build/phpcsfixer-cache/.php-cs-fixer.cache')
    ->setFinder($finder)
    ->setIndent("    ")
    ->setLineEnding("\n")
    ->setRules(
        [
            '@PSR12' => true,
            '@PhpCsFixer' => true,
            'ordered_imports' => [
                'sort_algorithm' => 'alpha',
                'imports_order'  => [
                    'class',
                    'function',
                    'const'
                ],
            ],
            'no_unused_imports' => true,
            'single_import_per_statement' => true,
            'single_line_after_imports' => true,
            'declare_strict_types' => false,
            'array_indentation' => true,
            'array_syntax' => ['syntax' => 'short'],
            'trailing_comma_in_multiline' => [
                'elements' => [
                    'arrays'
                ],
            ],
            'modifier_keywords' => [
                'elements' => ['property', 'method', 'const'],
            ],
            'constant_case' => [
                'case' => 'lower'
            ],
            'self_accessor' => true,
            'static_lambda' => true,
            'function_declaration' => [
                'closure_function_spacing' => 'one'
            ],
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
            ],
            'control_structure_continuation_position' => true,
            'binary_operator_spaces' => [
                'default' => 'single_space',
            ],
            'phpdoc_align' => [
                'tags' => [
                    'method',
                    'param',
                    'property',
                    'return',
                    'type',
                    'var',
                    'throws',
                    'see',
                    'license',
                    'todo',
                    '@phpstan-param',
                    '@phpstan-param-out',
                    'param-out',
                ],
            ],
            'phpdoc_order' => [
                'order' => ['param', 'return', 'throws'],
            ],
            'phpdoc_order_by_value' => [
                'annotations' => ['throws'],
            ],
            'phpdoc_scalar' => true,
            'phpdoc_trim' => true,
            'phpdoc_trim_consecutive_blank_line_separation' => true,
            'phpdoc_summary' => false,
            'phpdoc_no_empty_return' => false,
            'phpdoc_separation' => [
                'groups' => [
                    ['category', 'package', 'author', 'license', 'subpackage', 'copyright', 'link', 'see'],
                    ['param', 'return'],
                    ['throws'],
                    ['deprecated', 'since'],
                    ['var', 'JMS\\*']
                ],
                'skip_unlisted_annotations' => false,
            ],
            'elseif' => true,
            'blank_line_before_statement' => [
                'statements' => [
                    'return',
                    'throw',
                    'try',
                    'if'
                ],
            ],
            'no_useless_return' => true,
            'no_useless_else' => true,
            'no_superfluous_phpdoc_tags' => false,
            'no_empty_phpdoc' => false,
            'global_namespace_import' => [
                'import_classes'   => true,
                'import_constants' => false,
                'import_functions' => false,
            ],
            'multiline_whitespace_before_semicolons' => [
                'strategy' => 'no_multi_line',
            ],
            'php_unit_test_class_requires_covers' => false,
            'php_unit_internal_class' => false,
            'self_static_accessor' => false,
            'yoda_style' => [
                'equal' => true,
                'identical' => true,
                'less_and_greater' => null,
                'always_move_variable' => false,
            ],
            'ordered_traits' => [
                'case_sensitive' => false,
            ],
            'concat_space' => [
                'spacing' => 'one',
            ],
            'lowercase_cast' => true,
            'short_scalar_cast' => true,
            'cast_spaces' => ['space' => 'single'],
            'phpdoc_to_comment' => false,
            'ordered_attributes' => true,
            'attribute_block_no_spaces' => true,
        ]
    );

if (PHP_VERSION_ID >= 70400) {
    $config->setParallelConfig(new ParallelConfig(4, 20, 60000));
}

if (PHP_VERSION_ID < 80100 ) {
    $rules = $config->getRules();
    unset($rules['modifier_keywords']);
    unset($rules['ordered_attributes']);
    unset($rules['attribute_block_no_spaces']);
    unset($rules['phpdoc_order']);
    unset($rules['phpdoc_align']);
    $config->setRules($rules);
}

return $config;