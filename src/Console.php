<?php

	namespace CzProject\PhpCli;


	class Console
	{
		/** @var  IOutputProvider */
		protected $outputProvider;

		/** @var  IInputProvider */
		protected $inputProvider;

		/** @var  IParametersProvider */
		protected $parametersProvider;

		/** @var  Parameters|NULL */
		protected $parameters;

		/** @var string */
		protected $newLineCharacter;

		/** @var string|NULL */
		protected $color;


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
		 * @param  string
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
		 * @param  string
		 * @param  string
		 * @return Parameters\Option
		 */
		public function getOption($name, $type = 'string')
		{
			$parameters = $this->getParameters();
			$value = $parameters->hasOption($name) ? $parameters->getOption($name) : NULL;
			return new Parameters\Option($name, $value, $type);
		}


		/**
		 * @param  int
		 * @param  string
		 * @return Parameters\Argument
		 */
		public function getArgument($index, $type = 'string')
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


		public function color($color)
		{
			$this->color = $color;
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @param  string|NULL NULL means current
		 * @return static
		 */
		public function output($str, $color = NULL)
		{
			$color = $color !== NULL ? $color : $this->color;

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
		 * @param  string|NULL  optional
		 * @return string
		 */
		public function input($msg = NULL)
		{
			return $this->readInput($msg);
		}


		/**
		 * @param  string|NULL  optional
		 * @return string
		 */
		public function readInput($msg = NULL)
		{
			$msg = $msg !== NULL ? (string) $msg : $msg;

			if (!$this->inputProvider->isPrintingPrompt()) {
				$this->outputProvider->output($msg) // print message
					->output($msg !== '' ? ' ' : ''); // print one space for not empty message
			}

			return $this->inputProvider->readInput($msg);
		}
	}
