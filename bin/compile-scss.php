<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

$compiler = new Compiler();
$compiler->setImportPaths(__DIR__ . '/../scss/');
$compiler->setOutputStyle(OutputStyle::COMPRESSED);

$input  = file_get_contents(__DIR__ . '/../scss/main.scss');
$result = $compiler->compileString($input)->getCss();

$outputDir = __DIR__ . '/../public/assets/css';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

file_put_contents($outputDir . '/main.css', $result);
echo "SCSS compiled → public/assets/css/main.css\n";
