<?php

declare(strict_types=1);

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Undefined options
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'argument',
		'--flag',
		'--flag2',
	]));
	$application->setCommand('command', Tests\TestCommand::create());

	Assert::exception(function () use ($application) {

		$application->run();

	}, CzProject\PhpCli\ApplicationException::class, "Unknow options 'flag', 'flag2'.");
});
