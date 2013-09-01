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
		 * @param	bool|NULL  NULL => direct print NL, TRUE => enable NL printing, FALSE => disable NL printing
		 * @return	self
		 */
		function nl($state = NULL);
	}
	
	
	
	class OutputException extends \RuntimeException
	{
	}

