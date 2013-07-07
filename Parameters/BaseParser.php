<?php
	/** Cz CLI Console
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz\Cli\Parameters;
	use Cz\Cli\IParametersParser,
		Cz\Cli\ParametersException;
	
	abstract class BaseParser implements IParametersParser
	{
		/** @var  array|NULL */
		protected $defaultParameters;
		
		/** @var  array|NULL */
		protected $parameters;
		
		/** @var  bool */
		protected $parsed = FALSE;
		
		
		
		public function setDefaultParameters(array $defaultParameters = NULL)
		{
			$this->defaultParameters = $defaultParameters;
			return $this;
		}
		
		
		
		public function getParameters()
		{
			if(!$this->parsed)
			{
				$this->parameters = $this->parse();
			}
			
			return $this->parameters;
		}
		
		
		
		public function getParameter($name, $defaultValue = NULL, $required = FALSE)
		{
			if(!$this->parsed)
			{
				$this->parameters = $this->parse();
			}
			
			if(!isset($this->parameters[$name]))
			{
				if($required)
				{
					throw new ParametersException('Required parameters not found.');
				}
				
				return $defaultValue;
			}
			
			return $this->parameters[$name];
		}
		
		
		
		/**
		 * @param	array|NULL
		 * @return	self
		 */
		protected function setParameters(array $parameters = NULL)
		{
			$this->parameters = self::merge($parameters, $this->defaultParameters);
			return $this;
		}
		
		
		
		protected abstract function parse();
		
		
		
		protected static function getRawParams()
		{
			return $_SERVER['argv'];
		}
		
		
		
		/**
		 * Left side has pririoty. Helper method.
		 * @param	array
		 * @param	array
		 * @return	array|NULL
		 */
		protected static function merge($left, $right)
		{
			if(is_array($left) && is_array($right))
			{
				foreach($left as $key => $val)
				{
					if(is_int($key))
					{
						$right[] = $val;
					}
					else
					{
						if(isset($right[$key]))
						{
							$val = self::merge($val, $right[$key]);
						}
						
						$right[$key] = $val;
					}
				}
				
				return $right;
			}
			elseif($left === NULL && is_array($right))
			{
				return $right;
			}
			
			return $left;
		}
	}

