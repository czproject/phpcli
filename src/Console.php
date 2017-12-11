<?php

	namespace CzProject\PhpCli;


	class Console
	{
		/** @var  IOutputProvider */
		protected $outputProvider;

		/** @var  IInputProvider */
		protected $inputProvider;

		/** @var  IParameterParser */
		protected $parameterParser;

		/** @var  array|NULL */
		protected $parameters;


		public function __construct(IOutputProvider $outputProvider, IInputProvider $inputProvider, IParameterParser $parameterParser)
		{
			$this->outputProvider = $outputProvider;
			$this->inputProvider = $inputProvider;
			$this->parameterParser = $parameterParser;
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
		 * @return static
		 */
		public function addRawParameters(array $rawParameters = NULL)
		{
			$parameters = $this->processRawParameters($rawParameters);
			$this->addParameters($parameters);
			return $this;
		}


		/**
		 * @return static
		 */
		public function processRawParameters(array $rawParameters = NULL)
		{
			return $this->parameterParser->parse($rawParameters);
		}


		/**
		 * @param  array|NULL
		 * @return static
		 */
		public function addParameters(array $parameters = NULL)
		{
			$this->parameters = Parameters\Helpers::merge($parameters, $this->parameters);
			return $this;
		}


		/**
		 * @return array|NULL
		 */
		public function getParameters()
		{
			return $this->parameters;
		}


		/**
		 * @param  string
		 * @param  mixed
		 * @param  bool
		 * @return mixed
		 */
		public function getParameter($name, $defaultValue = NULL, $required = FALSE)
		{
			if (!isset($this->parameters[$name])) {
				if ($required) {
					throw new MissingParameterException("Required parameter '$name' not found.");
				}

				return $defaultValue;
			}

			return $this->parameters[$name];
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
