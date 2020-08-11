<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Console;
	use CzProject\PhpCli\ConsoleFactory;


	class Option
	{
		/** @var string */
		private $name;

		/** @var mixed */
		private $value;

		/** @var Definition */
		private $definition;


		public function __construct($name, $value, $type)
		{
			$this->name = $name;
			$this->value = $value;
			$this->definition = new Definition($type);
		}


		public function setRequired($required = TRUE)
		{
			$this->definition->setRequired($required);
			return $this;
		}


		public function setNullable($nullable = TRUE)
		{
			$this->definition->setNullable($nullable);
			return $this;
		}


		public function setRepeatable($repeatable = TRUE)
		{
			$this->definition->setRepeatable($repeatable);
			return $this;
		}


		public function setDefaultValue($defaultValue)
		{
			$this->definition->setDefaultValue($defaultValue);
			return $this;
		}


		public function getValue()
		{
			return $this->definition->processValue($this->value, "option '{$this->name}'");
		}
	}
