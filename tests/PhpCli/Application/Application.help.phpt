<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$output = new CzProject\PhpCli\Outputs\MemoryOutputProvider;
	$console = new CzProject\PhpCli\Console(
		$output,
		new CzProject\PhpCli\Inputs\DefaultInputProvider,
		new CzProject\PhpCli\Parameters\MemoryParametersProvider([])
	);

	$application = new Application($console);
	$application->setApplicationName('APP NAME');
	$application->setCommand('help', Tests\TestCommand::create()->setDescription('prints help'));
	$application->setCommand('generate', Tests\TestCommand::create()->setDescription('generates output'));
	$application->setCommand('test', Tests\TestCommand::create());
	$application->run(['programName']);

	Assert::same(implode("\n", [
		'',
		'APP NAME',
		'',
		'Usage:',
		'  command [options] -- [arguments]',
		'',
		'Available commands:',
		'  help      prints help',
		'  generate  generates output',
		'  test',
		'',
		'',
	]), $output->getOutput());
});
