<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Invalid type
 */
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);

	$application = new Application($console);
	$application->setCommand('command', Tests\TestCommand::create()
		->setOptions(array(
			'required' => array(
				'type' => 'unexpected',
			),
		))
	);

	Assert::exception(function () use ($application) {

		$application->run(array(
			'programName',
			'command',
		));

	}, 'CzProject\PhpCli\ApplicationException', "Unknow type 'unexpected' in definition for option 'required'.");
});
