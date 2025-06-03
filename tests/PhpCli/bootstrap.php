<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/includes/TestCommand.php';
require __DIR__ . '/includes/TestConsoleFactory.php';

Tester\Environment::setup();


function printOutputStory($console)
{
	ob_start();
	$console->output(['CzProject', ' ', 'CLI Simple Console'], 'green')
		->nl()
		->output(['Hey', '!'], 'yellow')
		->nl()
		->output(['Fred', '!'], 'blue')
		->nl()
		->output(['Fred is', ' ', 'dead!'], 'red')
		->nl()
		->output(['nooooo...', '!'], 'gray')
		->nl()
		->output(['The', ' ', 'end.'])
		->nl()
		->output([':D'])
		->nl();
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}


function test($cb)
{
	$cb();
}
