<?php

declare(strict_types=1);

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Repeatable
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--flag',
		'--flag2=flag2-value',
		'--flag2=flag2-value2',
		'--flag3',
		'--flag4=flag4-value',
		'--flag',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setParameters(function ($parameters) {
			$parameters->addOption('flag', 'bool');

			$parameters->addOption('flag2', 'string')
				->setRepeatable();

			$parameters->addOption('flag3', 'bool')
				->setRepeatable();

			$parameters->addOption('flag4', 'string')
				->setRepeatable();
		})
		->setCallback(function ($console, $options, $arguments) {
			Assert::same([
				'flag' => TRUE,
				'flag2' => [
					0 => 'flag2-value',
					1 => 'flag2-value2'
				],
				'flag3' => [
					0 => TRUE,
				],
				'flag4' => [
					0 => 'flag4-value',
				],
			], $options);
			Assert::same([], $arguments);
		})
	);

	$application->run();
});


/**
 * Repeatable missing value
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--flag',
		'--flag',
		'--flag2=flag2-value',
		'--flag2=flag2-value2',
		'--flag3',
		'--flag5=flag5-value',
		'--flag4=flag4-value',
		'--flag5=flag5-value2',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setParameters(function ($parameters) {
			$parameters->addOption('flag', 'bool');

			$parameters->addOption('flag2', 'string')
				->setRepeatable();

			$parameters->addOption('flag3', 'string')
				->setRepeatable();

			$parameters->addOption('flag4', 'string')
				->setRepeatable();

			$parameters->addOption('flag5', 'string');
		})
	);

	Assert::exception(function () use ($application) {

		$application->run();

	}, CzProject\PhpCli\InvalidStateException::class, "Multiple values for option 'flag5'.");
});
