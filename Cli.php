<?php
	/**
	 * @author		Jan Pecha, <janpecha@email.cz>
	 * @license		New BSD License
	 * @link		http://janpecha.iunas.cz/
	 * @version		2012-11-13-1
	 */
	
	namespace Cz;
	
	class Cli
	{
		const COLOR_ERROR = '31',
			COLOR_SUCCESS = '32',
			COLOR_WARNING = '33',
			COLOR_INFO = '34';
		
		
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
				$str = self::coloredString($str, self::COLOR_ERROR);
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
				$str = self::coloredString($str, self::COLOR_SUCCESS);
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
				$str = self::coloredString($str, self::COLOR_WARNING);
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
				$str = self::coloredString($str, self::COLOR_INFO);
			}
			
			echo $str;
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
			return "\033[" . $color . "m" . $str . "\033[37m\r\n";
		}
	}

