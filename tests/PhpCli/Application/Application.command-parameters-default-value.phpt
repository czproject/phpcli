<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Default value
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--flag-with-default',
		'--flag-without-default',
		'--flag-value',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setParameters(function ($parameters) {
			$parameters->addOption('flag-with-default', 'string')
				->setDefaultValue(FALSE);

			$parameters->addOption('flag-without-default', 'string');
			$parameters->addOption('flag-value', 'string');
			$parameters->addOption('flag-default', 'int')
				->setDefaultValue('9876.87')
				->setRepeatable();
		})
		->setCallback(function ($console, $options, $arguments) {
			Assert::same([
				'flag-with-default' => '1',
				'flag-without-default' => '1',
				'flag-value' => '1',
				'flag-default' => [
					9876,
				],
			], $options);
			Assert::same([], $arguments);
		})
	);
	$application->run();
});
