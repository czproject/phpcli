<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli;


	interface IParametersParser
	{
		/**
		 * @param  mixed[] $rawParameters
		 * @return Parameters
		 */
		function parse(array $rawParameters);
	}
