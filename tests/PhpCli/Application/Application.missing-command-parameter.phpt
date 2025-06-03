<?php

declare(strict_types=1);

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Application\ICommand;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'--flag',
	]));

	Assert::exception(function () use ($application) {

		$application->run();

	}, CzProject\PhpCli\ApplicationException::class, 'Missing command name.');
});
