<?php

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\Console;


	interface ICommand
	{
		/**
		 * @return CommandParameters|NULL
		 */
		function getParameters();

		/**
		 * @return string
		 */
		function getDescription();

		/**
		 * @return void
		 */
		function run(Console $console, array $options, array $arguments);
	}
