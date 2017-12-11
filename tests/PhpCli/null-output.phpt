<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\NullOutput);

Assert::same('', printOutputStory($console));
