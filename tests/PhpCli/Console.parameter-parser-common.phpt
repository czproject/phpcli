<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(NULL, NULL, new CzProject\PhpCli\Parameters\DefaultParameterParser);

$console->addParameters(array(
	'm' => 'default message',
	'flag' => FALSE,
	'flag2' => FALSE,
));

$console->addRawParameters(array(
	'programName',
	'file.txt',
	'-m', 'message',
	'-b',
	'-p', 'parameter1',
	'-p', 'parameter2',
	'text',
	'-p', 'parameter3',
	'--flag',
));

Assert::same(array(
	'm' => 'message',
	'flag' => TRUE,
	'flag2' => FALSE,
	0 => 'file.txt',
	'b' => TRUE,
	'p' => array('parameter1', 'parameter2', 'parameter3'),
	1 => 'text',
), $console->getParameters());

Assert::same('file.txt', $console->getParameter(0));
Assert::same('message', $console->getParameter('m'));
Assert::true($console->getParameter('b'));
Assert::same(array('parameter1', 'parameter2', 'parameter3'), $console->getParameter('p'));
Assert::true($console->getParameter('flag'));


// unexists parameters
Assert::same('my-default-value', $console->getParameter('unexists', 'my-default-value'));

Assert::null($console->getParameter('unexists'));

Assert::exception(function () use ($console) {
	$console->getParameter('unexists', 'my-default-value', TRUE);
}, 'CzProject\PhpCli\MissingParameterException', 'Required parameter \'unexists\' not found.');
