<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\Exception;


	class Helpers
	{
		public function __construct()
		{
			throw new Exception('This is static class.');
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
