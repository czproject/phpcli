<?php

namespace CzProject\PhpCli\Tests;

use CzProject\PhpCli;


class TestConsoleFactory
{
	public static function create(array $rawParameters)
	{
		return new PhpCli\Console(
			new PhpCli\Outputs\NullOutputProvider,
			new PhpCli\Inputs\DefaultInputProvider,
			new PhpCli\Parameters\MemoryParametersProvider($rawParameters)
		);
	}
}
