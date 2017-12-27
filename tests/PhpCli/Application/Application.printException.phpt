<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Exception;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$output = new CzProject\PhpCli\Outputs\MemoryOutput;
	$console = CzProject\PhpCli\ConsoleFactory::createConsole($output);

	$application = new Application($console);
	$e = new Exception('Exception message', 404);
	$application->printException($e);

	Assert::same(implode("\n", array(
		'',
		'ERROR: Exception message',
		'',
		'Details:',
		' - type: CzProject\PhpCli\Exception',
		' - code: 404',
		' - file: ' . __FILE__,
		' - line: 15',
		'',
	)), $output->getOutput());
});