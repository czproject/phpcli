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

		/** @var  string|NULL */
		protected $currentDirectory;


		public function __construct(IOutputProvider $outputProvider, IInputProvider $inputProvider, IParametersParser $parametersParser)
		{
			$this->outputProvider = $outputProvider;
			$this->inputProvider = $inputProvider;
			$this->parametersParser = $parametersParser;
		}


		/**
		 * @param  bool
		 * @return string
		 * @throws ConsoleException
		 */
		public function getCurrentDirectory($forceRefresh = FALSE)
		{
			if ($forceRefresh || $this->currentDirectory === NULL) {
				$cwd = getcwd();

				if ($cwd === FALSE) {
					throw new ConsoleException('CWD error');
				}

				$this->currentDirectory = $cwd;
			}

			return $this->currentDirectory;
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

			$this->getCurrentDirectory(TRUE); // force refresh of CWD
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
		 * @param  string|string[]|NULL
		 * @return self
		 */
		public function output($str = NULL)
		{
			if ($str !== NULL) {
				if (!is_array($str)) {
					$str = func_get_args();
				}
				return $this->outputProvider->output($str);
			}

			return $this->outputProvider;
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
			return $this->outputProvider->success($str);
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
			return $this->outputProvider->error($str);
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
			return $this->outputProvider->warning($str);
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
			return $this->outputProvider->info($str);
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
			return $this->outputProvider->muted($str);
		}


		/**
		 * @return IOutputProvider
		 */
		public function nl()
		{
			return $this->outputProvider->nl();
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
