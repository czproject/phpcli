<?php
	/**
	 * Cz CLI Console
	 * @author Jan Pecha, <janpecha@email.cz>
	 */

	namespace CzProject\PhpCli\Outputs;
	use CzProject\PhpCli\OutputException;

	class ColoredOutput extends BaseOutput
	{
		protected static $colors = array(
			'success' => '0;32',
			'error' => '0;31',
			'warning' => '0;33',
			'info' => '0;34',
			'muted' => '1;30',
		);



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function success($str)
		{
			if (!is_array($str))
			{
				$str = func_get_args();
			}

			return $this->color('success')
				->printString($str);
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function error($str)
		{
			if (!is_array($str))
			{
				$str = func_get_args();
			}

			return $this->color('error')
				->printString($str);
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function warning($str)
		{
			if (!is_array($str))
			{
				$str = func_get_args();
			}

			return $this->color('warning')
				->printString($str);
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function info($str)
		{
			if (!is_array($str))
			{
				$str = func_get_args();
			}

			return $this->color('info')
				->printString($str);
		}



		/**
		 * @param	string|string[]
		 * @return	self
		 */
		public function muted($str)
		{
			if (!is_array($str))
			{
				$str = func_get_args();
			}

			return $this->color('muted')
				->printString($str);
		}



		protected function color($colorId)
		{
			$newLineEnabled = $this->newLineEnabled;
			$this->setAutoNewLine(FALSE); // disable new lines

			if($colorId === NULL) // reset color
			{
				return $this->output("\033[0m")
					->setAutoNewLine($newLineEnabled);
			}
			elseif(isset(self::$colors[$colorId = (string) $colorId]))
			{
				return $this->output("\033[" . self::$colors[$colorId] . 'm')
					->setAutoNewLine($newLineEnabled);
			}

			throw new OutputException("Unknow color: $colorId");
		}



		protected function printString($str = NULL)
		{
			return $this->output($str)
				->color(NULL);
		}
	}

