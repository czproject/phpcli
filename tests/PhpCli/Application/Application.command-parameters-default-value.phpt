<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Default value
 */
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
	$application = new Application($console);
	$application->addCommand('command', Tests\TestCommand::create()
		->setOptions(array(
			'flag-with-default' => array(
				'type' => 'string',
				'defaultValue' => FALSE,
			),
			'flag-without-default' => array(
				'type' => 'string',
			),
			'flag-value' => array(
				'type' => 'string',
			),
			'flag-default' => array(
				'type' => 'int',
				'defaultValue' => '9876.87',
				'repeatable' => TRUE,
			),
		))
		->setCallback(function ($console, $options, $arguments) {
			Assert::same(array(
				'flag-with-default' => '1',
				'flag-without-default' => '1',
				'flag-value' => '1',
				'flag-default' => array(
					9876,
				),
			), $options);
			Assert::same(array(), $arguments);
		})
	);
	$application->run(array(
		'programName',
		'command',
		'--flag-with-default',
		'--flag-without-default',
		'--flag-value',
	));
});
