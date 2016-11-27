<?php
	/**
	 * Cz CLI Console
	 * @author Jan Pecha, <janpecha@email.cz>
	 */

	namespace CzProject\PhpCli;

	interface IInputProvider
	{
		function readInput();

		function isPrintingPrompt();
	}



	class InputException extends \RuntimeException
	{
	}

