<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Arguments
 */
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
	$application = new Application($console);
	$application->addCommand('command', Tests\TestCommand::create()
		->setOptions(array(
			'flag' => array(
				'type' => 'bool',
			),
		))
		->setCallback(function ($console, $options, $arguments) {
			Assert::same(array(
				'flag' => TRUE,
			), $options);

			Assert::same(array(
				0 => 'argument1',
				1 => 'argument2',
				2 => 'argument3',
			), $arguments);
		})
	);

	$application->run(array(
		'programName',
		'command',
		'argument1',
		'argument2',
		'--flag',
		'--',
		'argument3',
	));
});
