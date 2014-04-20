<?php
	/** Cz CLI Console
	 *
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */

	namespace Cz\Cli;

	interface IOutputFormatter
	{
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		function output($str = NULL);

		/**
		 * @param	string|NULL
		 * @return	self
		 */
		function success($str = NULL);

		/**
		 * @param	string|NULL
		 * @return	self
		 */
		function error($str = NULL);

		/**
		 * @param	string|NULL
		 * @return	self
		 */
		function warning($str = NULL);

		/**
		 * @param	string|NULL
		 * @return	self
		 */
		function info($str = NULL);

		/**
		 * @param	string|NULL
		 * @return	self
		 */
		function muted($str = NULL);

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

