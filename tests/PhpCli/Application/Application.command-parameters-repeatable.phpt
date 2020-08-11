<?php

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
		->setOptions([
			'flag' => [
				'type' => 'bool',
			],
			'flag2' => [
				'type' => 'string',
				'repeatable' => TRUE,
			],
			'flag3' => [
				'type' => 'bool',
				'repeatable' => TRUE,
			],
			'flag4' => [
				'type' => 'string',
				'repeatable' => TRUE,
			],
		])
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
		->setOptions([
			'flag' => [
				'type' => 'bool',
			],
			'flag2' => [
				'type' => 'string',
				'repeatable' => TRUE,
			],
			'flag3' => [
				'type' => 'string',
				'repeatable' => TRUE,
			],
			'flag4' => [
				'type' => 'string',
				'repeatable' => TRUE,
			],
			'flag5' => [
				'type' => 'string',
			],
		])
	);

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'CzProject\PhpCli\ApplicationException', "Multiple values for option 'flag5'.");
});
