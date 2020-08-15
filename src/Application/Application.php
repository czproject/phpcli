<?php

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Console;
	use CzProject\PhpCli\ConsoleFactory;
	use CzProject\PhpCli\Parameters;


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


		public function run()
		{
			if (!$this->console->hasParameters()) {
				$this->printHelp();

			} else {
				$request = $this->createRequest($this->console->getParameters());

				if (!$request) {
					throw new ApplicationException('Missing command name.');
				}

				$commandName = $request->getCommandName();

				if (!isset($this->commands[$commandName])) {
					throw new ApplicationException("Unknow command '$commandName'.");
				}

				$command = $this->commands[$commandName];
				$commandParameters = $command->getParameters();
				$options = $this->processOptions($request->getOptions(), $commandParameters);
				$arguments = $this->processArguments($request->getArguments(), $commandParameters);
				$command->run($this->console, $options, $arguments);
			}
		}


		public function printException(\Exception $e)
		{
			$console = $this->console;
			$console->nl();
			$console->output('ERROR: ' . $e->getMessage(), 'red');
			$console->nl();
			$console->nl();
			$console->output('Details:', 'red');
			$console->nl();
			$console->output(' - type: ' . get_class($e), 'red');
			$console->nl();
			$console->output(' - code: ' . $e->getCode(), 'red');
			$console->nl();
			$console->output(' - file: ' . $e->getFile(), 'red');
			$console->nl();
			$console->output(' - line: ' . $e->getLine(), 'red');
			$console->nl();
		}


		protected function createRequest(Parameters $parameters)
		{
			$command = NULL;
			$options = $parameters->getOptions();
			$arguments = $parameters->getArguments();

			if (!empty($arguments)) {
				$command = array_shift($arguments);
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
		protected function processOptions(array $options, CommandParameters $parameters = NULL)
		{
			$result = [];
			$optionDefinitions = $parameters !== NULL ? $parameters->getOptions() : [];
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


		/**
		 * @return array
		 */
		protected function processArguments(array $arguments, CommandParameters $parameters = NULL)
		{
			$result = [];
			$argumentDefinitions = $parameters !== NULL ? $parameters->getArguments() : [];

			if (empty($argumentDefinitions)) {
				return $arguments;
			}

			$unknowArguments = [];

			foreach ($arguments as $argument => $value) {
				if (!isset($argumentDefinitions[$argument])) {
					$unknowArguments[] = '\'' . $argument . '\'';
				}
			}

			if (!empty($unknowArguments)) {
				throw new ApplicationException("Unknow arguments " . implode(', ', $unknowArguments) . '.');
			}

			$usedDefinitions = [];

			foreach ($arguments as $argument => $value) {
				$argumentDefinition = $argumentDefinitions[$argument];
				$result[$argument] = $argumentDefinition->processValue($argument, $value);
				$usedDefinitions[$argument] = TRUE;
			}

			// find unused definitions
			foreach ($argumentDefinitions as $argument => $argumentDefinition) {
				if (isset($usedDefinitions[$argument])) {
					continue;
				}

				$result[$argument] = $argumentDefinition->processValue($argument, NULL);
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
				->output('Usage:', 'yellow')
				->nl()
				->output('  command [options] -- [arguments]')
				->nl();

			$this->console->nl()
				->output('Available commands:', 'yellow')
				->nl();

			$len = 0;

			foreach ($this->commands as $commandName => $command) {
				$len = max($len, strlen($commandName));
			}

			foreach ($this->commands as $commandName => $command) {
				$commandDescription = $command->getDescription();
				$this->console->output('  ')
					->output($commandName, 'green');

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
