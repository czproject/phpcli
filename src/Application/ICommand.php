<?php

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\Console;


	interface ICommand
	{
		/**
		 * @return string
		 */
		function getName();

		/**
		 * @return CommandParameters|NULL
		 */
		function getParameters();

		/**
		 * @return string|NULL
		 */
		function getDescription();

		/**
		 * @param  array<string, mixed> $options
		 * @param  array<int, mixed> $arguments
		 * @return void
		 */
		function run(Console $console, array $options, array $arguments);
	}
