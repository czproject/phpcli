<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	class NullOutput implements IOutputProvider
	{
		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function output($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function success($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function error($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function warning($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function info($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function muted($str)
		{
			return $this;
		}


		public function nl()
		{
			return $this;
		}
	}
