<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';


// Text output
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\TextOutputProvider);

	Assert::same("CzProject CLI Simple Console\n"
	. "Hey!\nFred!\nFred is dead!\nnooooo...!\nThe end.\n:D\n", str_replace("\r", '', printOutputStory($console)));
});


// Null output
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\NullOutputProvider);

	Assert::same('', printOutputStory($console));
});


// Colored output
test(function () {
	$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\ColoredOutputProvider);

	Assert::same("\033[0;32mCzProject CLI Simple Console\033[0m\n"
		. "\033[0;33mHey!\033[0m\n"
		. "\033[0;34mFred!\033[0m\n"
		. "\033[0;31mFred is dead!\033[0m\n"
		. "\033[1;30mnooooo...!\033[0m\n"
		. "The end.\n:D\n", str_replace("\r", '', printOutputStory($console)));
});
