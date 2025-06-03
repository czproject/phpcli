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
		'no',
	]);

	Assert::false($console->confirm('Really?'));
	Assert::same('Really?<gray> [yes/no]</gray>: ', $outputProvider->getOutput());
});


// Input with default value
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(
		$outputProvider = new CzProject\PhpCli\Outputs\MemoryColoredOutputProvider,
		$inputProvider = new CzProject\PhpCli\Inputs\MemoryInputProvider
	);

	$inputProvider->setInputs([
		'',
		'',
	]);

	Assert::false($console->confirm('Really?', FALSE));
	Assert::true($console->confirm('Really?', TRUE));
	Assert::same(implode('', [
		'Really?<gray> (default </gray><yellow>no</yellow><gray>)</gray><gray> [yes/no]</gray>: ',
		'Really?<gray> (default </gray><yellow>yes</yellow><gray>)</gray><gray> [yes/no]</gray>: ',
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

	Assert::true($console->confirm('Really?', TRUE));
	Assert::same(implode('', [
		'Really?<gray> (default </gray><yellow>yes</yellow><gray>)</gray><gray> [yes/no]</gray>: ',
		"<red>Invalid boolean value.</red>\n",
		'Really?<gray> (default </gray><yellow>yes</yellow><gray>)</gray><gray> [yes/no]</gray>: ',
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
		'no',
	]);

	Assert::false($console->confirm('Really?'));
	Assert::same(implode('', [
		'Really?<gray> [yes/no]</gray>: ',
		'Really?<gray> [yes/no]</gray>: ',
		'Really?<gray> [yes/no]</gray>: ',
		"<red>Invalid boolean value.</red>\n",
		'Really?<gray> [yes/no]</gray>: ',
		"<red>Invalid boolean value.</red>\n",
		'Really?<gray> [yes/no]</gray>: ',
	]), $outputProvider->getOutput());
});
