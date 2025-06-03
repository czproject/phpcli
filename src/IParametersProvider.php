<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli;


	interface IParametersProvider
	{
		/**
		 * @return Parameters
		 */
		function getParameters();
	}
