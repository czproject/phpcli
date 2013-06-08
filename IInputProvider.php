<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli;
	
	interface IInputProvider
	{
		function readInput();
	}
	
	
	
	class InputException extends \RuntimeException
	{
	}

