<?php

	namespace CzProject\PhpCli;


	interface IParametersParser
	{
		/**
		 * @return Parameters
		 */
		function parse(array $rawParameters);
	}
