<?php
	/**
	 * Cz CLI Console
	 * @author Jan Pecha, <janpecha@email.cz>
	 */

	namespace CzProject\PhpCli\Outputs;
	use CzProject\PhpCli\IOutputProvider;

	class NullOutput implements IOutputProvider
	{
		/** @var  bool */
		protected $newLineEnabled = TRUE;



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function output($str)
		{
			return $this;
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function success($str)
		{
			return $this;
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function error($str)
		{
			return $this;
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function warning($str)
		{
			return $this;
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function info($str)
		{
			return $this;
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function muted($str)
		{
			return $this;
		}



		public function nl()
		{
			return $this;
		}



		public function setAutoNewLine($state)
		{
			$this->newLineEnabled = (bool) $state;
			return $this;
		}



		public function getAutoNewLine()
		{
			return $this->newLineEnabled;
		}
	}

