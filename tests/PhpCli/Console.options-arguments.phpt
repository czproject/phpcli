<?php

use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = Tests\TestConsoleFactory::create([
	'file.txt',
	'-m', 'message',
	'-b',
	'-p', 'parameter1',
	'-p', 'parameter2',
	'text',
	'-p', 'parameter3',
	'--flag',
]);

Assert::same([
	0 => 'file.txt',
	1 => 'text',
], $console->getParameters()->getArguments());

Assert::same([
	'm' => 'message',
	'b' => TRUE,
	// 'flag2' => FALSE,
	'p' => ['parameter1', 'parameter2', 'parameter3'],
	'flag' => TRUE,
], $console->getParameters()->getOptions());

Assert::same('file.txt', $console->getArgument(0)->getValue());
Assert::same('message', $console->getOption('m')->getValue());
Assert::true($console->getOption('b', 'bool')->getValue());
Assert::same(['parameter1', 'parameter2', 'parameter3'], $console->getOption('p')
	->setRepeatable()
	->getValue()
);
Assert::true($console->getOption('flag', 'bool')->getValue());


// unexists parameters
Assert::same('my-default-value', $console->getOption('unexists')
	->setDefaultValue('my-default-value')
	->getValue()
);

Assert::null($console->getOption('unexists')->getValue());

Assert::exception(function () use ($console) {
	$console->getOption('unexists')
		->setRequired()
		->getValue();
}, CzProject\PhpCli\MissingParameterException::class, 'Missing value for required option \'unexists\'.');
