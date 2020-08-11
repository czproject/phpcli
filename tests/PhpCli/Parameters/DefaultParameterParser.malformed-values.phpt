<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * Empty values
 */
test(function () {
	$parser = new CzProject\PhpCli\Parameters\DefaultParameterParser;
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

		$parser = new CzProject\PhpCli\Parameters\DefaultParameterParser;
		$parser->parse([
			new stdClass,
		]);

	}, 'CzProject\PhpCli\ParameterParserException', 'Parameter must be scalar or NULL, object given at index (0).');
});
