<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli\Outputs;
	use Cz\Cli\IOutputFormatter;
	
	class NullOutput implements IOutputFormatter
	{
		/** @var  bool */
		protected $newLineEnabled = TRUE;



		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function output($str = NULL)
		{
			return $this;
		}



		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function success($str = NULL)
		{
			return $this;
		}



		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function error($str = NULL)
		{
			return $this;
		}



		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function warning($str = NULL)
		{
			return $this;
		}



		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function info($str = NULL)
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

