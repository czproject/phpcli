<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
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
		public function setCurrentDir($directory)
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
		 * @param	string|NULL
		 * @return	self
		 */
		public function output($str = NULL)
		{
			if($str !== NULL)
			{
				return $this->outputFormatter->output($str);
			}
			
			return $this->outputFormatter;
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function success($str = NULL)
		{
			return $this->outputFormatter->success($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function error($str = NULL)
		{
			return $this->outputFormatter->error($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function warning($str = NULL)
		{
			return $this->outputFormatter->warning($str);
		}
		
		
		
		/**
		 * @param	string|NULL
		 * @return	self
		 */
		public function info($str = NULL)
		{
			return $this->outputFormatter->info($str);
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
				$this->outputFormatter->nl(FALSE) // disable new lines after output()
					->output($msg) // print message
					->output($msg !== '' ? ' ' : '') // print one space for not empty message
					->nl(TRUE); // enable new lines
			}
			
			return $this->inputProvider->readInput($msg);
		}
		
		
		
		/**
		 * @return	IOutputFormatter
		 */
		public function enableNl()
		{
			return $this->nl(TRUE);
		}
		
		
		
		/**
		 * @return	IOutputFormatter
		 */
		public function disableNl()
		{
			return $this->nl(FALSE);
		}
	}
	
	
	
	class ConsoleException extends \RuntimeException
	{
	}

