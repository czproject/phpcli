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
	->output('The end.')
	->output(':D');
$content = ob_get_contents();
ob_end_clean();
Assert::same("CzProject CLI Simple Console\n"
	. "Hey!\nFred!\nFred is dead!\nThe end.\n:D\n", str_replace("\r", '', $content));


ob_start();
$console->nl(FALSE)
	->info('Hello! ')
	->success('super')
	->warning(' [user]')
	->nl(TRUE)
	->nl()
	->error('I am dead...');

$content = ob_get_contents();
ob_end_clean();
Assert::same("Hello! super [user]\n"
	. "I am dead...\n", str_replace("\r", '', $content));

