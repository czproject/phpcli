<?php

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Console;
	use CzProject\PhpCli\ConsoleFactory;
	use CzProject\PhpCli\Parameters\Definition;


	class CommandArgument
	{
		/** @var string */
		private $name;

		/** @var Definition */
		private $definition;


		public function __construct($name, $type)
		{
			$this->name = $name;
			$this->definition = new Definition($type);
		}


		public function getName()
		{
			return $this->name;
		}


		public function setRequired($required = TRUE)
		{
			$this->definition->setRequired($required);
			return $this;
		}


		public function setDefaultValue($defaultValue)
		{
			$this->definition->setDefaultValue($defaultValue);
			return $this;
		}


		public function processValue($index, $value)
		{
			return $this->definition->processValue($value, "argument '{$this->name}' (at position #{$index})");
		}
	}
