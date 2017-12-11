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
	$application->addCommand('command', Tests\TestCommand::create()
		->setOptions(array(
			'required' => array(
				'type' => 'string',
				'required' => TRUE,
			),
			'flag' => array(
				'type' => 'bool',
			),
			'flag2' => array(
				'type' => 'bool',
			),
		))
	);

	Assert::exception(function () use ($application) {

		$application->run(array(
			'programName',
			'command',
			'--flag',
			'--flag2',
		));

	}, 'CzProject\PhpCli\ApplicationException', "Missing value for required option 'required'.");
});
