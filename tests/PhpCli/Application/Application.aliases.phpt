<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$testCommand = Tests\TestCommand::create()
	->setOptions([
		'flag' => [
			'type' => 'bool',
			'required' => TRUE,
		],
		'alias' => [
			'alias' => 'flag',
		],
		'alias2' => 'flag',
	])
	->setCallback(function ($console, $options, $arguments) {
		Assert::same([
			'flag' => TRUE,
		], $options);
	});


test(function () use ($testCommand) {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--flag=yes',
	]));
	$application->setCommand('command', $testCommand);
	$application->run();
});


test(function () use ($testCommand) {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--alias=yes',
	]));
	$application->setCommand('command', $testCommand);
	$application->run();
});


test(function () use ($testCommand) {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--alias2=yes',
	]));
	$application->setCommand('command', $testCommand);
	$application->run();
});


test(function () use ($testCommand) {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--flag=yes',
		'--alias=yes',
	]));
	$application->setCommand('command', $testCommand);

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'CzProject\PhpCli\ApplicationException', "Value for option 'flag' already exists. Remove option 'alias' from parameters.");
});


test(function () use ($testCommand) {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--alias=yes',
		'--alias2=yes',
	]));
	$application->setCommand('command', $testCommand);

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'CzProject\PhpCli\ApplicationException', "Value for option 'flag' already exists. Remove option 'alias2' from parameters.");
});
