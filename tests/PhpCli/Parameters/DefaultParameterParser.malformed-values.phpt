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
		'',
		0,
		0.0,
		FALSE,
		TRUE,
	]);

	Assert::same([
		0,
		0.0,
		FALSE,
		TRUE,
	], $parameters->getArguments());

	Assert::same([], $parameters->getOptions());
});


/**
 * Wrong data types - object
 */
test(function () {
	Assert::exception(function () {

		$parser = new CzProject\PhpCli\Parameters\DefaultParametersParser;
		$parser->parse([
			new stdClass,
		]);

	}, CzProject\PhpCli\ParametersParserException::class, 'Parameter must be scalar or NULL, object given at index (0).');
});
