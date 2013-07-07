<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli\Outputs;
	use Cz\Cli\IOutputFormatter;
	
	abstract class BaseOutput implements IOutputFormatter
	{
		/** @var  bool */
		protected $newLineEnabled = TRUE;
		
		/** @var  string */
		protected $newLineChar = "\n";
		
		
		
		public function __construct()
		{
			// set default NL character, for WIN platform is used \r\n
			if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
			{
				$this->newLineChar = "\r\n";
			}
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function output($str = NULL)
		{
			echo $str;
			return $this->nl();
		}
		
		
		
		public function nl($state = NULL)
		{
			if(!is_bool($state))
			{
				if($this->newLineEnabled)
				{
					$this->printNL();
				}
			}
			else
			{
				$this->newLineEnabled = (bool) $state;
			}
			
			return $this;
		}
		
		
		
		public function printNL()
		{
			echo $this->newLineChar;
		}
	}

