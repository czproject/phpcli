<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\TextOutput);

Assert::same("CzProject CLI Simple Console\n"
	. "Hey!\nFred!\nFred is dead!\nnooooo...!\nThe end.\n:D\n", str_replace("\r", '', printOutputStory($console)));


list($content, $falseAutoNewLine, $trueAutoNewLine) = printOutputNewLines($console);

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
