<?php
	/**
	 * Colors list: http://www.if-not-true-then-false.com/2010/php-class-for-coloring-php-command-line-cli-scripts-output-php-output-colorizing-using-bash-shell-colors/
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 * @license		New BSD License
	 * @link		http://janpecha.iunas.cz/
	 * @version		2013-01-22-1
	 */
	
	namespace Cz;
	
	class Cli
	{
		const COLOR_ERROR = '0;31',
			COLOR_SUCCESS = '0;32',
			COLOR_WARNING = '0;33',
			COLOR_INFO = '0;34';
		
		const C_BLACK = 30,
			C_RED = 31,
			C_GREEN = 32,
			C_YELLOW = 33,
			C_BLUE = 34,
			C_PURPLE = 35,
			C_CYAN = 36,
			C_WHITE = 37;
		
		
		/** @var  bool|NULL */
		protected static $isWindows = NULL;
		
		
		
		/**
		 * @param	string
		 * @return	void
		 */
		public static function log($str)
		{
			echo "$str\n";
		}
		
		
		
		/**
		 * @param	string
		 * @return	void
		 */
		public static function error($str)
		{
			if(self::$isWindows === NULL)
			{
				self::detectOs();
			}
			
			if(!self::$isWindows)
			{
				$str = self::coloredString($str, static::COLOR_ERROR);
			}
			
			fwrite(STDERR, $str);
		}
		
		
		
		/**
		 * @param	string
		 * @return	void
		 */
		public static function success($str)
		{
			if(self::$isWindows === NULL)
			{
				self::detectOs();
			}
			
			if(!self::$isWindows)
			{
				$str = self::coloredString($str, static::COLOR_SUCCESS);
			}
			
			echo $str;
		}
		
		
		
		/**
		 * @param	string
		 * @return	void
		 */
		public static function warn($str)
		{
			if(self::$isWindows === NULL)
			{
				self::detectOs();
			}
			
			if(!self::$isWindows)
			{
				$str = self::coloredString($str, static::COLOR_WARNING);
			}
			
			fwrite(STDERR, $str);	// TODO: zmenit vystupni proud, ??echo
		}
		
		
		
		/**
		 * @param	string
		 * @return	void
		 */
		public static function info($str)
		{
			if(self::$isWindows === NULL)
			{
				self::detectOs();
			}
			
			if(!self::$isWindows)
			{
				$str = self::coloredString($str, static::COLOR_INFO);
			}
			
			echo $str;
		}
		
		
		
		/**
		 * @param	string
		 * @param	bool
		 * @return	void
		 */
		public static function format($str, $bold = FALSE, $color = NULL)
		{
			if($color === NULL)
			{
				$color = static::C_WHITE;
			}
			
			echo "\033[", // start
				((int)(bool)$bold), // style
				';',
				$color, // color
				'm',
				$str, // message
				"\033[0m"; // reset
		}
		
		
		
		/**
		 * @param	array
		 * @return	array|FALSE
		 */
		public static function parseParams(array $argv)
		{
			$params = array();
			$lastName = NULL;
			
			if(isset($argv[1]))		// count($argv) > 1
			{
				// remove argv[0]
				array_shift($argv);
				
				// parsing
				foreach($argv as $argument)
				{
					if($argument{0} === '-')
					{
						$name = trim($argument, '-');
						$lastName = $name;
					
						if(!isset($params[$name]))
						{
							$params[$name] = TRUE;
						}
					}
					elseif($lastName === NULL)
					{
						throw new \Exception("Bad argument '$argument'");
					}
					else
					{
						if($params[$lastName] === TRUE)
						{
							$params[$lastName] = $argument;
						}
						else	// string || array
						{
							if(is_string($params[$lastName]))
							{
								$newParams = array(
									$params[$lastName],
									$argument,
								);
							
								$params[$lastName] = $newParams;
							}
							else
							{
								$params[$lastName][] = $argument;
							}
						
							$lastName = NULL;
						}
					}
				}
				
				return $params;
			}
			
			return FALSE;
		}
		
		
		
		/**
		 * @param	string
		 * @param	string
		 * @return	string
		 */
		public static function formatPath($dir, $currentDir)
		{
			if($dir{0} === '/')
			{
				return $dir;
			}
			
			return $currentDir . '/' . $dir;
		}
		
		
		
		/**
		 * @return	void
		 */
		protected static function detectOs()
		{
			if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
			{
				self::$isWindows = TRUE;
			}
			else
			{
				self::$isWindows = FALSE;
			}
		}
		
		
		
		/**
		 * @param	string
		 * @param	string
		 * @return	string
		 */
		protected static function coloredString($str, $color)
		{
			return "\033[" . $color . "m" . $str . "\033[0m\r\n";
			#return "\033[" . $color . "m" . $str . "\033[37m\r\n";
		}
	}

