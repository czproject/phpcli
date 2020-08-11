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


		public function __construct(
			IOutputProvider $outputProvider,
			IInputProvider $inputProvider,
			IParametersProvider $parametersProvider
		)
		{
			$this->outputProvider = $outputProvider;
			$this->inputProvider = $inputProvider;
			$this->parametersProvider = $parametersProvider;
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


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function output($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}
			$this->outputProvider->output($str);
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function success($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}
			$this->outputProvider->success($str);
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function error($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}
			$this->outputProvider->error($str);
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function warning($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}
			$this->outputProvider->warning($str);
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function info($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}
			$this->outputProvider->info($str);
			return $this;
		}


		/**
		 * @param  string|string[]
		 * @return static
		 */
		public function muted($str)
		{
			if (!is_array($str)) {
				$str = func_get_args();
			}
			$this->outputProvider->muted($str);
			return $this;
		}


		/**
		 * @return static
		 */
		public function nl()
		{
			$this->outputProvider->nl();
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
