<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\InvalidArgumentException;
	use CzProject\PhpCli\InvalidStateException;
	use CzProject\PhpCli\Helpers;
	use CzProject\PhpCli\MissingParameterException;
	use CzProject\PhpCli\Types;


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

		/** @var Rules */
		private $rules;

		/** @var string[] */
		private static $types = [
			Types::BOOLEAN,
			Types::BOOL,
			Types::INTEGER,
			Types::INT,
			Types::FLOAT,
			Types::STRING,
		];


		/**
		 * @param string $type
		 */
		public function __construct($type)
		{
			if (!in_array($type, self::$types, TRUE)) {
				throw new InvalidArgumentException("Unknow type '$type'.");
			}

			$this->type = $type;
			$this->rules = new Rules;
		}


		/**
		 * @param  bool $required
		 * @return self
		 */
		public function setRequired($required = TRUE)
		{
			$this->required = $required;
			return $this;
		}


		/**
		 * @param  bool $nullable
		 * @return self
		 */
		public function setNullable($nullable = TRUE)
		{
			$this->nullable = $nullable;
			return $this;
		}


		/**
		 * @param  bool $repeatable
		 * @return self
		 */
		public function setRepeatable($repeatable = TRUE)
		{
			$this->repeatable = $repeatable;
			return $this;
		}


		/**
		 * @param  mixed $defaultValue
		 * @return self
		 */
		public function setDefaultValue($defaultValue)
		{
			$this->defaultValue = $defaultValue;
			return $this;
		}


		/**
		 * @param  string|NULL $errorMessage
		 * @return self
		 */
		public function addRule(callable $rule, $errorMessage = NULL)
		{
			$this->rules->addRule($rule, $errorMessage);
			return $this;
		}


		/**
		 * @param  mixed $value
		 * @param  string|NULL $errorSuffix
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

			$this->rules->validate($value, $errorSuffix);
			return $value;
		}


		/**
		 * @param  mixed $value
		 * @param  string $type
		 * @param  string|NULL $errorSuffix
		 * @return mixed
		 */
		private function convertType($value, $type, $errorSuffix)
		{
			try {
				if ($type === Types::BOOL || $type === Types::BOOLEAN) {
					return Helpers::convertToBool($value);

				} elseif ($type === Types::STRING || $type === Types::INT || $type === Types::INTEGER || $type === Types::FLOAT) {
					settype($value, $type);
					return $value;
				}

			} catch (\CzProject\PhpCli\InvalidValueException $e) {
				throw new \CzProject\PhpCli\InvalidValueException("Invalid value for $errorSuffix.", 0, $e);
			}

			throw new \CzProject\PhpCli\InvalidArgumentException("Unknow type '$type'.");
		}
	}
