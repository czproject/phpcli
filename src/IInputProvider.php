<?php

	namespace CzProject\PhpCli;


	interface IInputProvider
	{
		/**
		 * @return string
		 */
		function readInput();
	}
