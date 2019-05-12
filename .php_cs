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
    'native_function_invocation' => true,
    'array_syntax' => ['syntax' => 'short'],
    'ordered_imports' => ['sortAlgorithm' => 'length'],
    'no_unused_imports' => true,

])->setFinder($finder);