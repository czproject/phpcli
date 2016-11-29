<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\ParametersParserException;


	class DefaultParametersParser extends BaseParser
	{
		protected function parse(array $raw = NULL)
		{
			$parameters = NULL;

			// parsing
			$lastName = NULL;

			if (isset($raw[1])) { // count($raw) > 1
				// remove argv[0]
				array_shift($raw);

				// parsing
				foreach ($raw as $index => $argument) {
					if (!is_scalar($argument) && !is_null($argument)) {
						throw new DefaultParametersParserException('Parameter must be scalar or NULL, ' . gettype($argument) . " given at index ($index).");
					}

					if ($argument === '') {
						continue;
					}

					if ($argument[0] === '-') {
						$name = trim($argument, '-');
						$lastName = $name;

						if ($name === '') { // --
							$lastName = NULL;
							continue;
						}

						if (!isset($parameters[$name])) {
							$parameters[$name] = TRUE;
						}

					} elseif ($lastName === NULL) {
						$parameters[] = $argument;

					} else {
						if ($parameters[$lastName] === TRUE) {
							$parameters[$lastName] = $argument;

						} else { // string || array
							if (is_string($parameters[$lastName])) {
								$parameters[$lastName] = array(
									$parameters[$lastName],
									$argument,
								);

							} else {
								$parameters[$lastName][] = $argument;
							}
						}

						$lastName = NULL;
					}
				}
			}

			// after parsing
			$this->setParameters($parameters);
		}
	}


	class DefaultParametersParserException extends ParametersParserException
	{
	}
