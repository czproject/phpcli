<?php

	namespace CzProject\PhpCli;


	interface IParametersParser
	{
		/**
		 * @param  mixed[] $rawParameters
		 * @return Parameters
		 */
		function parse(array $rawParameters);
	}
