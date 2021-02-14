<?php

	namespace CzProject\PhpCli\Inputs;

	use CzProject\PhpCli\Helpers;
	use CzProject\PhpCli\IInputProvider;


	class DefaultInputProvider implements IInputProvider
	{
		public function readInput()
		{
			// see http://www.php-trivandrum.org/code-snippets/user-input-in-php-command-line/
			// see http://wiki.uniformserver.com/index.php/PHP_CLI:_User_Input#fgets.28.29_-_Problem
			return Helpers::normalizeInput((string) fgets(STDIN));
		}
	}
