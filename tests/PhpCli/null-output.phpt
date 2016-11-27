<?php

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = CzProject\PhpCli\ConsoleFactory::createConsole(new CzProject\PhpCli\Outputs\NullOutput);

Assert::same('', printOutputStory($console));


list($content, $falseAutoNewLine, $trueAutoNewLine) = printOutputNewLines($console);

Assert::same('', $content);

Assert::false($falseAutoNewLine);
Assert::true($trueAutoNewLine);
