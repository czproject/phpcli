<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Convert type
 */
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
	$application = new Application($console);
	$application->setCommand('command', Tests\TestCommand::create()
		->setOptions(array(
			'bool-flag' => array(
				'type' => 'bool',
			),

			'bool-yes' => array(
				'type' => 'bool',
			),

			'bool-y' => array(
				'type' => 'bool',
			),

			'bool-on' => array(
				'type' => 'bool',
			),

			'bool-true' => array(
				'type' => 'bool',
			),

			'bool-no' => array(
				'type' => 'bool',
			),

			'bool-n' => array(
				'type' => 'bool',
			),

			'bool-off' => array(
				'type' => 'bool',
			),

			'bool-false' => array(
				'type' => 'bool',
			),

			'bool-string' => array(
				'type' => 'bool',
			),

			'integer' => array(
				'type' => 'int',
			),

			'float' => array(
				'type' => 'float',
			),

			'string' => array(
				'type' => 'string',
			),
		))
		->setCallback(function ($console, $options, $arguments) {
			Assert::same(array(
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
			), $options);
		})
	);
	$application->run(array(
		'programName',
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
	));
});
