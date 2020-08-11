<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Application\ICommand;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'--run',
	]));
	$application->setDefaultCommand('default');
	$application->setCommand('default', Tests\TestCommand::create()
		->setOptions([
			'run' => [
				'type' => 'bool',
				'defaultValue' => FALSE,
			],
		])
		->setCallback(function () {
			throw new \RuntimeException('COMMAND: default');
		})
	);

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'RuntimeException', 'COMMAND: default');
});


test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'test',
	]));
	$application->setDefaultCommand('default');
	$application->setCommand('default', Tests\TestCommand::create()
		->setCallback(function () {
			throw new \RuntimeException('COMMAND: default');
		})
	);
	$application->setCommand('test', Tests\TestCommand::create()
		->setCallback(function () {
			throw new \RuntimeException('COMMAND: test');
		})
	);

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'RuntimeException', 'COMMAND: test');
});
