<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\IParameterParser;
	use CzProject\PhpCli\IParametersProvider;


	class MemoryParametersProvider implements IParametersProvider
	{
		/** @var mixed[] */
		private $parameters;

		/** @var IParameterParser */
		private $parametersParser;


		/**
		 * @param  mixed[]  parameters without programName
		 */
		public function __construct(array $parameters, IParameterParser $parametersParser = NULL)
		{
			$this->parameters = $parameters;
			$this->parametersParser = $parametersParser !== NULL ? $parametersParser : new DefaultParameterParser;
		}


		/**
		 * @return Parameters
		 */
		public function getParameters()
		{
			return $this->parametersParser->parse($this->parameters);
		}
	}
