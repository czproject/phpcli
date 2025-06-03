<?php

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * Empty values
 */
test(function () {
	$parser = new CzProject\PhpCli\Parameters\DefaultParametersParser;
	$parameters = $parser->parse([
		'--flag',
		'--option=Lorem ipsum dolor = sit amet',
		'argument',
		'argument2',
		'--flag2',
		'--flag3',
		'flag-value',
	]);

	Assert::same([
		'argument',
		'argument2',
	], $parameters->getArguments());

	Assert::same([
		'flag' => TRUE,
		'option' => 'Lorem ipsum dolor = sit amet',
		'flag2' => TRUE,
		'flag3' => 'flag-value',
	], $parameters->getOptions());
});
