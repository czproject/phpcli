<?php
	/**
	 * Cz CLI Console
	 * @author Jan Pecha, <janpecha@email.cz>
	 */

	namespace CzProject\PhpCli\Inputs;
	use CzProject\PhpCli\IInputProvider;

	class ReadlineInputProvider implements IInputProvider
	{
		public function readInput($prompt = NULL)
		{
			$input = '';

			if($prompt === NULL)
			{
				$input = readline();
			}
			else
			{
				$input = readline("$prompt ");
			}

			readline_add_history($input);
			return trim($input);
		}



		public function isPrintingPrompt()
		{
			return TRUE;
		}
	}

