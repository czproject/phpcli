<?php
use Tester\Assert;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../loader.php';

$console = Cz\Cli\ConsoleFactory::createConsole(new Cz\Cli\Outputs\NullOutput);

ob_start();
$console->success('CzProject CLI Simple Console')
	->warning('Hey!')
	->info('Fred!')
	->error('Fred is dead!')
	->muted('nooooo...!')
	->output('The end.')
	->output(':D');
$content = ob_get_contents();
ob_end_clean();
Assert::same('', $content);


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
Assert::same('', $content);

Assert::false($falseAutoNewLine);
Assert::true($trueAutoNewLine);

