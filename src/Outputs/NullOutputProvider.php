<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	class NullOutputProvider implements IOutputProvider
	{
		public function output($str, $color = NULL)
		{
		}
	}
