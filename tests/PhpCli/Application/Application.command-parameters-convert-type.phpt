<?php

declare(strict_types=1);

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Convert type
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--bool-flag',
		'--bool-yes=YES',
		'--bool-y=y',
		'--bool-on=on',
		'--bool-true=true',
		'--bool-no=NO',
		'--bool-n=n',
		'--bool-off=off',
		'--bool-false=false',
		'--bool-string=1',
		'--integer=9854.588',
		'--float=9854.588',
		'--string=9854.588',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setParameters(function ($parameters) {
			$parameters->addOption('bool-flag', 'bool');
			$parameters->addOption('bool-yes', 'bool');
			$parameters->addOption('bool-y', 'bool');
			$parameters->addOption('bool-on', 'bool');
			$parameters->addOption('bool-true', 'bool');
			$parameters->addOption('bool-no', 'bool');
			$parameters->addOption('bool-n', 'bool');
			$parameters->addOption('bool-off', 'bool');
			$parameters->addOption('bool-false', 'bool');
			$parameters->addOption('bool-string', 'bool');
			$parameters->addOption('integer', 'int');
			$parameters->addOption('float', 'float');
			$parameters->addOption('string', 'string');
		})
		->setCallback(function ($console, $options, $arguments) {
			Assert::same([
				'bool-flag' => TRUE,
				'bool-yes' => TRUE,
				'bool-y' => TRUE,
				'bool-on' => TRUE,
				'bool-true' => TRUE,
				'bool-no' => FALSE,
				'bool-n' => FALSE,
				'bool-off' => FALSE,
				'bool-false' => FALSE,
				'bool-string' => TRUE,
				'integer' => 9854,
				'float' => 9854.588,
				'string' => '9854.588',
			], $options);
		})
	);
	$application->run();
});
