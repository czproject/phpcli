<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli\Inputs;
	use Cz\Cli\IInputProvider;
	
	class ReadlineInputProvider implements IInputProvider
	{
		public function readInput()
		{
			$input = readline();
			readline_add_history($input);
			return trim($input);
		}
	}

