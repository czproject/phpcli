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
		->setOptions([
			'flag-with-default' => [
				'type' => 'string',
				'defaultValue' => FALSE,
			],
			'flag-without-default' => [
				'type' => 'string',
			],
			'flag-value' => [
				'type' => 'string',
			],
			'flag-default' => [
				'type' => 'int',
				'defaultValue' => '9876.87',
				'repeatable' => TRUE,
			],
		])
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
