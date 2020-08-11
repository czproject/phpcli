<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;
	use CzProject\PhpCli\OutputException;


	class ColoredOutputProvider implements IOutputProvider
	{
		protected static $colors = [
			'green' => '0;32',
			'red' => '0;31',
			'yellow' => '0;33',
			'blue' => '0;34',
			'gray' => '1;30',
		];


		public function output($str, $color = NULL)
		{
			if ($color !== NULL) {
				// set color
				if (!isset(self::$colors[$color])) {
					throw new OutputException("Unknow color: '$color'.");
				}

				echo "\033[", self::$colors[$color], 'm';
			}

			echo $str;

			if ($color !== NULL) {
				// reset color
				echo "\033[0m";
			}
		}
	}
