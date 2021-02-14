<?php

	namespace CzProject\PhpCli\Parameters;


	class Option
	{
		/** @var string */
		private $name;

		/** @var mixed */
		private $value;

		/** @var Definition */
		private $definition;


		/**
		 * @param string $name
		 * @param mixed $value
		 * @param string $type
		 */
		public function __construct($name, $value, $type)
		{
			$this->name = $name;
			$this->value = $value;
			$this->definition = new Definition($type);
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
		 * @return mixed
		 */
		public function getValue()
		{
			return $this->definition->processValue($this->value, "option '{$this->name}'");
		}
	}
