<?php

	namespace CzProject\PhpCli\Parameters;


	class Helpers
	{
		public function __construct()
		{
			throw new \CzProject\PhpCli\StaticClassException('This is static class.');
		}


		/**
		 * @param  array|NULL
		 * @param  string|NULL
		 * @param  string|scalar
		 * @param  bool
		 * @return void
		 */
		public static function assignParameter(&$parameters, $name, $value, $overwrite = FALSE)
		{
			if ($name === NULL) {
				$parameters[] = $value;
				return;
			}

			if (!isset($parameters[$name]) || $overwrite) {
				$parameters[$name] = $value;
				return;
			}

			if (!is_array($parameters[$name])) { // string|scalar
				$parameters[$name] = [
					$parameters[$name],
					$value,
				];

			} else {
				$parameters[$name][] = $value;
			}
		}


		/**
		 * Left side has pririoty. Helper method.
		 * @param  array
		 * @param  array
		 * @return array|NULL
		 */
		public static function merge($left, $right)
		{
			if (is_array($left) && is_array($right)) {
				foreach ($left as $key => $val) {
					if (is_int($key)) {
						$right[] = $val;

					} else {
						if (isset($right[$key])) {
							$val = self::merge($val, $right[$key]);
						}

						$right[$key] = $val;
					}
				}

				return $right;

			} elseif ($left === NULL && is_array($right)) {
				return $right;
			}

			return $left;
		}
	}
