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
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--flag',
		'--flag2',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setParameters(function ($parameters) {
			$parameters->addOption('required', 'string')
				->setRequired();

			$parameters->addOption('flag', 'bool');
			$parameters->addOption('flag2', 'bool');
		})
	);

	Assert::exception(function () use ($application) {

		$application->run();

	}, CzProject\PhpCli\MissingParameterException::class, "Missing value for required option 'required'.");
});
