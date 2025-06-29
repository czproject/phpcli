<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli;


	class Console
	{
		/** @var  IOutputProvider */
		private $outputProvider;

		/** @var  IInputProvider */
		private $inputProvider;

		/** @var  IParametersProvider */
		private $parametersProvider;

		/** @var  Parameters|NULL */
		private $parameters;

		/** @var string */
		private $newLineCharacter;

		/** @var string|NULL */
		private $color;


		public function __construct(
			IOutputProvider $outputProvider,
			IInputProvider $inputProvider,
			IParametersProvider $parametersProvider
		)
		{
			$this->outputProvider = $outputProvider;
			$this->inputProvider = $inputProvider;
			$this->parametersProvider = $parametersProvider;
			// set default NL character, for WIN platform is used \r\n
			$this->newLineCharacter = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? "\r\n" : "\n";
		}


		/**
		 * @return string
		 * @throws ConsoleException
		 */
		public function getCurrentDirectory()
		{
			$cwd = getcwd();

			if ($cwd === FALSE) {
				throw new ConsoleException('CWD error');
			}

			return $cwd;
		}


		/**
		 * @param  string $directory
		 * @return static
		 */
		public function setCurrentDirectory($directory)
		{
			if ($directory[0] !== '/') {
				$directory = $this->getCurrentDirectory() . "/$directory";
			}

			if (!chdir($directory)) {
				throw new ConsoleException('CWD set error');
			}

			return $this;
		}


		/**
		 * @return Parameters
		 */
		public function getParameters()
		{
			if ($this->parameters === NULL) {
				$this->parameters = $this->parametersProvider->getParameters();
			}

			return $this->parameters;
		}


		/**
		 * @return bool
		 */
		public function hasParameters()
		{
			return $this->getParameters()->hasParameters();
		}


		/**
		 * @param  string $name
		 * @param  string $type
		 * @return Parameters\Option
		 */
		public function getOption($name, $type = Types::STRING)
		{
			$parameters = $this->getParameters();
			$value = $parameters->hasOption($name) ? $parameters->getOption($name) : NULL;
			return new Parameters\Option($name, $value, $type);
		}


		/**
		 * @param  int $index
		 * @param  string $type
		 * @return Parameters\Argument
		 */
		public function getArgument($index, $type = Types::STRING)
		{
			$parameters = $this->getParameters();
			$value = $parameters->hasArgument($index) ? $parameters->getArgument($index) : NULL;
			return new Parameters\Argument($index, $value, $type);
		}


		/**
		 * @return IOutputProvider
		 */
		public function getOutputProvider()
		{
			return $this->outputProvider;
		}


		/**
		 * @param  string|NULL $color
		 * @return self
		 */
		public function color($color)
		{
			$this->color = $color;
			return $this;
		}


		/**
		 * @param  string|string[] $str
		 * @param  string|NULL $color NULL means current
		 * @return static
		 */
		public function output($str, $color = NULL)
		{
			$color = $color !== NULL ? $color : $this->color;

			if ($color === Colors::NO_COLOR) {
				$color = NULL;
			}

			if (is_array($str)) {
				$str = implode('', $str);
			}

			$this->outputProvider->output($str, $color);
			return $this;
		}


		/**
		 * @return static
		 */
		public function nl()
		{
			$this->outputProvider->output($this->newLineCharacter, NULL);
			return $this;
		}


		/**
		 * @param  string $msg
		 * @param  string|NULL $defaultValue
		 * @return string
		 */
		public function input($msg, $defaultValue = NULL)
		{
			$defaultValue = $defaultValue !== NULL ? ((string) $defaultValue) : NULL;

			do {
				$val = $this->readInput($msg, $defaultValue);

				if ($val === '') {
					if ($defaultValue === NULL) {
						continue;
					}

					return $defaultValue;
				}

				return $val;

			} while (TRUE);
		}


		/**
		 * @param  string $msg
		 * @param  string|bool|NULL $defaultValue
		 * @return bool
		 */
		public function confirm($msg, $defaultValue = NULL)
		{
			$defaultValue = $defaultValue !== NULL ? Helpers::convertToBool($defaultValue) : NULL;

			do {
				$val = $this->readInput($msg, $defaultValue !== NULL ? ($defaultValue ? 'yes' : 'no') : NULL, '[yes/no]');

				if ($val === '') {
					if ($defaultValue === NULL) {
						continue;
					}

					return $defaultValue;
				}

				try {
					return Helpers::convertToBool($val);

				} catch (InvalidValueException $e) {
					$this->output($e->getMessage(), Colors::RED)->nl();
				}

			} while (TRUE);
		}


		/**
		 * @param  string $msg
		 * @param  array<string|int, string> $options
		 * @param  string|NULL $defaultValue
		 * @return string|int
		 */
		public function select($msg, array $options, $defaultValue = NULL)
		{
			if ($defaultValue !== NULL && !isset($options[$defaultValue])) {
				throw new InvalidArgumentException("Default value is not in options.");
			}

			$this->output($msg, Colors::NO_COLOR)->nl();
			$list = [];
			$i = 0;
			$promptDefaultValue = NULL;

			foreach ($options as $option => $label) {
				$i++;
				$list[$i] = $option;
				$this->output(' > ', Colors::NO_COLOR)
					->output($i . ') ', Colors::YELLOW)
					->output($label, Colors::NO_COLOR)
					->nl();

				if ($defaultValue !== NULL && $option === $defaultValue) {
					$promptDefaultValue = $i .  ') ' . $label;
				}
			}

			$prompt = 'Your choose';

			do {
				$val = $this->readInput($prompt, $promptDefaultValue);

				if ($val === '' && $defaultValue !== NULL) {
					return $defaultValue;
				}

				if (is_numeric($val) && isset($list[$val])) {
					return $list[$val];
				}

			} while (TRUE);
		}


		/**
		 * @param  string $msg
		 * @param  string|NULL $defaultValue
		 * @param  string|NULL $help
		 * @return string
		 */
		private function readInput($msg, $defaultValue, $help = NULL)
		{
			$this->output(rtrim($msg, ':'), Colors::NO_COLOR);

			if ($defaultValue !== NULL) {
				$this->output(' (default ', Colors::GRAY);
				$this->output($defaultValue, Colors::YELLOW);
				$this->output(')', Colors::GRAY);
			}

			if ($help !== NULL) {
				$this->output(' ' . $help, Colors::GRAY);
			}

			$this->output(': ', Colors::NO_COLOR);

			return $this->inputProvider->readInput();
		}
	}
