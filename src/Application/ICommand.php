<?php

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\Console;


	interface ICommand
	{
		/**
		 * @return array
		 */
		function getOptions();

		/**
		 * @return string
		 */
		function getDescription();

		/**
		 * @return void
		 */
		function run(Console $console, array $options, array $arguments);
	}
