<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Application\ICommand;
use CzProject\PhpCli\Console;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
	$application = new Application($console);

	Assert::exception(function () use ($application) {

		$application->run(array(
			'programName',
			'--flag',
		));

	}, 'CzProject\PhpCli\ApplicationException', 'Missing command name.');
});