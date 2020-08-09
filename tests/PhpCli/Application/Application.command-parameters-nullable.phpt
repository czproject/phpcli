<?php

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Nullable
 */
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\MemoryOutput);
	$application = new Application($console);
	$application->setCommand('command', Tests\TestCommand::create()
		->setOptions([
			'null-string' => [
				'type' => 'string',
				'repeatable' => FALSE,
				'nullable' => TRUE,
			],

			'null-array' => [
				'type' => 'string',
				'repeatable' => TRUE,
				'nullable' => TRUE,
			],

			'null-array2' => [
				'type' => 'string',
				'repeatable' => TRUE,
				'nullable' => TRUE,
			],

			'empty-string' => [
				'type' => 'string',
				'repeatable' => FALSE,
				'nullable' => FALSE,
			],

			'empty-array' => [
				'type' => 'string',
				'repeatable' => TRUE,
				'nullable' => TRUE,
			],

			'empty-array2' => [
				'type' => 'string',
				'repeatable' => TRUE,
				'nullable' => TRUE,
			],
		])
		->setCallback(function ($console, $options, $arguments) {
			Assert::same([
				'null-string' => NULL,
				'null-array' => [
					'',
					'',
				],
				'null-array2' => [
					'',
				],
				'empty-string' => '',
				'empty-array' => [
					'',
					'',
				],
				'empty-array2' => [
					'',
				],
			], $options);
			Assert::same([], $arguments);
		})
	);

	$application->run([
		'programName',
		'command',
		'--null-string=',
		'--null-array=',
		'--null-array=',
		'--null-array2=',
		'--empty-string=',
		'--empty-array=',
		'--empty-array=',
		'--empty-array2=',
	]);
});
