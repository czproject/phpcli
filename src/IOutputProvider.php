<?php
	/**
	 * Cz CLI Console
	 * @author Jan Pecha, <janpecha@email.cz>
	 */

	namespace Cz\Cli;

	interface IOutputProvider
	{
		/**
		 * @param	string|string[]
		 * @return	self
		 */
		function output($str/*,... */);

		/**
		 * @param	string|string[]
		 * @return	self
		 */
		function success($str/*,... */);

		/**
		 * @param	string|string[]
		 * @return	self
		 */
		function error($str/*,... */);

		/**
		 * @param	string|string[]
		 * @return	self
		 */
		function warning($str/*,... */);

		/**
		 * @param	string|string[]
		 * @return	self
		 */
		function info($str/*,... */);

		/**
		 * @param	string|string[]
		 * @return	self
		 */
		function muted($str/*,... */);

		/**
		 * @return	self
		 */
		function nl();

		/**
		 * @param	bool
		 * @return	self
		 */
		function setAutoNewLine($state);

		/**
		 * @return	bool
		 */
		function getAutoNewLine();
	}



	class OutputException extends \RuntimeException
	{
	}

