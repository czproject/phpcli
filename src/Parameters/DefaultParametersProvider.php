<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\IParameterParser;
	use CzProject\PhpCli\IParametersProvider;


	class DefaultParametersProvider implements IParametersProvider
	{
		/** @var IParameterParser */
		private $parametersParser;


		public function __construct(IParameterParser $parametersParser = NULL)
		{
			$this->parametersParser = $parametersParser !== NULL ? $parametersParser : new DefaultParameterParser;
		}


		/**
		 * @return Parameters
		 */
		public function getParameters()
		{
			$parameters = isset($_SERVER['argv']) ? $_SERVER['argv'] : [];

			if (!is_array($parameters)) {
				throw new \CzProject\PhpCli\InvalidStateException("Parameters from 'argv' must be array, " . gettype($parameters) . ' given.');
			}

			array_shift($parameters); // remove argv[0] (programName)
			return $this->parametersParser->parse($parameters);
		}
	}
