<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Required option
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--flag',
		'--flag2',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setOptions([
			'required' => [
				'type' => 'string',
				'required' => TRUE,
			],
			'flag' => [
				'type' => 'bool',
			],
			'flag2' => [
				'type' => 'bool',
			],
		])
	);

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'CzProject\PhpCli\ApplicationException', "Missing value for required option 'required'.");
});
