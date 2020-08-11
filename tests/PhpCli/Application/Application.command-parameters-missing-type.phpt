<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Missing type
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setOptions([
			'required' => [
				'required' => TRUE,
			],
		])
	);

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'CzProject\PhpCli\ApplicationException', "Missing 'type' definition for option 'required'.");
});
