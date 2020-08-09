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
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);

	$application = new Application($console);
	$application->setCommand('command', Tests\TestCommand::create()
		->setOptions([
			'required' => [
				'required' => TRUE,
			],
		])
	);

	Assert::exception(function () use ($application) {

		$application->run([
			'programName',
			'command',
		]);

	}, 'CzProject\PhpCli\ApplicationException', "Missing 'type' definition for option 'required'.");
});
