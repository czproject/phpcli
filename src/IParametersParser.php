<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli;
	
	interface IParametersParser
	{
		/**
		 * @return	self
		 */
		function setDefaultParameters(array $defaultParameters = NULL);
		
		/**
		 * @return	array|NULL
		 */
		function getParameters();
		
		/**
		 * @param	string
		 * @param	mixed
		 * @param	bool
		 * @return	mixed
		 * @throws	ParametersException
		 */
		function getParameter($name, $defaultValue = NULL, $required = FALSE);
	}
	
	
	
	class ParametersException extends \RuntimeException
	{
	}
	
	
	
	class ParametersParseException extends \RuntimeException
	{
	}
