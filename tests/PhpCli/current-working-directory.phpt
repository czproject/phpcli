<?php
use Tester\Assert;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../loader.php';

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
Assert::same(__DIR__, $console->getCurrentDirectory());
Assert::same(realpath(__DIR__ . '/../'), $console->getCurrentDirectory(TRUE));

