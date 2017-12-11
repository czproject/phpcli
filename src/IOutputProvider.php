<?php

	namespace CzProject\PhpCli;


	interface IOutputProvider
	{
		/**
		 * @param  string|string[]
		 * @return self
		 */
		function output($str/*,... */);

		/**
		 * @param  string|string[]
		 * @return self
		 */
		function success($str/*,... */);

		/**
		 * @param  string|string[]
		 * @return self
		 */
		function error($str/*,... */);

		/**
		 * @param  string|string[]
		 * @return self
		 */
		function warning($str/*,... */);

		/**
		 * @param  string|string[]
		 * @return self
		 */
		function info($str/*,... */);

		/**
		 * @param  string|string[]
		 * @return self
		 */
		function muted($str/*,... */);

		/**
		 * @return self
		 */
		function nl();
	}


	class OutputException extends Exception
	{
	}
