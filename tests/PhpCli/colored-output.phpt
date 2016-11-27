<?php
use Tester\Assert;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../../loader.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\ColoredOutput);

Assert::same("\033[0;32mCzProject CLI Simple Console\n\033[0m"
	. "\033[0;33mHey!\n\033[0m"
	. "\033[0;34mFred!\n\033[0m"
	. "\033[0;31mFred is dead!\n\033[0m"
	. "\033[1;30mnooooo...!\n\033[0m"
	. "The end.\n:D\n", str_replace("\r", '', printOutputStory($console)));


list($content, $falseAutoNewLine, $trueAutoNewLine) = printOutputNewLines($console);

Assert::same("\033[0;34mHello! \033[0m"
	. "\033[0;32msuper\033[0m"
	. "\033[0;33m [user]\033[0m"
	. "\n"
	. "\033[0;31mI am dead...\n\033[0m", str_replace("\r", '', $content));

Assert::false($falseAutoNewLine);
Assert::true($trueAutoNewLine);

