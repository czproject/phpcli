<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	class MemoryOutputProvider implements IOutputProvider
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
			$this->output .= $str;
		}
	}
