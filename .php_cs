<?php
$finder = Symfony\Component\Finder\Finder::create()
                                         ->in(__DIR__)
                                         ->exclude(['bootstrap', 'storage', 'vendor'])
                                         ->name('*.php')
                                         ->notName('*.blade.php')
                                         ->ignoreDotFiles(true)
                                         ->ignoreVCS(true);

return PhpCsFixer\Config::create()->setRiskyAllowed(true)->setRules([
    '@PSR2'                      => true,
        'array_syntax'           => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'align',
        ],

        'ordered_imports'   => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,
        'single_quote'      => true,
])->setLineEnding("\n")->setFinder($finder);