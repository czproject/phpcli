<?php

	namespace CzProject\PhpCli\Application;


	class CommandParameters
	{
		/** @var string */
		private $name;

		/** @var array<string, string|CommandOption> */
		private $options = [];

		/** @var array<CommandArgument> */
		private $arguments = [];


		/**
		 * @return array<string, CommandOption>
		 */
		public function getOptions()
		{
			$result = [];

			foreach ($this->options as $name => $definition) {
				if (is_string($definition)) {
					if (!isset($this->options[$definition])) {
						throw new \CzProject\PhpCli\MissingException("Unknow alias '$definition' in option '$name'.");
					}

					if (is_string($this->options[$definition])) {
						throw new \CzProject\PhpCli\InvalidStateException("Alias '$name' cannot be pointing to another alias '{$this->options[$definition]}'.");
					}

					$result[$name] = $this->options[$definition];

				} else {
					$result[$name] = $definition;
				}
			}

			return $result;
		}


		/**
		 * @param  string
		 * @param  string
		 * @return CommandOption
		 */
		public function addOption($name, $type = 'string')
		{
			if (isset($this->options[$name])) {
				throw new \CzProject\PhpCli\InvalidStateException("Option '$name' is already defined.");
			}

			return $this->options[$name] = new CommandOption($name, $type);
		}


		/**
		 * @param  string
		 * @param  string
		 * @return static
		 */
		public function addAlias($aliasName, $optionName)
		{
			if (isset($this->options[$aliasName])) {
				throw new \CzProject\PhpCli\InvalidStateException("Option '$aliasName' is already defined.");
			}

			$this->options[$aliasName] = $optionName;
			return $this;
		}


		/**
		 * @param  string
		 * @param  string
		 * @return CommandArgument
		 */
		public function addArgument($name, $type = 'string')
		{
			return $this->arguments[] = new CommandArgument($name, $type);
		}


		/**
		 * @return CommandArgument[]
		 */
		public function getArguments()
		{
			return $this->arguments;
		}
	}
