<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli\Inputs;
	use Cz\Cli\IInputProvider;
	
	class DefaultInputProvider implements IInputProvider
	{
		public function readInput()
		{
			// see http://www.php-trivandrum.org/code-snippets/user-input-in-php-command-line/
			// see http://wiki.uniformserver.com/index.php/PHP_CLI:_User_Input#fgets.28.29_-_Problem
			return trim(fgets(STDIN));
		}
		
		
		
		public static function isPrintingPrompt()
		{
			return FALSE;
		}
	}

