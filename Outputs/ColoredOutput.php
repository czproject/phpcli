<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli\Outputs;
	use Cz\Cli\OutputException;
	
	class ColoredOutput extends BaseOutput
	{
		protected static $colors = array(
			'success' => 32,
			'error' => 31,
			'warning' => 33,
			'info' => 34,
		);
		
		
		
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function success($str = NULL)
		{
			return $this->color('success')
				->printString($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 @return	self
		 */
		public function error($str = NULL)
		{
			return $this->color('error')
				->printString($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function warning($str = NULL)
		{
			return $this->color('warning')
				->printString($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function info($str = NULL)
		{
			return $this->color('info')
				->printString($str);
		}
		
		
		
		public function color($colorId)
		{
			$newLineEnabled = $this->newLineEnabled;
			$this->nl(FALSE); // disable new lines
			
			if($colorId === NULL) // reset color
			{
				return $this->output("\033[0m")
					->nl($newLineEnabled);
			}
			elseif(isset(self::$colors[$colorId = (string) $colorId]))
			{
				return $this->output("\033[0;" . self::$colors[$colorId] . 'm')
					->nl($newLineEnabled);
			}
			
			throw new OutputException("Unknow color: $colorId");
		}
		
		
		
		protected function printString($str = NULL)
		{
			return $this->output($str)
				->color(NULL);
		}
	}

