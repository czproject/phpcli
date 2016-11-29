<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$parser = new CzProject\PhpCli\Parameters\DefaultParametersParser;

$parser->setRawParameters(array(
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
));

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
), $parser->getParameters());

Assert::same('file.txt', $parser->getParameter(0));
Assert::same('message', $parser->getParameter('m'));
Assert::true($parser->getParameter('b'));
Assert::same(array('parameter1', 'parameter2', 'parameter3'), $parser->getParameter('p'));
Assert::true($parser->getParameter('flag'));


// unexists parameters
Assert::same('my-default-value', $parser->getParameter('unexists', 'my-default-value'));

Assert::null($parser->getParameter('unexists'));

Assert::exception(function () use ($parser) {
	$parser->getParameter('unexists', 'my-default-value', TRUE);
}, 'CzProject\PhpCli\ParametersException', 'Required parameter \'unexists\' not found.');
