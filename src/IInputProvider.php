<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli;


	interface IInputProvider
	{
		/**
		 * @return string
		 */
		function readInput();
	}
