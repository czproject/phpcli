<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\IParametersParser;
	use CzProject\PhpCli\Parameters;


	class ParametersFactory
	{
		/** @var array<string, mixed> */
		private $options = [];

		/** @var mixed[] */
		private $arguments = [];


		/**
		 * @param  string
		 * @param  mixed
		 */
		public function addOption($name, $value)
		{
			$name = $this->processOptionName($name);
			$value = $this->processValue($value);

			if (!$this->hasOption($name)) {
				$this->setOption($name, $value);
				return;
			}

			if (!is_array($this->options[$name])) { // string|scalar
				$this->options[$name] = [
					$this->options[$name],
					$value,
				];

			} else {
				$this->options[$name][] = $value;
			}
		}


		/**
		 * Overwrites option value
		 * @param  string
		 * @param  mixed
		 */
		public function setOption($name, $value)
		{
			$name = $this->processOptionName($name);
			$this->options[$name] = $this->processValue($value);
		}


		/**
		 * @param  string
		 * @return bool
		 */
		public function hasOption($name)
		{
			$name = $this->processOptionName($name);
			return isset($this->options[$name]);
		}


		/**
		 * @param  mixed
		 */
		public function addArgument($value)
		{
			$this->arguments[] = $this->processValue($value);
		}


		/**
		 * @return Parameters
		 */
		public function createParameters()
		{
			return new Parameters($this->options, $this->arguments);
		}


		/**
		 * @param  mixed
		 * @return string
		 */
		private function processOptionName($optionName)
		{
			if (!is_string($optionName)) {
				throw new \CzProject\PhpCli\InvalidArgumentException('Option name must be string.');
			}

			$optionName = trim($optionName);

			if ($optionName === '') {
				throw new \CzProject\PhpCli\InvalidArgumentException('Option name cannot be empty.');
			}

			return $optionName;
		}


		/**
		 * @param  mixed
		 * @return mixed
		 */
		private function processValue($value)
		{
			if (is_array($value)) {
				throw new \CzProject\PhpCli\InvalidArgumentException('Value cannot be array.');
			}

			if ($value === NULL) {
				throw new \CzProject\PhpCli\InvalidArgumentException('Value cannot be NULL.');
			}

			return $value;
		}
	}
