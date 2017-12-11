<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$output = new CzProject\PhpCli\Outputs\MemoryOutput;
	$console = CzProject\PhpCli\ConsoleFactory::createConsole($output);

	$application = new Application($console);
	$application->setApplicationName('APP NAME');
	$application->addCommand('help', Tests\TestCommand::create()->setDescription('prints help'));
	$application->addCommand('generate', Tests\TestCommand::create()->setDescription('generates output'));
	$application->addCommand('test', Tests\TestCommand::create());
	$application->run(array('programName'));

	Assert::same(implode("\n", array(
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
	)), $output->getOutput());
});
