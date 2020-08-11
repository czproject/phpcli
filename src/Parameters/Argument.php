<?php

	namespace CzProject\PhpCli\Parameters;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Console;
	use CzProject\PhpCli\ConsoleFactory;


	class Argument
	{
		/** @var int */
		private $index;

		/** @var mixed */
		private $value;

		/** @var Definition */
		private $definition;


		public function __construct($index, $value, $type)
		{
			$this->index = $index;
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


		public function setDefaultValue($defaultValue)
		{
			$this->definition->setDefaultValue($defaultValue);
			return $this;
		}


		public function getValue()
		{
			return $this->definition->processValue($this->value, "argument #{$this->index}");
		}
	}
