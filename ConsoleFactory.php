<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli;
	use Cz\Cli\Inputs,
		Cz\Cli\Outputs,
		Cz\Cli\Parameters;
	
	class ConsoleFactory
	{
		/** @var  bool|NULL */
		protected static $useColoredOutput;
		
		/** @var  bool|NULL */
		protected static $useReadlineProvider;
		
		
		
		/**
		 * @return	Console
		 */
		public static function createConsole(IOutputFormatter $outputFormatter = NULL, IInputProvider $inputProvider = NULL, IParametersParser $parser = NULL)
		{
			$outputFormatter = $outputFormatter === NULL ? self::createOutputFormatter() : $outputFormatter;
			$inputProvider = $inputProvider === NULL ? self::createInputProvider() : $inputProvider;
			$parser = $parser === NULL ? self::createParamatersParser() : $parser;
			
			return new Console($outputFormatter, $inputProvider, $parser);
		}
		
		
		
		/**
		 * @return	IOutputFormatter
		 */
		public static function createOutputFormatter()
		{
			if(self::$useColoredOutput === NULL)
			{
				self::$useColoredOutput = self::detectColoredOutput();
			}
			
			if(self::$useColoredOutput)
			{
				return new Outputs\ColoredOutput;
			}
			
			return new Outputs\TextOutput;
		}
		
		
		
		/**
		 * @return	IInputProvider
		 */
		public static function createInputProvider()
		{
			if(self::$useReadlineProvider === NULL)
			{
				self::$useReadlineProvider = self::detectReadline();
			}
			
			if(self::$useReadlineProvider)
			{
				return new Inputs\ReadlineInputProvider;
			}
			
			return new Inputs\DefaultInputProvider;
		}
		
		
		
		/**
		 * @return	IParametersParser
		 */
		public static function createParamatersParser()
		{
			return new Parameters\DefaultParametersParser;
		}
		
		
		
		/**
		 * @return	bool
		 */
		public static function detectColoredOutput()
		{
			// Code from Tracy (from Nette Framework)
			// see https://github.com/nette/tracy/blob/master/src/Tracy/Dumper.php#L58
			return preg_match('#^xterm|^screen#', getenv('TERM')) && (defined('STDOUT') && function_exists('posix_isatty') ? posix_isatty(STDOUT) : TRUE);
		}
		
		
		
		/**
		 * @return	bool
		 */
		public static function detectReadline()
		{
			if(extension_loaded('readline'))
			{
				return TRUE;
			}
			
			return function_exists('readline') && function_exists('readline_add_history');
		}
	}

