<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\IParametersParser;
	use CzProject\PhpCli\Parameters;


	class DefaultParametersParser implements IParametersParser
	{
		/**
		 * @param  mixed[] $rawParameters  parameters without programName
		 * @return Parameters
		 */
		public function parse(array $rawParameters)
		{
			$parametersFactory = new ParametersFactory;

			// parsing
			$lastName = NULL;
			$pending = FALSE;

			foreach ($rawParameters as $index => $value) {
				if (!is_scalar($value) && !is_null($value)) {
					throw new \CzProject\PhpCli\ParametersParserException('Parameter must be scalar or NULL, ' . gettype($value) . " given at index ($index).");
				}

				if ($value === '') {
					continue;
				}

				if (is_string($value) && $value[0] === '-') {
					$pending = FALSE;
					$name = ltrim($value, '-');
					$lastName = $name;

					if ($name === '') { // --
						$lastName = NULL;
						continue;
					}

					if (strpos($name, '=')) { // --option=value
						$parts = explode('=', $name, 2);
						$lastName = NULL;
						$parametersFactory->addOption($parts[0], $parts[1]);
						continue;
					}

					if (!$parametersFactory->hasOption($name)) { // flag
						$parametersFactory->setOption($name, TRUE);
						$pending = TRUE;
					}

				} else {
					if ($lastName === NULL) {
						$parametersFactory->addArgument($value);

					} else {
						if ($pending) {
							$parametersFactory->setOption($lastName, $value);

						} else {
							$parametersFactory->addOption($lastName, $value);
						}
					}

					$pending = FALSE;
					$lastName = NULL;
				}
			}

			return $parametersFactory->createParameters();
		}
	}
