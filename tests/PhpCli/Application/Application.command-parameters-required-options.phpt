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
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
	$application = new Application($console);
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

		$application->run([
			'programName',
			'command',
			'--flag',
			'--flag2',
		]);

	}, 'CzProject\PhpCli\ApplicationException', "Missing value for required option 'required'.");
});
