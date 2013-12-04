<?php
use Tester\Assert;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../loader.php';

$console = Cz\Cli\ConsoleFactory::createConsole(NULL, NULL, new Cz\Cli\Parameters\DefaultParametersParser);

$console->setRawParameters(array(
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
	0 => 'file.txt',
	'm' => 'message',
	'b' => TRUE,
	'p' => array('parameter1', 'parameter2', 'parameter3'),
	1 => 'text',
	'flag' => TRUE,
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
}, 'Cz\Cli\ParametersException', 'Required parameter \'unexists\' not found.');

