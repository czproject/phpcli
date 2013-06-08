<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli\Outputs;
	
	class TextOutput extends BaseOutput
	{
		/**
		 * @param	string|NULL
		 * @return	IOutputFormatter  fluent interface
		 */
		public function success($str = NULL)
		{
			return $this->output($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	IOutputFormatter  fluent interface
		 */
		public function error($str = NULL)
		{
			return $this->output($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	IOutputFormatter  fluent interface
		 */
		public function warning($str = NULL)
		{
			return $this->output($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	IOutputFormatter  fluent interface
		 */
		public function info($str = NULL)
		{
			return $this->output($str);
		}
	}

