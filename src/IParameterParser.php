<?php

	namespace CzProject\PhpCli;


	interface IParameterParser
	{
		/**
		 * @return Parameters
		 */
		function parse(array $rawParameters);
	}
