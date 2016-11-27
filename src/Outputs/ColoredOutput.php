<?php

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
		 * @param  string|string[]
		 * @return self
		 */
		public function success($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->printString('success', $str);
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function error($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->printString('error', $str);
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function warning($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->printString('warning', $str);
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function info($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->printString('info', $str);
		}


		/**
		 * @param  string|string[]
		 * @return self
		 */
		public function muted($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}

			return $this->printString('muted', $str);
		}


		protected function setColor($colorId)
		{
			if (isset(self::$colors[$colorId = (string) $colorId])) {
				return $this->output("\033[" . self::$colors[$colorId] . 'm');
			}

			throw new OutputException("Unknow color: $colorId");
		}


		protected function resetColor()
		{
			return $this->output("\033[0m");
		}


		protected function printString($colorId, $str = NULL)
		{
			return $this->setColor($colorId)
				->output($str)
				->resetColor();
		}
	}
