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
		'2',
	]);

	Assert::same('#00ff00', $console->select('Select color:', [
		'#ff0000' => 'Red',
		'#00ff00' => 'Green',
		'#0000ff' => 'Blue',
	]));
	Assert::same(implode('', [
		"Select color:\n",
		" > 1) Red\n",
		" > 2) Green\n",
		" > 3) Blue\n",
		'Your choose: ',
	]), $outputProvider->getOutput());
});


// Input with default value
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryOutputProvider,
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
		" > 1) Red\n",
		" > 2) Green\n",
		" > 3) Blue\n",
		'Your choose (default 3) Blue): ',
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

	Assert::same('#0000ff', $console->select('Select color:', [
		'#ff0000' => 'Red',
		'#00ff00' => 'Green',
		'#0000ff' => 'Blue',
	], '#0000ff'));
	Assert::same(implode('', [
		"Select color:\n",
		" > 1) Red\n",
		" > 2) Green\n",
		" > 3) Blue\n",
		'Your choose (default 3) Blue): ',
		'Your choose (default 3) Blue): ',
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
		'1',
	]);

	Assert::same('#ff0000', $console->select('Select color:', [
		'#ff0000' => 'Red',
		'#00ff00' => 'Green',
		'#0000ff' => 'Blue',
	]));
	Assert::same(implode('', [
		"Select color:\n",
		" > 1) Red\n",
		" > 2) Green\n",
		" > 3) Blue\n",
		'Your choose: ',
		'Your choose: ',
		'Your choose: ',
		'Your choose: ',
		'Your choose: ',
	]), $outputProvider->getOutput());
});
