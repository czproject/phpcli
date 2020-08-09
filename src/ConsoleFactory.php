<?php

	namespace CzProject\PhpCli;

	use CzProject\PhpCli\Inputs;
	use CzProject\PhpCli\Outputs;
	use CzProject\PhpCli\Parameters;


	class ConsoleFactory
	{
		/** @var  bool|NULL */
		protected static $useColoredOutput;

		/** @var  bool|NULL */
		protected static $useReadlineProvider;


		/**
		 * @return Console
		 */
		public static function createConsole(IOutputProvider $outputProvider = NULL, IInputProvider $inputProvider = NULL, IParameterParser $parser = NULL)
		{
			$outputProvider = $outputProvider === NULL ? self::createOutputProvider() : $outputProvider;
			$inputProvider = $inputProvider === NULL ? self::createInputProvider() : $inputProvider;
			$parser = $parser === NULL ? self::createParamatersParser() : $parser;

			return new Console($outputProvider, $inputProvider, $parser);
		}


		/**
		 * @return IOutputProvider
		 */
		public static function createOutputProvider()
		{
			if (self::$useColoredOutput === NULL) {
				self::$useColoredOutput = self::detectColoredOutput();
			}

			if (self::$useColoredOutput) {
				return new Outputs\ColoredOutput;
			}

			return new Outputs\TextOutput;
		}


		/**
		 * @return IOutputProvider
		 */
		public static function createNullOutputProvider()
		{
			return new Outputs\NullOutput;
		}


		/**
		 * @return IInputProvider
		 */
		public static function createInputProvider()
		{
			if (self::$useReadlineProvider === NULL) {
				self::$useReadlineProvider = self::detectReadline();
			}

			if (self::$useReadlineProvider) {
				return new Inputs\ReadlineInputProvider;
			}

			return new Inputs\DefaultInputProvider;
		}


		/**
		 * @return IParameterParser
		 */
		public static function createParamatersParser()
		{
			return new Parameters\DefaultParameterParser;
		}


		/**
		 * @return bool
		 */
		public static function detectColoredOutput()
		{
			// Code from Tracy (from Nette Framework)
			// see https://github.com/nette/tracy/blob/master/src/Tracy/Dumper.php#L315-L317
			// see https://github.com/nette/command-line/commit/7027cbee2d283b5d482d11350dbb5399cc33b745
			return (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg')
				&& (function_exists('stream_isatty') && stream_isatty(STDOUT))
				&& getenv('NO_COLOR') === FALSE // https://no-color.org
				&& (defined('PHP_WINDOWS_VERSION_BUILD')
					? (function_exists('sapi_windows_vt100_support') && sapi_windows_vt100_support(STDOUT))
						|| getenv('ConEmuANSI') === 'ON' // ConEmu
						|| getenv('ANSICON') !== FALSE // ANSICON
						|| getenv('term') === 'xterm' // MSYS
						|| getenv('term') === 'xterm-256color' // MSYS
					: TRUE);
		}


		/**
		 * @return bool
		 */
		public static function detectReadline()
		{
			if (extension_loaded('readline')) {
				return TRUE;
			}

			return function_exists('readline') && function_exists('readline_add_history');
		}
	}
