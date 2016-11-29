<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * Empty values
 */
test(function () {
	$parser = new CzProject\PhpCli\Parameters\DefaultParametersParser;

	$parser->setRawParameters(array(
		'programName',
		'',
		0,
		0.0,
		FALSE,
		TRUE,
	));

	Assert::same(array(
		0,
		0.0,
		FALSE,
		TRUE,
	),$parser->getParameters());
});


/**
 * Wrong data types - object
 */
test(function () {
	$parser = new CzProject\PhpCli\Parameters\DefaultParametersParser;

	$parser->setRawParameters(array(
		'programName',
		new stdClass,
	));

	Assert::exception(function () use ($parser) {
		$parser->getParameters();
	}, 'CzProject\PhpCli\Parameters\DefaultParametersParserException', 'Parameter must be scalar or NULL, object given at index (0).');
});
