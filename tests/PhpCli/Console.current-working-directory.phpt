<?php

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole();

Assert::same(__DIR__, $console->getCurrentDirectory());

// relative path
$console->setCurrentDirectory('..');
Assert::same(realpath(__DIR__ . '/../'), $console->getCurrentDirectory());

// absolute path
$console->setCurrentDirectory(__DIR__);
Assert::same(__DIR__, $console->getCurrentDirectory());

// cache
chdir('..');
Assert::same(realpath(__DIR__ . '/../'), $console->getCurrentDirectory());
