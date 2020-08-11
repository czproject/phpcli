<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	class NullOutput implements IOutputProvider
	{
		public function output($str, $color = NULL)
		{
		}
	}
