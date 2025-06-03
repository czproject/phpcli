<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli;


	interface IOutputProvider
	{
		/**
		 * @param  string $str
		 * @param  string|NULL $color  NULL means 'no color'
		 * @return void
		 */
		function output($str, $color = NULL);
	}
