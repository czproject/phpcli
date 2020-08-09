<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Undefined options
 */
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);

	$application = new Application($console);
	$application->setCommand('command', Tests\TestCommand::create());

	Assert::exception(function () use ($application) {
		$application->run([
			'programName',
			'command',
			'argument',
			'--flag',
			'--flag2',
		]);
	}, 'CzProject\PhpCli\ApplicationException', "Unknow options 'flag', 'flag2'.");
});
