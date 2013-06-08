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
		 * @return	IOutputFormatter  fluent interface
		 */
		function output($str = NULL);
		
		/**
		 * @param	string|NULL
		 * @return	IOutputFormatter  fluent interface
		 */
		function success($str = NULL);
		
		/**
		 * @param	string|NULL
		 * @return	IOutputFormatter  fluent interface
		 */
		function error($str = NULL);
		
		/**
		 * @param	string|NULL
		 * @return	IOutputFormatter  fluent interface
		 */
		function warning($str = NULL);
		
		/**
		 * @param	string|NULL
		 * @return	IOutputFormatter  fluent interface
		 */
		function info($str = NULL);
		
		/**
		 * @param	bool|NULL  NULL => direct print NL, TRUE => enable NL printing, FALSE => disable NL printing
		 * @return	IOutputFormatter  fluent interface
		 */
		function nl($state = NULL);
	}
	
	
	
	class OutputException extends \RuntimeException
	{
	}

