<?php
use Tester\Assert;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../loader.php';

$console = Cz\Cli\ConsoleFactory::createConsole(new Cz\Cli\Outputs\ColoredOutput);

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
Assert::same("\033[0;32mCzProject CLI Simple Console\n\033[0m"
	. "\033[0;33mHey!\n\033[0m"
	. "\033[0;34mFred!\n\033[0m"
	. "\033[0;31mFred is dead!\n\033[0m"
	. "\033[1;30mnooooo...!\n\033[0m"
	. "The end.\n:D\n", str_replace("\r", '', $content));


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
Assert::same("\033[0;34mHello! \033[0m"
	. "\033[0;32msuper\033[0m"
	. "\033[0;33m [user]\033[0m"
	. "\n"
	. "\033[0;31mI am dead...\n\033[0m", str_replace("\r", '', $content));

Assert::false($falseAutoNewLine);
Assert::true($trueAutoNewLine);

