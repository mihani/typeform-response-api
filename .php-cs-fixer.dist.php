<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('src/Migrations')
;

$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        '@PSR1' => true,
        '@PHP73Migration' => true,
        '@PhpCsFixer' => true,
        '@DoctrineAnnotation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'list_syntax' => ['syntax' => 'long'],
        'php_unit_test_class_requires_covers' => false,
        'php_unit_internal_class' => false,
        'yoda_style' => false
    ])
    ->setFinder($finder)
;
