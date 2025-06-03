<?php

declare(strict_types=1);

use CzProject\PhpCli\Application\Application;
use CzProject\PhpCli\Console;
use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * Nullable
 */
test(function () {
	$application = new Application(Tests\TestConsoleFactory::create([
		'command',
		'--null-string=',
		'--null-array=',
		'--null-array=',
		'--null-array2=',
		'--empty-string=',
		'--empty-array=',
		'--empty-array=',
		'--empty-array2=',
	]));
	$application->setCommand('command', Tests\TestCommand::create()
		->setParameters(function ($parameters) {
			$parameters->addOption('null-string', 'string')
				->setRepeatable(FALSE)
				->setNullable();

			$parameters->addOption('null-array', 'string')
				->setRepeatable()
				->setNullable();

			$parameters->addOption('null-array2', 'string')
				->setRepeatable()
				->setNullable();

			$parameters->addOption('empty-string', 'string')
				->setRepeatable(FALSE)
				->setNullable(FALSE);

			$parameters->addOption('empty-array', 'string')
				->setRepeatable()
				->setNullable();

			$parameters->addOption('empty-array2', 'string')
				->setRepeatable()
				->setNullable();
		})
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

	$application->run();
});
