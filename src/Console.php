<?php
	/**
	 * Cz CLI Console
	 * @author Jan Pecha, <janpecha@email.cz>
	 */

	namespace Cz\Cli;

	class Console
	{
		/** @var  IOutputFormatter */
		protected $outputFormatter;

		/** @var  IInputProvider */
		protected $inputProvider;

		/** @var  IParametersParser */
		protected $parametersParser;

		/** @var  string|NULL */
		protected $currentDirectory;



		public function __construct(IOutputFormatter $outputFormatter, IInputProvider $inputProvider, IParametersParser $parametersParser)
		{
			$this->outputFormatter = $outputFormatter;
			$this->inputProvider = $inputProvider;
			$this->parametersParser = $parametersParser;
		}



		/**
		 * @param	bool
		 * @return	string
		 * @throws	ConsoleException
		 */
		public function getCurrentDirectory($forceRefresh = FALSE)
		{
			if($forceRefresh || $this->currentDirectory === NULL)
			{
				$cwd = getcwd();

				if($cwd === FALSE)
				{
					throw ConsoleException('CWD error');
				}

				$this->currentDirectory = $cwd;
			}

			return $this->currentDirectory;
		}



		/**
		 * @param	string
		 * @return	self
		 */
		public function setCurrentDirectory($directory)
		{
			if($directory[0] !== '/')
			{
				$directory = $this->getCurrentDirectory() . "/$directory";
			}

			if(!chdir($directory))
			{
				throw new ConsoleException('CWD set error');
			}

			$this->getCurrentDirectory(TRUE); // force refresh of CWD
			return $this;
		}



		/**
		 * @return	self
		 */
		public function setRawParameters(array $parameters = NULL)
		{
			$this->parametersParser->setRawParameters($parameters);
			return $this;
		}



		/**
		 * @param	array|NULL
		 * @return	self
		 */
		public function setDefaultParameters(array $defaultParameters = NULL)
		{
			$this->parametersParser->setDefaultParameters($defaultParameters);
			return $this;
		}



		/**
		 * @return	array|NULL
		 */
		public function getParameters()
		{
			return $this->parametersParser->getParameters();
		}



		/**
		 * @param	string
		 * @param	mixed
		 * @param	bool
		 * @return	mixed
		 */
		public function getParameter($name, $defaultValue = NULL, $required = FALSE)
		{
			return $this->parametersParser->getParameter($name, $defaultValue, $required);
		}


		/**
		 * @return IOutputFormatter
		 */
		public function getOutputFormatter()
		{
			return $this->outputFormatter;
		}



		/**
		 * @param	string|string[]|NULL
		 * @return	self
		 */
		public function output($str = NULL)
		{
			if($str !== NULL)
			{
				if (!is_array($str))
				{
					$str = func_get_args();
				}
				return $this->outputFormatter->output($str);
			}

			return $this->outputFormatter;
		}



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
			return $this->outputFormatter->success($str);
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
			return $this->outputFormatter->error($str);
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
			return $this->outputFormatter->warning($str);
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
			return $this->outputFormatter->info($str);
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
			return $this->outputFormatter->muted($str);
		}



		/**
		 * @return	IOutputFormatter
		 */
		public function nl()
		{
			return $this->outputFormatter->nl();
		}



		/**
		 * @param	bool
		 * @return	IOutputFormatter
		 */
		public function setAutoNewLine($state)
		{
			return $this->outputFormatter->setAutoNewLine($state);
		}



		/**
		 * @return	bool
		 */
		public function getAutoNewLine()
		{
			return $this->outputFormatter->getAutoNewLine();
		}



		/**
		 * @param	string|NULL  optional
		 * @return	string
		 */
		public function input($msg = NULL)
		{
			return $this->readInput($msg);
		}



		/**
		 * @param	string|NULL  optional
		 * @return	string
		 */
		public function readInput($msg = NULL)
		{
			$msg = $msg !== NULL ? (string) $msg : $msg;

			if(!$this->inputProvider->isPrintingPrompt())
			{
				$currentAutoNewLine = $this->outputFormatter->getAutoNewLine();
				$this->outputFormatter->setAutoNewLine(FALSE) // disable new lines after output()
					->output($msg) // print message
					->output($msg !== '' ? ' ' : '') // print one space for not empty message
					->setAutoNewLine($currentAutoNewLine); // restore settings
			}

			return $this->inputProvider->readInput($msg);
		}



		/**
		 * @return	IOutputFormatter
		 */
		public function enableNewLine()
		{
			return $this->setAutoNewLine(TRUE);
		}



		/**
		 * @return	IOutputFormatter
		 */
		public function disableNewLine()
		{
			return $this->setAutoNewLine(FALSE);
		}
	}



	class ConsoleException extends \RuntimeException
	{
	}

