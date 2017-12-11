<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Application\ICommand;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
$application = new Application($console);
$application->setDefaultCommand('default');


test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
	$application = new Application($console);
	$application->setDefaultCommand('default');
	$application->addCommand('default', Tests\TestCommand::create()
		->setOptions(array(
			'run' => array(
				'type' => 'bool',
				'defaultValue' => FALSE,
			),
		))
		->setCallback(function () {
			throw new \RuntimeException('COMMAND: default');
		})
	);

	Assert::exception(function () use ($application) {

		$application->run(array(
			'programName',
			'--run',
		));

	}, 'RuntimeException', 'COMMAND: default');
});


test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\TextOutput);
	$application = new Application($console);
	$application->setDefaultCommand('default');
	$application->addCommand('default', Tests\TestCommand::create()
		->setCallback(function () {
			throw new \RuntimeException('COMMAND: default');
		})
	);
	$application->addCommand('test', Tests\TestCommand::create()
		->setCallback(function () {
			throw new \RuntimeException('COMMAND: test');
		})
	);

	Assert::exception(function () use ($application) {

		$application->run(array(
			'programName',
			'test',
		));

	}, 'RuntimeException', 'COMMAND: test');
});
