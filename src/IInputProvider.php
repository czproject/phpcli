<?php
	/** Cz CLI Console
	 *
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */

	namespace Cz\Cli;

	interface IInputProvider
	{
		function readInput();

		static function isPrintingPrompt();
	}



	class InputException extends \RuntimeException
	{
	}

