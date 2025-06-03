<?php

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/bootstrap.php';


// Text input (required)
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryColoredOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'2',
	]);

	Assert::same('#00ff00', $console->select('Select color:', [
		'#ff0000' => 'Red',
		'#00ff00' => 'Green',
		'#0000ff' => 'Blue',
	]));
	Assert::same(implode('', [
		"Select color:\n",
		" > <yellow>1) </yellow>Red\n",
		" > <yellow>2) </yellow>Green\n",
		" > <yellow>3) </yellow>Blue\n",
		'Your choose: ',
	]), $outputProvider->getOutput());
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

	Assert::same('#0000ff', $console->select('Select color:', [
		'#ff0000' => 'Red',
		'#00ff00' => 'Green',
		'#0000ff' => 'Blue',
	], '#0000ff'));
	Assert::same(implode('', [
		"Select color:\n",
		" > <yellow>1) </yellow>Red\n",
		" > <yellow>2) </yellow>Green\n",
		" > <yellow>3) </yellow>Blue\n",
		'Your choose<gray> (default </gray><yellow>3) Blue</yellow><gray>)</gray>: ',
	]), $outputProvider->getOutput());
});


// Input with default value and invalid value
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryColoredOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'Fred',
		'',
	]);

	Assert::same('#0000ff', $console->select('Select color:', [
		'#ff0000' => 'Red',
		'#00ff00' => 'Green',
		'#0000ff' => 'Blue',
	], '#0000ff'));
	Assert::same(implode('', [
		"Select color:\n",
		" > <yellow>1) </yellow>Red\n",
		" > <yellow>2) </yellow>Green\n",
		" > <yellow>3) </yellow>Blue\n",
		'Your choose<gray> (default </gray><yellow>3) Blue</yellow><gray>)</gray>: ',
		'Your choose<gray> (default </gray><yellow>3) Blue</yellow><gray>)</gray>: ',
	]), $outputProvider->getOutput());
});


// Required input and invalid value
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryColoredOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'',
		'',
		'Fred',
		'100',
		'1',
	]);

	Assert::same('#ff0000', $console->select('Select color:', [
		'#ff0000' => 'Red',
		'#00ff00' => 'Green',
		'#0000ff' => 'Blue',
	]));
	Assert::same(implode('', [
		"Select color:\n",
		" > <yellow>1) </yellow>Red\n",
		" > <yellow>2) </yellow>Green\n",
		" > <yellow>3) </yellow>Blue\n",
		'Your choose: ',
		'Your choose: ',
		'Your choose: ',
		'Your choose: ',
		'Your choose: ',
	]), $outputProvider->getOutput());
});
