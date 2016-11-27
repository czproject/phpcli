<?php
	/**
	 * Cz CLI Console
	 * @author Jan Pecha, <janpecha@email.cz>
	 */

	namespace CzProject\PhpCli;
	use CzProject\PhpCli\Inputs,
		CzProject\PhpCli\Outputs,
		CzProject\PhpCli\Parameters;

	class ConsoleFactory
	{
		/** @var  bool|NULL */
		protected static $useColoredOutput;

		/** @var  bool|NULL */
		protected static $useReadlineProvider;



		/**
		 * @return	Console
		 */
		public static function createConsole(IOutputProvider $outputProvider = NULL, IInputProvider $inputProvider = NULL, IParametersParser $parser = NULL)
		{
			$outputProvider = $outputProvider === NULL ? self::createOutputProvider() : $outputProvider;
			$inputProvider = $inputProvider === NULL ? self::createInputProvider() : $inputProvider;
			$parser = $parser === NULL ? self::createParamatersParser() : $parser;

			return new Console($outputProvider, $inputProvider, $parser);
		}



		/**
		 * @return	IOutputProvider
		 */
		public static function createOutputProvider()
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
		 * @return	IOutputProvider
		 */
		public static function createNullOutputProvider()
		{
			return new Outputs\NullOutput;
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
			// see https://github.com/nette/tracy/blob/master/src/Tracy/Dumper.php#L315-L317
			return (getenv('ConEmuANSI') === 'ON'
				|| getenv('ANSICON') !== FALSE
				|| (defined('STDOUT') && function_exists('posix_isatty') && posix_isatty(STDOUT)));
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

