<?php

	declare(strict_types=1);

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


		/**
		 * @return void
		 */
		public function resetOutput()
		{
			$this->output = NULL;
		}


		public function output($str, $color = NULL)
		{
			$this->output .= ($color !== NULL ? "<$color>" : '') . $str . ($color !== NULL ? "</$color>" : '');
		}
	}
