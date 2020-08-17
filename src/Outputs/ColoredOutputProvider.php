<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\Colors;
	use CzProject\PhpCli\IOutputProvider;
	use CzProject\PhpCli\OutputException;


	class ColoredOutputProvider implements IOutputProvider
	{
		protected static $colors = [
			Colors::GREEN => '0;32',
			Colors::RED => '0;31',
			Colors::YELLOW => '0;33',
			Colors::BLUE => '0;34',
			Colors::GRAY => '1;30',
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
