<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Parameters\Definition;


	class CommandOption
	{
		/** @var string */
		private $name;

		/** @var Definition */
		private $definition;


		/**
		 * @param string $name
		 * @param string $type
		 */
		public function __construct($name, $type)
		{
			$this->name = $name;

			try {
				$this->definition = new Definition($type);

			} catch (\CzProject\PhpCli\InvalidArgumentException $e) {
				throw new ApplicationException("Option '$name': " . $e->getMessage(), 0, $e);
			}
		}


		/**
		 * @return string
		 */
		public function getName()
		{
			return $this->name;
		}


		/**
		 * @param  bool $required
		 * @return self
		 */
		public function setRequired($required = TRUE)
		{
			$this->definition->setRequired($required);
			return $this;
		}


		/**
		 * @param  bool $nullable
		 * @return self
		 */
		public function setNullable($nullable = TRUE)
		{
			$this->definition->setNullable($nullable);
			return $this;
		}


		/**
		 * @param  bool $repeatable
		 * @return self
		 */
		public function setRepeatable($repeatable = TRUE)
		{
			$this->definition->setRepeatable($repeatable);
			return $this;
		}


		/**
		 * @param  mixed $defaultValue
		 * @return self
		 */
		public function setDefaultValue($defaultValue)
		{
			$this->definition->setDefaultValue($defaultValue);
			return $this;
		}


		/**
		 * @param  string|NULL $errorMessage
		 * @return self
		 */
		public function addRule(callable $rule, $errorMessage = NULL)
		{
			$this->definition->addRule($rule, $errorMessage);
			return $this;
		}


		/**
		 * @param  string $optionName
		 * @param  mixed $value
		 * @return mixed
		 */
		public function processValue($optionName, $value)
		{
			return $this->definition->processValue($value, "option '{$optionName}'");
		}
	}
