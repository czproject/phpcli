<?php

	namespace CzProject\PhpCli;


	interface IParameterParser
	{
		/**
		 * @return array|NULL
		 */
		function parse(array $rawParameters = NULL);
	}
