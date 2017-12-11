<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * Empty values
 */
test(function () {
	$parser = new CzProject\PhpCli\Parameters\DefaultParameterParser;

	Assert::same(array(
		'flag' => TRUE,
		'option' => 'Lorem ipsum dolor = sit amet',
		'argument',
		'argument2',
		'flag2' => TRUE,
		'flag3' => 'flag-value',
	), $parser->parse(array(
		'programName',
		'--flag',
		'--option=Lorem ipsum dolor = sit amet',
		'argument',
		'argument2',
		'--flag2',
		'--flag3',
		'flag-value',
	)));
});
