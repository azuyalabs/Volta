<?php

$projectPath = __DIR__;

// Declare directories which contain PHP code
$scanDirectories = [
    $projectPath . '/app/',
    $projectPath . '/resources/views/',
    $projectPath . '/routes/',
    $projectPath . '/bootstrap/',
];

// Optionally declare standalone files
$scanFiles = [];

return [
    'composerJsonPath' => $projectPath . '/composer.json',
    'vendorPath'       => $projectPath . '/vendor/',
    'scanDirectories'  => $scanDirectories,
    'scanFiles'        => $scanFiles
];
