<?php

	namespace CzProject\PhpCli\Outputs;

	use CzProject\PhpCli\IOutputProvider;


	abstract class BaseOutput implements IOutputProvider
	{
		/** @var  string */
		protected $newLineCharacter = "\n";


		public function __construct()
		{
			// set default NL character, for WIN platform is used \r\n
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				$this->newLineCharacter = "\r\n";
			}
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

			echo implode('', $str);
			return $this;
		}


		public function nl()
		{
			echo $this->newLineCharacter;
			return $this;
		}
	}
