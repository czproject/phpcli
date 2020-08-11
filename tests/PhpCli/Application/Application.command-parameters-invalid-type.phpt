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
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setOptions([
			'required' => [
				'type' => 'unexpected',
			],
		])
	);

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'CzProject\PhpCli\ApplicationException', "Unknow type 'unexpected' in definition for option 'required'.");
});
