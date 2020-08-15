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
		->setParameters(function ($parameters) {
			$parameters->addOption('flag', 'bool');
		})
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


/**
 * Arguments processing
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'yes',
		'argument2',
		'argument3',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setParameters(function ($parameters) {
			$parameters->addArgument('arg1', 'bool');
			$parameters->addArgument('arg2');
			$parameters->addArgument('arg3');
			$parameters->addArgument('arg4')
				->setDefaultValue('test');

			$parameters->addArgument('arg5');
		})
		->setCallback(function ($console, $options, $arguments) {
			Assert::same([], $options);

			Assert::same([
				0 => TRUE,
				1 => 'argument2',
				2 => 'argument3',
				3 => 'test',
				4 => NULL,
			], $arguments);
		})
	);

	$application->run();
});


/**
 * Arguments processing
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setParameters(function ($parameters) {
			$parameters->addArgument('arg1')
				->setRequired();
		})
	);

	Assert::exception(function () use ($application) {
		$application->run();
	}, CzProject\PhpCli\MissingParameterException::class, "Missing value for required argument 'arg1' (at position #0).");
});
