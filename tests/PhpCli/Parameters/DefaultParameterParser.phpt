<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$parser = new CzProject\PhpCli\Parameters\DefaultParameterParser;

Assert::same(array(
	0 => 'file.txt',
	'm' => 'message',
	'b' => TRUE,
	'p' => array('parameter1', 'parameter2', 'parameter3'),
	1 => 'newparam',
	2 => 'text',
	'flag' => TRUE,
	'trim--' => TRUE,
	3 => 'argument',
), $parser->parse(array(
	'programName',
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
)));
