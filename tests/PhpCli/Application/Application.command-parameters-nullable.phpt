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
	$application->addCommand('command', Tests\TestCommand::create()
		->setOptions(array(
			'null-string' => array(
				'type' => 'string',
				'repeatable' => FALSE,
				'nullable' => TRUE,
			),

			'null-array' => array(
				'type' => 'string',
				'repeatable' => TRUE,
				'nullable' => TRUE,
			),

			'null-array2' => array(
				'type' => 'string',
				'repeatable' => TRUE,
				'nullable' => TRUE,
			),

			'empty-string' => array(
				'type' => 'string',
				'repeatable' => FALSE,
				'nullable' => FALSE,
			),

			'empty-array' => array(
				'type' => 'string',
				'repeatable' => TRUE,
				'nullable' => TRUE,
			),

			'empty-array2' => array(
				'type' => 'string',
				'repeatable' => TRUE,
				'nullable' => TRUE,
			),
		))
		->setCallback(function ($console, $options, $arguments) {
			Assert::same(array(
				'null-string' => NULL,
				'null-array' => array(
					'',
					'',
				),
				'null-array2' => array(
					'',
				),
				'empty-string' => '',
				'empty-array' => array(
					'',
					'',
				),
				'empty-array2' => array(
					'',
				),
			), $options);
			Assert::same(array(), $arguments);
		})
	);

	$application->run(array(
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
	));
});
