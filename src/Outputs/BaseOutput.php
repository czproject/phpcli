<?php
	/**
	 * Cz CLI Console
	 * @author Jan Pecha, <janpecha@email.cz>
	 */

	namespace CzProject\PhpCli\Outputs;
	use CzProject\PhpCli\IOutputProvider;

	abstract class BaseOutput implements IOutputProvider
	{
		/** @var  bool */
		protected $newLineEnabled = TRUE;

		/** @var  string */
		protected $newLineCharacter = "\n";



		public function __construct()
		{
			// set default NL character, for WIN platform is used \r\n
			if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
			{
				$this->newLineCharacter = "\r\n";
			}
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function output($str)
		{
			if (!is_array($str))
			{
				$str = func_get_args();
			}

			echo implode('', $str);
			return $this->nl();
		}



		public function nl()
		{
			if($this->newLineEnabled)
			{
				$this->printNL();
			}

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



		protected function printNL()
		{
			echo $this->newLineCharacter;
		}
	}

