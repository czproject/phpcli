<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Application\ICommand;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'unknow',
	]));

	Assert::exception(function () use ($application) {

		$application->run();

	}, 'CzProject\PhpCli\ApplicationException', "Unknow command 'unknow'.");
});
