<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Exception;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$output = new CzProject\PhpCli\Outputs\MemoryColoredOutputProvider;
	$console = new CzProject\PhpCli\Console(
		$output,
		new CzProject\PhpCli\Inputs\DefaultInputProvider,
		new CzProject\PhpCli\Parameters\MemoryParametersProvider([])
	);

	$application = new Application($console);
	$e = new Exception('Exception message', 404);
	$application->printException($e);

	Assert::same(implode("\n", [
		'',
		'<red>ERROR: Exception message</red>',
		'',
		'<red>Details:</red>',
		'<red> - type: CzProject\PhpCli\Exception</red>',
		'<red> - code: 404</red>',
		'<red> - file: ' . __FILE__ . '</red>',
		'<red> - line: 19</red>',
		'',
	]), $output->getOutput());
});
