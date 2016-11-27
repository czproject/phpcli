<?php
use Tester\Assert;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../loader.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\TextOutput);

Assert::same("CzProject CLI Simple Console\n"
	. "Hey!\nFred!\nFred is dead!\nnooooo...!\nThe end.\n:D\n", str_replace("\r", '', printOutputStory($console)));


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

