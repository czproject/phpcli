<?php

	namespace CzProject\PhpCli;


	interface IOutputProvider
	{
		/**
		 * @param  string|string[]
		 * @return static
		 */
		function output($str/*,... */);


		/**
		 * @param  string|string[]
		 * @return static
		 */
		function success($str/*,... */);


		/**
		 * @param  string|string[]
		 * @return static
		 */
		function error($str/*,... */);


		/**
		 * @param  string|string[]
		 * @return static
		 */
		function warning($str/*,... */);


		/**
		 * @param  string|string[]
		 * @return static
		 */
		function info($str/*,... */);


		/**
		 * @param  string|string[]
		 * @return static
		 */
		function muted($str/*,... */);


		/**
		 * @return static
		 */
		function nl();
	}


	class OutputException extends Exception
	{
	}
