<?php
require __DIR__ . '/../../vendor/nette/tester/Tester/bootstrap.php';

if (extension_loaded('xdebug'))
{
	Tester\CodeCoverage\Collector::start(__DIR__ . '/../coverage.dat');
}


function printOutputStory($console)
{
	ob_start();
	$console->success('CzProject', ' ', 'CLI Simple Console')
		->warning('Hey', '!')
		->info('Fred', '!')
		->error('Fred is', ' ', 'dead!')
		->muted('nooooo...', '!')
		->output('The', ' ', 'end.')
		->output(':D');
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function printOutputNewLines($console)
{
	ob_start();
	$console->setAutoNewLine(FALSE);
	$falseAutoNewLine = $console->getAutoNewLine();

	$console->info('Hello! ')
		->success('super')
		->warning(' [user]');

	$console->setAutoNewLine(TRUE);
	$trueAutoNewLine = $console->getAutoNewLine();

	$console->nl()
		->error('I am dead...');

	$content = ob_get_contents();
	ob_end_clean();

	return array($content, $falseAutoNewLine, $trueAutoNewLine);
}
