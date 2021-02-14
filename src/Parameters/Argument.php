<?php

	namespace CzProject\PhpCli\Parameters;


	class Argument
	{
		/** @var int */
		private $index;

		/** @var mixed */
		private $value;

		/** @var Definition */
		private $definition;


		/**
		 * @param int $index
		 * @param mixed $value
		 * @param string $type
		 */
		public function __construct($index, $value, $type)
		{
			$this->index = $index;
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
			return $this->definition->processValue($this->value, "argument #{$this->index}");
		}
	}
