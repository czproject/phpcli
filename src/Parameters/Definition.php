<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\InvalidArgumentException;
	use CzProject\PhpCli\InvalidStateException;
	use CzProject\PhpCli\Helpers;
	use CzProject\PhpCli\MissingParameterException;


	class Definition
	{
		/** @var string */
		private $type;

		/** @var bool */
		private $required = FALSE;

		/** @var bool */
		private $nullable = FALSE;

		/** @var bool */
		private $repeatable = FALSE;

		/** @var mixed */
		private $defaultValue = NULL;

		/** @var string[] */
		private static $types = [
			'boolean',
			'bool',
			'integer',
			'int',
			'float',
			'string',
		];


		public function __construct($type)
		{
			if (!in_array($type, self::$types, TRUE)) {
				throw new InvalidArgumentException("Unknow type '$type'.");
			}

			$this->type = $type;
		}


		public function setRequired($required = TRUE)
		{
			$this->required = $required;
			return $this;
		}


		public function setNullable($nullable = TRUE)
		{
			$this->nullable = $nullable;
			return $this;
		}


		public function setRepeatable($repeatable = TRUE)
		{
			$this->repeatable = $repeatable;
			return $this;
		}


		public function setDefaultValue($defaultValue)
		{
			$this->defaultValue = $defaultValue;
			return $this;
		}


		/**
		 * @param  mixed
		 * @return mixed
		 */
		public function processValue($value, $errorSuffix)
		{
			if ($value === NULL) {
				$value = $this->defaultValue;
			}

			if ($value === NULL && $this->required) {
				throw new MissingParameterException("Missing value for required $errorSuffix.");
			}

			if ($this->repeatable && !is_array($value)) {
				$value = [$value];
			}

			if (!$this->repeatable && is_array($value)) {
				throw new InvalidStateException("Multiple values for $errorSuffix.");
			}

			if ($this->nullable && ((is_array($value) && empty($value)) || $value === '')) {
				$value = NULL;
			}

			// set type
			if ($value !== NULL) {
				if (is_array($value)) {
					$values = [];

					foreach ($value as $val) {
						$values[] = $this->convertType($val, $this->type, $errorSuffix);
					}

					$value = $values;

				} else {
					$value = $this->convertType($value, $this->type, $errorSuffix);
				}
			}

			return $value;
		}


		private function convertType($value, $type, $errorSuffix)
		{
			try {
				if ($type === 'bool' || $type === 'boolean') {
					return Helpers::convertToBool($value);

					throw new \CzProject\PhpCli\InvalidValueException("Invalid boolean value for $errorSuffix.");

				} elseif ($type === 'string' || $type === 'int' || $type === 'integer' || $type === 'float') {
					settype($value, $type);
					return $value;
				}

			} catch (\CzProject\PhpCli\InvalidValueException $e) {
				throw new \CzProject\PhpCli\InvalidValueException("Invalid value for $errorSuffix.", NULL, $e);
			}

			throw new \CzProject\PhpCli\InvalidArgumentException("Unknow type '$type'.");
		}
	}
