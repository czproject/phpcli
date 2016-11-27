<?php

	namespace CzProject\PhpCli;


	class Console
	{
		/** @var  IOutputProvider */
		protected $outputProvider;

		/** @var  IInputProvider */
		protected $inputProvider;

		/** @var  IParametersParser */
		protected $parametersParser;


		public function __construct(IOutputProvider $outputProvider, IInputProvider $inputProvider, IParametersParser $parametersParser)
		{
			$this->outputProvider = $outputProvider;
			$this->inputProvider = $inputProvider;
			$this->parametersParser = $parametersParser;
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
		 * @return self
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
		 * @return self
		 */
		public function setRawParameters(array $parameters = NULL)
		{
			$this->parametersParser->setRawParameters($parameters);
			return $this;
		}


		/**
		 * @param  array|NULL
		 * @return self
		 */
		public function setDefaultParameters(array $defaultParameters = NULL)
		{
			$this->parametersParser->setDefaultParameters($defaultParameters);
			return $this;
		}


		/**
		 * @return array|NULL
		 */
		public function getParameters()
		{
			return $this->parametersParser->getParameters();
		}


		/**
		 * @param  string
		 * @param  mixed
		 * @param  bool
		 * @return mixed
		 */
		public function getParameter($name, $defaultValue = NULL, $required = FALSE)
		{
			return $this->parametersParser->getParameter($name, $defaultValue, $required);
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
		 * @return self
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
		 * @return self
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
		 * @return self
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
		 * @return self
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
		 * @return self
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
		 * @return self
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
		 * @return self
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


	class ConsoleException extends Exception
	{
	}
