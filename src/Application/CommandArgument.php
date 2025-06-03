<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\Parameters\Definition;


	class CommandArgument
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
			$this->definition = new Definition($type);
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
		 * @param  int $index
		 * @param  mixed $value
		 * @return mixed
		 */
		public function processValue($index, $value)
		{
			return $this->definition->processValue($value, "argument '{$this->name}' (at position #{$index})");
		}
	}
