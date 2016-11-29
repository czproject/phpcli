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
		'--flag',
		'--option=Lorem ipsum dolor = sit amet',
		'argument',
		'argument2',
		'--flag2',
		'--flag3',
		'flag-value',
	));

	Assert::same(array(
		'flag' => TRUE,
		'option' => 'Lorem ipsum dolor = sit amet',
		'argument',
		'argument2',
		'flag2' => TRUE,
		'flag3' => 'flag-value',
	),$parser->getParameters());
});
