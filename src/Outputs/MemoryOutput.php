<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	class MemoryOutput implements IOutputProvider
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
		 * @param  string|string[]
		 * @return self
		 */
		public function output($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			$this->output .= implode('', $str);
			return $this;
		}


		public function nl()
		{
			$this->output .= "\n";
			return $this;
		}



		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function success($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->output($str);
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function error($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->output($str);
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function warning($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->output($str);
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function info($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->output($str);
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function muted($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->output($str);
		}
	}
