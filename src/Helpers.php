<?php

	namespace CzProject\PhpCli;


	class Helpers
	{
		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		public static function normalizeInput($input)
		{
			return rtrim($input, "\r\n");
		}


		/**
		 * @param  string|int|float|bool $value
		 * @return bool
		 */
		public static function convertToBool($value)
		{
			if (is_string($value)) {
				$lValue = strtolower($value);

				if ($lValue === 'yes' || $lValue === 'y' || $lValue === 'on' || $lValue === 'true' || $lValue === '1') {
					return TRUE;

				} elseif ($lValue === 'no' || $lValue === 'n' || $lValue === 'off' || $lValue === 'false' || $lValue === '0') {
					return FALSE;
				}

			} elseif (is_bool($value) || is_int($value) || is_float($value)) {
				return (bool) $value;
			}

			throw new \CzProject\PhpCli\InvalidValueException('Invalid boolean value.');
		}
	}
