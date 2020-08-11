<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/includes/TestCommand.php';
require __DIR__ . '/includes/TestConsoleFactory.php';

Tester\Environment::setup();


function printOutputStory($console)
{
	ob_start();
	$console->success('CzProject', ' ', 'CLI Simple Console')
		->nl()
		->warning('Hey', '!')
		->nl()
		->info('Fred', '!')
		->nl()
		->error('Fred is', ' ', 'dead!')
		->nl()
		->muted('nooooo...', '!')
		->nl()
		->output('The', ' ', 'end.')
		->nl()
		->output(':D')
		->nl();
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}


function test($cb)
{
	$cb();
}
