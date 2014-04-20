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
Assert::same("Hello! super [user]\n"
	. "I am dead...\n", str_replace("\r", '', $content));

Assert::false($falseAutoNewLine);
Assert::true($trueAutoNewLine);


ob_start();
$console->success('CzProject CLI Simple Console');
$console->warning('Hey!');
$console->info('Fred!');
$console->error('Fred is dead!');
$console->output('The end.');
$console->output(':D');
$console->output(); // gets IOutputFormatter
$content = ob_get_contents();
ob_end_clean();
Assert::same("CzProject CLI Simple Console\n"
	. "Hey!\nFred!\nFred is dead!\nThe end.\n:D\n", str_replace("\r", '', $content));
