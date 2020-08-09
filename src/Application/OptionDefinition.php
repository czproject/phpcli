<?php

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Console;
	use CzProject\PhpCli\ConsoleFactory;


	class OptionDefinition
	{
		/** @var string */
		private $name;

		/** @var string */
		private $type;

		/** @var bool */
		private $required;

		/** @var bool */
		private $nullable;

		/** @var bool */
		private $repeatable;

		/** @var mixed */
		private $defaultValue;

		/** @var string[] */
		private static $types = [
			'boolean',
			'bool',
			'integer',
			'int',
			'float',
			'string',
		];


		public function __construct(
			$name,
			$type,
			$required,
			$nullable,
			$repeatable,
			$defaultValue
		)
		{
			if (!is_string($name)) {
				throw new ApplicationException('Option name must be string.');
			}

			if (!in_array($type, self::$types, TRUE)) {
				throw new ApplicationException("Unknow type '$type' in definition for option '$name'.");
			}

			$this->name = $name;
			$this->type = $type;
			$this->required = $required;
			$this->nullable = $nullable;
			$this->repeatable = $repeatable;
			$this->defaultValue = $defaultValue;
		}


		public function getName()
		{
			return $this->name;
		}


		/**
		 * @param  mixed
		 * @return mixed
		 */
		public function processValue($optionName, $value)
		{
			if ($value === NULL) {
				$value = $this->defaultValue;
			}

			if ($value === NULL && $this->required) {
				throw new ApplicationException("Missing value for required option '$optionName'.");
			}

			if ($this->repeatable && !is_array($value)) {
				$value = [$value];
			}

			if (!$this->repeatable && is_array($value)) {
				throw new ApplicationException("Multiple values for option '$optionName'.");
			}

			if ($this->nullable && ((is_array($value) && empty($value)) || $value === '')) {
				$value = NULL;
			}

			// set type
			if ($value !== NULL) {
				if (is_array($value)) {
					$values = [];

					foreach ($value as $val) {
						$values[] = $this->convertType($optionName, $val, $this->type);
					}

					$value = $values;

				} else {
					$value = $this->convertType($optionName, $value, $this->type);
				}
			}

			return $value;
		}


		private function convertType($optionName, $value, $type)
		{
			if ($type === 'bool' || $type === 'boolean') {
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

				throw new \CzProject\PhpCli\InvalidValueException("Invalid boolean value for option '$optionName'.");

			} elseif ($type === 'string' || $type === 'int' || $type === 'integer' || $type === 'float') {
				settype($value, $type);
				return $value;
			}

			throw new \CzProject\PhpCli\InvalidArgumentException("Unknow type '$type'.");
		}


		/**
		 * @param  string
		 * @return self
		 */
		public static function fromArray($name, array $definition)
		{
			if (!isset($definition['type'])) {
				throw new ApplicationException("Missing 'type' definition for option '$name'.");
			}

			if (!is_string($definition['type'])) {
				throw new ApplicationException("Invalid 'type' definition for option '$name'. Type must be string, " . gettype($definition['type']) . ' given.');
			}

			return new self(
				$name,
				strtolower($definition['type']),
				isset($definition['required']) && $definition['required'],
				isset($definition['nullable']) && $definition['nullable'],
				isset($definition['repeatable']) && $definition['repeatable'],
				isset($definition['defaultValue']) ? $definition['defaultValue'] : NULL
			);
		}
	}
