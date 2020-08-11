<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Empty options & arguments
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setCallback(function ($console, $options, $arguments) {
			Assert::same([], $options);
			Assert::same([], $arguments);
		})
	);
	$application->run();
});
