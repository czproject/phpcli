<?php
use Tester\Assert;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../loader.php';

$console = Cz\Cli\ConsoleFactory::createConsole(new Cz\Cli\Outputs\TextOutput);

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
Assert::same("CzProject CLI Simple Console\n"
	. "Hey!\nFred!\nFred is dead!\nnooooo...!\nThe end.\n:D\n", str_replace("\r", '', $content));


ob_start();
$console->setAutoNewLine(FALSE)
	->info('Hello! ')
	->success('super')
	->warning(' [user]')
	->setAutoNewLine(TRUE)
	->nl()
	->error('I am dead...');

$content = ob_get_contents();
ob_end_clean();
Assert::same("Hello! super [user]\n"
	. "I am dead...\n", str_replace("\r", '', $content));

