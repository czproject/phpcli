<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * Empty values
 */
test(function () {
	$parser = new CzProject\PhpCli\Parameters\DefaultParameterParser;

	Assert::same(array(
		0,
		0.0,
		FALSE,
		TRUE,
	), $parser->parse(array(
		'programName',
		'',
		0,
		0.0,
		FALSE,
		TRUE,
	)));
});


/**
 * Wrong data types - object
 */
test(function () {
	Assert::exception(function () {

		$parser = new CzProject\PhpCli\Parameters\DefaultParameterParser;
		$parser->parse(array(
			'programName',
			new stdClass,
		));

	}, 'CzProject\PhpCli\ParameterParserException', 'Parameter must be scalar or NULL, object given at index (0).');
});
