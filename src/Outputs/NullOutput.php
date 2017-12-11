<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	class NullOutput implements IOutputProvider
	{
		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function output($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function success($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function error($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function warning($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function info($str)
		{
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
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
