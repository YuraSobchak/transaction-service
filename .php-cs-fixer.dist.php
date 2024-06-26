<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['.git', 'var'])
    ->notPath('config/bundles.php')
;

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'native_function_invocation' => ['include' => ['@internal']],
        'blank_line_after_opening_tag' => true,
        'declare_strict_types' => true,
        'braces_position' => true,
        'statement_indentation' => true,
        'control_structure_braces' => true,
        'trailing_comma_in_multiline' => true,
        'array_syntax' => ['syntax' => 'short'],
        'single_space_around_construct' => true,
        'control_structure_continuation_position' => true,
        'declare_parentheses' => true,
        'no_multiple_statements_per_line' => true,
        'no_extra_blank_lines' => true,
        'compact_nullable_type_declaration' => true,
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => ['space' => 'none'],
        'type_declaration_spaces' => true,
        'global_namespace_import' => false,
        'list_syntax' => ['syntax' => 'short'],
        'new_with_parentheses' => true,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_trailing_comma_in_singleline' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_unused_imports' => true,
        'no_whitespace_in_blank_line' => true,
        'normalize_index_brace' => true,
        'ordered_imports' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'single_trait_insert_per_statement' => true,
        'single_quote' => true,
        'trim_array_spaces' => true,
        'cast_spaces' => ['space' => 'none'],
        'function_declaration' => true,
        'nullable_type_declaration_for_default_null_value' => false,
        'blank_line_before_statement' => [
            'statements' => [
                'return',
                'break',
                'continue',
            ],
        ],
     ])
;
