<?php

	namespace CzProject\PhpCli\Parameters;


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
				foreach ($raw as $argument) {
					if ($argument{0} === '-') {
						$name = trim($argument, '-');
						$lastName = $name;

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
