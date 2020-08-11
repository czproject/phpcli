<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$parser = new CzProject\PhpCli\Parameters\DefaultParametersParser;
$parameters = $parser->parse([
	'file.txt',
	'-m', 'message',
	'-b',
	'-p', 'parameter1', 'newparam',
	'-p', 'parameter2',
	'text',
	'-p', 'parameter3',
	'--flag',
	'--trim--',
	'--',
	'argument',
]);

Assert::same([
	0 => 'file.txt',
	1 => 'newparam',
	2 => 'text',
	3 => 'argument',
], $parameters->getArguments());

Assert::same([
	'm' => 'message',
	'b' => TRUE,
	'p' => ['parameter1', 'parameter2', 'parameter3'],
	'flag' => TRUE,
	'trim--' => TRUE,
], $parameters->getOptions());
