<?php

	namespace CzProject\PhpCli\Inputs;

	use CzProject\PhpCli\Helpers;
	use CzProject\PhpCli\IInputProvider;


	class ReadlineInputProvider implements IInputProvider
	{
		public function readInput()
		{
			$input = Helpers::normalizeInput(readline());

			if ($input !== '') {
				readline_add_history($input);
			}

			return $input;
		}
	}
