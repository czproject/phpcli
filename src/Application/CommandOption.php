<?php

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Console;
	use CzProject\PhpCli\ConsoleFactory;
	use CzProject\PhpCli\Parameters\Definition;


	class CommandOption
	{
		/** @var string */
		private $name;

		/** @var Definition */
		private $definition;


		public function __construct($name, $type)
		{
			$this->name = $name;

			try {
				$this->definition = new Definition($type);

			} catch (\CzProject\PhpCli\InvalidArgumentException $e) {
				throw new ApplicationException("Option '$name': " . $e->getMessage(), NULL, $e);
			}
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


		public function processValue($optionName, $value)
		{
			return $this->definition->processValue($value, "option '{$optionName}'");
		}
	}
