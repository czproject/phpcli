<?php

declare(strict_types=1);

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'argument1',
	]));
	$application->addCommand(Tests\TestCommand::create());

	Assert::exception(function () use ($application) {
		$application->addCommand(Tests\TestCommand::create());
	}, CzProject\PhpCli\InvalidArgumentException::class, "Command 'TEST' already exists.");
});
