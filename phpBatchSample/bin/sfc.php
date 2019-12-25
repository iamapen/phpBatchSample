#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Symfony\Component\Console\Application('sfc-sample', '1.0.0');

$app->addCommands([
    new \Acme\Sfc\SfcCommand('sfc'),
]);

$app->run();
