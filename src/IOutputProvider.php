<?php

	namespace CzProject\PhpCli;


	interface IOutputProvider
	{
		/**
		 * @param  string
		 * @param  string|NULL  NULL means 'no color'
		 * @return void
		 */
		function output($str, $color = NULL);
	}
