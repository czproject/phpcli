<?php

	namespace CzProject\PhpCli;


	interface IParametersParser
	{
		/**
		 * @return self
		 */
		function setRawParameters(array $parameters = NULL);

		/**
		 * @return self
		 */
		function setDefaultParameters(array $defaultParameters = NULL);

		/**
		 * @return array|NULL
		 */
		function getParameters();

		/**
		 * @param  string
		 * @param  mixed
		 * @param  bool
		 * @return mixed
		 * @throws ParametersException
		 */
		function getParameter($name, $defaultValue = NULL, $required = FALSE);
	}


	class ParametersException extends Exception
	{
	}


	class ParametersParseException extends Exception
	{
	}
