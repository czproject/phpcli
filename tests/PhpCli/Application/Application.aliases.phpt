<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
$application = new Application($console);
$application->setCommand('command', Tests\TestCommand::create()
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
	})
);


test(function () use ($application) {
	$application->run([
		'programName',
		'command',
		'--flag=yes',
	]);
});


test(function () use ($application) {
	$application->run([
		'programName',
		'command',
		'--alias=yes',
	]);
});


test(function () use ($application) {
	$application->run([
		'programName',
		'command',
		'--alias2=yes',
	]);
});


test(function () use ($application) {
	Assert::exception(function () use ($application) {

		$application->run([
			'programName',
			'command',
			'--flag=yes',
			'--alias=yes',
		]);

	}, 'CzProject\PhpCli\ApplicationException', "Value for option 'flag' already exists. Remove option 'alias' from parameters.");
});


test(function () use ($application) {
	Assert::exception(function () use ($application) {

		$application->run([
			'programName',
			'command',
			'--alias=yes',
			'--alias2=yes',
		]);

	}, 'CzProject\PhpCli\ApplicationException', "Value for option 'flag' already exists. Remove option 'alias2' from parameters.");
});
