<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Arguments
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'argument1',
		'argument2',
		'--flag',
		'--',
		'argument3',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setOptions([
			'flag' => [
				'type' => 'bool',
			],
		])
		->setCallback(function ($console, $options, $arguments) {
			Assert::same([
				'flag' => TRUE,
			], $options);

			Assert::same([
				0 => 'argument1',
				1 => 'argument2',
				2 => 'argument3',
			], $arguments);
		})
	);

	$application->run();
});
