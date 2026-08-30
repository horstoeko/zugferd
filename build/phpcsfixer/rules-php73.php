<?php

declare(strict_types=1);

return [
    '@PSR12' => true,
    '@PhpCsFixer' => true,
    'ordered_imports' => [
        'sort_algorithm' => 'alpha',
        'imports_order'  => [
            'class',
            'function',
            'const',
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
            'arrays',
        ],
    ],
    'visibility_required' => [
        'elements' => ['property', 'method', 'const'],
    ],
    'constant_case' => [
        'case' => 'lower',
    ],
    'self_accessor' => true,
    'static_lambda' => true,
    'function_declaration' => [
        'closure_function_spacing' => 'one',
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
        ],
    ],
    // PHP-CS-Fixer 3.4 does not offer the configurable order used by newer 3.x releases.
    'phpdoc_order' => false,
    'phpdoc_order_by_value' => [
        'annotations' => ['throws'],
    ],
    'phpdoc_scalar' => true,
    'phpdoc_trim' => true,
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_summary' => false,
    'phpdoc_no_empty_return' => false,
    // PHP-CS-Fixer 3.4 has no configurable annotation groups for this rule.
    'phpdoc_separation' => false,
    'elseif' => true,
    'blank_line_before_statement' => [
        'statements' => [
            'return',
            'throw',
            'try',
            'if',
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
    // PHP-CS-Fixer 3.4 has no case_sensitive option for ordered_traits.
    'ordered_traits' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'lowercase_cast' => true,
    'short_scalar_cast' => true,
    'cast_spaces' => ['space' => 'single'],
    'phpdoc_to_comment' => false,
];
