<?php

declare(strict_types=1);

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

	Assert::exception(function () use ($application) {
		$application->setCommand('command', Tests\TestCommand::create()
			->setParameters(function ($parameters) {
				$parameters->addOption('required', 'unexpected');
			})
		);

	}, CzProject\PhpCli\ApplicationException::class, "Option 'required': Unknow type 'unexpected'.");
});
