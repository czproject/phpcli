<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\ColoredOutput);

Assert::same("\033[0;32mCzProject CLI Simple Console\033[0m\n"
	. "\033[0;33mHey!\033[0m\n"
	. "\033[0;34mFred!\033[0m\n"
	. "\033[0;31mFred is dead!\033[0m\n"
	. "\033[1;30mnooooo...!\033[0m\n"
	. "The end.\n:D\n", str_replace("\r", '', printOutputStory($console)));
