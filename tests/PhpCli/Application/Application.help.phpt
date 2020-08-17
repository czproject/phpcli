<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Tests;
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
	$application->setApplicationName('APP NAME');
	$application->setCommand('help', Tests\TestCommand::create()->setDescription('prints help'));
	$application->setCommand('generate', Tests\TestCommand::create()->setDescription('generates output'));
	$application->setCommand('test', Tests\TestCommand::create());
	$application->run(['programName']);

	Assert::same(implode("\n", [
		'',
		'APP NAME',
		'',
		'<yellow>Usage:</yellow>',
		'  command [options] -- [arguments]',
		'',
		'<yellow>Available commands:</yellow>',
		'  <green>help</green>      prints help',
		'  <green>generate</green>  generates output',
		'  <green>test</green>',
		'',
		'',
	]), $output->getOutput());
});
