<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli\Application;

	use CzProject\PhpCli\ApplicationException;
	use CzProject\PhpCli\Colors;
	use CzProject\PhpCli\Console;
	use CzProject\PhpCli\ConsoleFactory;
	use CzProject\PhpCli\Parameters;


	class Application
	{
		/** @var Console */
		protected $console;

		/** @var array<string, ICommand> */
		protected $commands = [];

		/** @var string|NULL */
		protected $applicationName;

		/** @var string|NULL */
		protected $defaultCommand;


		/**
		 * @param string|NULL $applicationName
		 * @param string|NULL $defaultCommand
		 * @param array<string, ICommand> $commands
		 */
		public function __construct(
			?Console $console = NULL,
			$applicationName = NULL,
			$defaultCommand = NULL,
			array $commands = []
		)
		{
			$this->console = $console ? $console : ConsoleFactory::createConsole();
			$this->applicationName = $applicationName;
			$this->defaultCommand = $defaultCommand;
			$this->commands = $commands;
		}


		/**
		 * @param  string|NULL $defaultCommand
		 * @return static
		 */
		public function setDefaultCommand($defaultCommand)
		{
			$this->defaultCommand = $defaultCommand;
			return $this;
		}


		/**
		 * @return static
		 */
		public function addCommand(ICommand $command)
		{
			$name = $command->getName();

			if (isset($this->commands[$name])) {
				throw new \CzProject\PhpCli\InvalidArgumentException("Command '$name' already exists.");
			}

			$this->setCommand($name, $command);
			return $this;
		}


		/**
		 * @param  string $name
		 * @return static
		 */
		public function setCommand($name, ICommand $command)
		{
			$this->commands[$name] = $command;
			return $this;
		}


		/**
		 * @param  string|NULL $applicationName
		 * @return static
		 */
		public function setApplicationName($applicationName)
		{
			$this->applicationName = $applicationName;
			return $this;
		}


		/**
		 * @return void
		 */
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


		/**
		 * @return void
		 */
		public function printException(\Exception $e)
		{
			$console = $this->console;
			$console->nl();
			$console->output('ERROR: ' . $e->getMessage(), Colors::RED);
			$console->nl();
			$console->nl();
			$console->output('Details:', Colors::RED);
			$console->nl();
			$console->output(' - type: ' . get_class($e), Colors::RED);
			$console->nl();
			$console->output(' - code: ' . $e->getCode(), Colors::RED);
			$console->nl();
			$console->output(' - file: ' . $e->getFile(), Colors::RED);
			$console->nl();
			$console->output(' - line: ' . $e->getLine(), Colors::RED);
			$console->nl();
		}


		/**
		 * @return ApplicationRequest|NULL
		 */
		protected function createRequest(Parameters $parameters)
		{
			$command = NULL;
			$options = $parameters->getOptions();
			$arguments = $parameters->getArguments();

			if (!empty($arguments)) {
				$command = array_shift($arguments);

				if (!is_string($command)) {
					throw new \CzProject\PhpCli\ApplicationException('Command name in first argument must be string, ' . gettype($command) . ' given.');
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
		 * @param array<string, mixed> $options
		 * @return array<string, mixed>
		 */
		protected function processOptions(array $options, ?CommandParameters $parameters = NULL)
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
		 * @param  array<int, mixed> $arguments
		 * @return array<int, mixed>
		 */
		protected function processArguments(array $arguments, ?CommandParameters $parameters = NULL): array
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


		/**
		 * @return void
		 */
		protected function printHelp()
		{
			if (isset($this->applicationName)) {
				$this->console->nl()
					->output($this->applicationName)
					->nl();
			}

			$this->console->nl()
				->output('Usage:', Colors::YELLOW)
				->nl()
				->output('  command [options] -- [arguments]')
				->nl();

			$this->console->nl()
				->output('Available commands:', Colors::YELLOW)
				->nl();

			$len = 0;

			foreach ($this->commands as $commandName => $command) {
				$len = max($len, strlen($commandName));
			}

			foreach ($this->commands as $commandName => $command) {
				$commandDescription = $command->getDescription();
				$this->console->output('  ')
					->output($commandName, Colors::GREEN);

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
