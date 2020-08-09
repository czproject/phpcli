<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\IParameterParser;


	class DefaultParameterParser implements IParameterParser
	{
		/**
		 * {@inheritDoc}
		 */
		public function parse(array $raw = NULL)
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
						throw new \CzProject\PhpCli\ParameterParserException('Parameter must be scalar or NULL, ' . gettype($argument) . " given at index ($index).");
					}

					if ($argument === '') {
						continue;
					}

					if (is_string($argument) && $argument[0] === '-') {
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

			return $parameters;
		}
	}
