<?php

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/bootstrap.php';


// Text input
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryColoredOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'Fred',
	]);

	Assert::same('Fred', $console->input('Your name:'));
	Assert::same('Your name: ', $outputProvider->getOutput());
});


// Input with default value
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryColoredOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'',
	]);

	Assert::same('1000', $console->input('Your name:', 1000));
	Assert::same('Your name<gray> (default </gray><yellow>1000</yellow><gray>)</gray>: ', $outputProvider->getOutput());
});


// Required input
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryColoredOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'',
		'',
		'Fred',
	]);

	Assert::same('Fred', $console->input('Your name:'));
	Assert::same(implode('', [
		'Your name: ',
		'Your name: ',
		'Your name: ',
	]), $outputProvider->getOutput());
});
