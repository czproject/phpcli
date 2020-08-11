<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	class TextOutputProvider implements IOutputProvider
	{
		public function output($str, $color = NULL)
		{
			echo $str;
		}
	}
