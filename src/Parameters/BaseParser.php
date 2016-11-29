<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\IParametersParser;
	use CzProject\PhpCli\ParametersException;


	abstract class BaseParser implements IParametersParser
	{
		/** @var  array|NULL */
		protected $defaultParameters;

		/** @var  array|NULL */
		protected $parameters;

		/** @var  bool */
		protected $parsed = FALSE;

		/** @var  array|NULL */
		protected $rawParameters;


		public function setRawParameters(array $parameters = NULL)
		{
			$this->rawParameters = $parameters;
			$this->parsed = FALSE;
			return $this;
		}


		public function setDefaultParameters(array $defaultParameters = NULL)
		{
			$this->defaultParameters = $defaultParameters;
			$this->parsed = FALSE;
			return $this;
		}


		public function getParameters()
		{
			if (!$this->parsed) {
				$this->parse($this->rawParameters);
				$this->parsed = TRUE;
			}

			return $this->parameters;
		}


		public function getParameter($name, $defaultValue = NULL, $required = FALSE)
		{
			if (!$this->parsed) {
				$this->parse($this->rawParameters);
				$this->parsed = TRUE;
			}

			if (!isset($this->parameters[$name])) {
				if ($required) {
					throw new ParametersException("Required parameter '$name' not found.");
				}

				return $defaultValue;
			}

			return $this->parameters[$name];
		}


		/**
		 * @param  array|NULL
		 * @return self
		 */
		protected function setParameters(array $parameters = NULL)
		{
			$this->parameters = Helpers::merge($parameters, $this->defaultParameters);
			return $this;
		}


		protected abstract function parse(array $rawParameters = NULL);
	}
