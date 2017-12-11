<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\TextOutput);

Assert::same("CzProject CLI Simple Console\n"
	. "Hey!\nFred!\nFred is dead!\nnooooo...!\nThe end.\n:D\n", str_replace("\r", '', printOutputStory($console)));
