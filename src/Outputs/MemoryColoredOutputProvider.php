<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	class MemoryColoredOutputProvider implements IOutputProvider
	{
		/** @var string|NULL */
		private $output;


		/**
		 * @return string|NULL
		 */
		public function getOutput()
		{
			return $this->output;
		}


		public function output($str, $color = NULL)
		{
			$this->output .= ($color !== NULL ? "<$color>" : '') . $str . ($color !== NULL ? "</$color>" : '');
		}
	}
