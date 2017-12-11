<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Empty options & arguments
 */
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
	$application = new Application($console);
	$application->addCommand('command', Tests\TestCommand::create()
		->setCallback(function ($console, $options, $arguments) {
			Assert::same(array(), $options);
			Assert::same(array(), $arguments);
		})
	);
	$application->run(array(
		'programName',
		'command',
	));
});
