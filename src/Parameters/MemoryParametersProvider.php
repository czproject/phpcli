<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\IParametersParser;
	use CzProject\PhpCli\IParametersProvider;
	use CzProject\PhpCli\Parameters;


	class MemoryParametersProvider implements IParametersProvider
	{
		/** @var mixed[] */
		private $parameters;

		/** @var IParametersParser */
		private $parametersParser;


		/**
		 * @param  mixed[] $parameters parameters without programName
		 */
		public function __construct(array $parameters, IParametersParser $parametersParser = NULL)
		{
			$this->parameters = $parameters;
			$this->parametersParser = $parametersParser !== NULL ? $parametersParser : new DefaultParametersParser;
		}


		/**
		 * @return Parameters
		 */
		public function getParameters()
		{
			return $this->parametersParser->parse($this->parameters);
		}
	}
