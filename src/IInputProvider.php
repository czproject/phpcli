<?php

	namespace CzProject\PhpCli;


	interface IInputProvider
	{
		function readInput();

		function isPrintingPrompt();
	}


	class InputException extends \RuntimeException
	{
	}
