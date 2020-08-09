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
		->setOptions([
			'bool-flag' => [
				'type' => 'bool',
			],

			'bool-yes' => [
				'type' => 'bool',
			],

			'bool-y' => [
				'type' => 'bool',
			],

			'bool-on' => [
				'type' => 'bool',
			],

			'bool-true' => [
				'type' => 'bool',
			],

			'bool-no' => [
				'type' => 'bool',
			],

			'bool-n' => [
				'type' => 'bool',
			],

			'bool-off' => [
				'type' => 'bool',
			],

			'bool-false' => [
				'type' => 'bool',
			],

			'bool-string' => [
				'type' => 'bool',
			],

			'integer' => [
				'type' => 'int',
			],

			'float' => [
				'type' => 'float',
			],

			'string' => [
				'type' => 'string',
			],
		])
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
	$application->run([
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
	]);
});
