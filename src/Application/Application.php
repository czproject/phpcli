<?php

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Console;
	use CzProject\PhpCli\ConsoleFactory;


	class Application
	{
		/** @var Console */
		protected $console;

		/** @var array */
		protected $commands;

		/** @var string|NULL */
		protected $applicationName;

		/** @var string|NULL */
		protected $defaultCommand;


		public function __construct(Console $console = NULL)
		{
			$this->console = $console ? $console : ConsoleFactory::createConsole();
		}


		/**
		 * @param  string|NULL
		 * @return static
		 */
		public function setDefaultCommand($defaultCommand)
		{
			$this->defaultCommand = $defaultCommand;
			return $this;
		}


		/**
		 * @param  ICommand
		 * @return static
		 */
		public function addCommand(ICommand $command)
		{
			$this->setCommand($command->getName(), $command);
			return $this;
		}


		/**
		 * @param  string
		 * @param  ICommand
		 * @return static
		 */
		public function setCommand($name, ICommand $command)
		{
			$this->commands[$name] = $command;
			return $this;
		}


		/**
		 * @param  string|NULL
		 * @return static
		 */
		public function setApplicationName($applicationName)
		{
			$this->applicationName = $applicationName;
			return $this;
		}


		public function run(array $rawParameters = NULL)
		{
			$parameters = $this->console->getParameters();

			if ($parameters === NULL && $rawParameters === NULL) {
				if (isset($_SERVER['argv']) && is_array($_SERVER['argv'])) {
					$rawParameters = $_SERVER['argv'];
				}
			}

			if ($rawParameters !== NULL) {
				$parameters = $this->console->processRawParameters($rawParameters);
			}

			if (empty($parameters)) {
				$this->printHelp();

			} else {
				$request = $this->createRequest($parameters);

				if (!$request) {
					throw new ApplicationException('Missing command name.');
				}

				$commandName = $request->getCommandName();

				if (!isset($this->commands[$commandName])) {
					throw new ApplicationException("Unknow command '$commandName'.");
				}

				$command = $this->commands[$commandName];
				$commandOptions = $command->getOptions();
				$options = $this->processOptions($request->getOptions(), $commandOptions !== NULL ? $commandOptions : []);
				$command->run($this->console, $options, $request->getArguments());
			}
		}


		public function printException(\Exception $e)
		{
			$console = $this->console;
			$console->nl();
			$console->error('ERROR: ' . $e->getMessage());
			$console->nl();
			$console->nl();
			$console->error('Details:');
			$console->nl();
			$console->error(' - type: ' . get_class($e));
			$console->nl();
			$console->error(' - code: ' . $e->getCode());
			$console->nl();
			$console->error(' - file: ' . $e->getFile());
			$console->nl();
			$console->error(' - line: ' . $e->getLine());
			$console->nl();
		}


		protected function createRequest(array $parameters)
		{
			$command = NULL;
			$options = [];
			$arguments = [];

			foreach ($parameters as $parameterName => $parameterValue) {
				if (is_string($parameterName)) { // option
					$options[$parameterName] = $parameterValue;

				} else { // command name or argument
					if ($command === NULL) {
						$command = $parameterValue;

					} else {
						$arguments[] = $parameterValue;
					}
				}
			}

			if ($command === NULL) {
				$command = $this->defaultCommand;

				if ($command === NULL) {
					return NULL;
				}
			}

			return new ApplicationRequest($command, $options, $arguments);
		}


		/**
		 * @return array
		 */
		protected function processOptions(array $options, array $definitions)
		{
			$result = [];
			$optionDefinitions = [];

			foreach ($definitions as $name => $definition) {
				if (is_string($definition) || isset($definition['alias'])) {
					$aliasName = is_string($definition) ? $definition : $definition['alias'];

					if (!is_string($aliasName)) {
						throw new ApplicationException("Alias in option '$optionName' must be string, " . gettype($aliasName) . ' given.');
					}

					if (!isset($definitions[$aliasName])) {
						throw new ApplicationException("Unknow alias '$aliasName' in option '$name'.");
					}

					$optionDefinitions[$name] = OptionDefinition::fromArray($aliasName, $definitions[$aliasName]);

				} else {
					if (!is_array($definition)) {
						throw new ApplicationException("Definition of option '$name' must be array, " . gettype($definition) . ' given.');
					}

					$optionDefinitions[$name] = OptionDefinition::fromArray($name, $definition);
				}
			}

			$unknowOptions = [];

			foreach ($options as $option => $value) {
				if (!isset($optionDefinitions[$option])) {
					$unknowOptions[] = '\'' . $option . '\'';
				}
			}

			if (!empty($unknowOptions)) {
				throw new ApplicationException("Unknow options " . implode(', ', $unknowOptions) . '.');
			}

			$usedDefinitions = [];

			foreach ($options as $option => $value) {
				$optionDefinition = $optionDefinitions[$option];
				$name = $optionDefinition->getName();
				$isAlias = $name !== $option;

				if ($isAlias && $value === NULL) {
					continue;
				}

				if (array_key_exists($name, $result)) { // because aliases
					throw new ApplicationException("Value for option '$name' already exists. Remove option '$option' from parameters.");
				}

				$result[$name] = $optionDefinition->processValue($option, $value);
				$usedDefinitions[$option] = TRUE;
				$usedDefinitions[$name] = TRUE;
			}

			// find unused definitions
			foreach ($optionDefinitions as $option => $optionDefinition) {
				if (isset($usedDefinitions[$option])) {
					continue;
				}

				$name = $optionDefinition->getName();

				if ($name !== $option) { // alias
					continue;
				}

				if (array_key_exists($name, $result)) { // because aliases
					throw new ApplicationException("Value for option '$name' already exists.");
				}

				$result[$name] = $optionDefinition->processValue($option, NULL);
			}

			return $result;
		}


		protected function printHelp()
		{
			if (isset($this->applicationName)) {
				$this->console->nl()
					->output($this->applicationName)
					->nl();
			}

			$this->console->nl()
				->warning('Usage:')
				->nl()
				->output('  command [options] -- [arguments]')
				->nl();

			$this->console->nl()
				->warning('Available commands:')
				->nl();

			$len = 0;

			foreach ($this->commands as $commandName => $command) {
				$len = max($len, strlen($commandName));
			}

			foreach ($this->commands as $commandName => $command) {
				$commandDescription = $command->getDescription();
				$this->console->output('  ')
					->success($commandName);

				if (isset($commandDescription)) {
					$this->console->output(str_repeat(' ', $len - strlen($commandName)))
						->output('  ')
						->output($commandDescription);
				}

				$this->console->nl();
			}

			$this->console->nl();
		}
	}
