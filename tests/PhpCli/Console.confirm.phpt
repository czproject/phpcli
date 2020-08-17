<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';


// Text input (required)
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'no',
	]);

	Assert::false($console->confirm('Really?'));
	Assert::same('Really? [yes/no]: ', $outputProvider->getOutput());
});


// Input with default value
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'',
		'',
	]);

	Assert::false($console->confirm('Really?', FALSE));
	Assert::true($console->confirm('Really?', TRUE));
	Assert::same(implode('', [
		'Really? (default no) [yes/no]: ',
		'Really? (default yes) [yes/no]: ',
	]), $outputProvider->getOutput());
});


// Input with default value and invalid value
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'Fred',
		'',
	]);

	Assert::true($console->confirm('Really?', TRUE));
	Assert::same(implode('', [
		'Really? (default yes) [yes/no]: ',
		"Invalid boolean value.\n",
		'Really? (default yes) [yes/no]: ',
	]), $outputProvider->getOutput());
});


// Required input and invalid value
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'',
		'',
		'Fred',
		'100',
		'no',
	]);

	Assert::false($console->confirm('Really?'));
	Assert::same(implode('', [
		'Really? [yes/no]: ',
		'Really? [yes/no]: ',
		'Really? [yes/no]: ',
		"Invalid boolean value.\n",
		'Really? [yes/no]: ',
		"Invalid boolean value.\n",
		'Really? [yes/no]: ',
	]), $outputProvider->getOutput());
});
