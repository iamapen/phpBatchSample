#!/usr/bin/env php
<?php
declare(strict_types=1);

use Acme\Pcc\PccCommand;

require_once __DIR__ . '/../vendor/autoload.php';

$command = new PccCommand();
$command->execute();
