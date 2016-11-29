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
				$overwrite = FALSE;

				foreach ($raw as $index => $argument) {
					if (!is_scalar($argument) && !is_null($argument)) {
						throw new DefaultParametersParserException('Parameter must be scalar or NULL, ' . gettype($argument) . " given at index ($index).");
					}

					if ($argument === '') {
						continue;
					}

					if ($argument[0] === '-') {
						$overwrite = FALSE;
						$name = ltrim($argument, '-');
						$lastName = $name;

						if ($name === '') { // --
							$lastName = NULL;
							continue;
						}

						if (strpos($name, '=')) { // --option=value
							$parts = explode('=', $name, 2);
							$lastName = NULL;
							Helpers::assignParameter($parameters, $parts[0], $parts[1], FALSE);
							continue;
						}

						if (!isset($parameters[$name])) {
							Helpers::assignParameter($parameters, $name, TRUE, FALSE);
							$overwrite = TRUE;
						}

					} else {
						Helpers::assignParameter($parameters, $lastName, $argument, $overwrite);
						$overwrite = FALSE;
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
