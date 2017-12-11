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
		 * @param  string
		 * @param  ICommand
		 * @return static
		 */
		public function addCommand($name, ICommand $command)
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
				$options = $this->processOptions($request->getOptions(), $commandOptions !== NULL ? $commandOptions : array());
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
			$options = array();
			$arguments = array();

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
			$result = array();

			foreach ($definitions as $name => $definition) {
				$originalName = $name;
				$originalValue = NULL;
				$isAlias = FALSE;

				if (isset($options[$name])) {
					$originalValue = $options[$name];
					unset($options[$name]);
				}

				if (is_string($definition) || isset($definition['alias'])) {
					$aliasName = is_string($definition) ? $definition : $definition['alias'];

					if (!is_string($aliasName)) {
						throw new ApplicationException("Alias in option '$optionName' must be string, " . gettype($aliasName) . ' given.');
					}

					if (!isset($definitions[$aliasName])) {
						throw new ApplicationException("Unknow alias '$aliasName' in option '$name'.");
					}

					$definition = $definitions[$aliasName];
					$name = $aliasName;
					$isAlias = TRUE;
				}

				if ($isAlias && $originalValue === NULL) {
					continue;
				}

				if (!is_array($definition)) {
					throw new ApplicationException("Definition of option '$name' must be array, " . gettype($definition) . ' given.');
				}

				if (array_key_exists($name, $result)) { // because aliases
					throw new ApplicationException("Value for option '$name' already exists. Remove option '$originalName' from parameters.");
				}

				$result[$name] = $this->processOption($name, $originalValue, $definition);
			}

			if (!empty($options)) {
				$labels = array_map(function ($label) {
					return '\'' . $label . '\'';
				}, array_keys($options));

				throw new ApplicationException("Unknow options " . implode(', ', $labels) . '.');
			}

			return $result;
		}


		protected function processOption($name, $value, array $definition)
		{
			static $types = array(
				'boolean',
				'bool',
				'integer',
				'int',
				'float',
				'string',
			);

			if (!isset($definition['type'])) {
				throw new ApplicationException("Missing 'type' definition for option '$name'.");
			}

			if (!is_string($definition['type'])) {
				throw new ApplicationException("Invalid 'type' definition for option '$name'. Type must be string, " . gettype($definition['type']) . ' given.');
			}

			$type = strtolower($definition['type']);
			$required = isset($definition['required']) && $definition['required'];
			$nullable = isset($definition['nullable']) && $definition['nullable'];
			$repeatable = isset($definition['repeatable']) && $definition['repeatable'];
			$defaultValue = isset($definition['defaultValue']) ? $definition['defaultValue'] : NULL;
			$value = isset($value) ? $value : $defaultValue;

			if (!in_array($type, $types, TRUE)) {
				throw new ApplicationException("Unknow type '$type' in definition for option '$name'.");
			}

			if ($value === NULL && $required) {
				throw new ApplicationException("Missing value for required option '$name'.");
			}

			if ($repeatable && !is_array($value)) {
				$value = array($value);
			}

			if (!$repeatable && is_array($value)) {
				throw new ApplicationException("Multiple values for option '$name'.");
			}

			if ($nullable && ((is_array($value) && empty($value)) || $value === '')) {
				$value = NULL;
			}

			// set type
			if ($value !== NULL) {
				if (is_array($value)) {
					$values = array();

					foreach ($value as $val) {
						$values[] = $this->convertType($name, $val, $type);
					}

					$value = $values;

				} else {
					$value = $this->convertType($name, $value, $type);
				}
			}

			return $value;
		}


		protected function convertType($name, $value, $type)
		{
			if ($type === 'bool' || $type === 'boolean') {
				if (is_string($value)) {
					$lValue = strtolower($value);

					if ($lValue === 'yes' || $lValue === 'y' || $lValue === 'on' || $lValue === 'true' || $lValue === '1') {
						return TRUE;

					} elseif ($lValue === 'no' || $lValue === 'n' || $lValue === 'off' || $lValue === 'false' || $lValue === '0') {
						return FALSE;
					}

				} elseif (is_bool($value) || is_int($value) || is_float($value)) {
					return (bool) $value;
				}

				throw new \CzProject\PhpCli\InvalidValueException("Invalid boolean value for option '$name'.");

			} elseif ($type === 'string' || $type === 'int' || $type === 'integer' || $type === 'float') {
				settype($value, $type);
				return $value;
			}

			throw new \CzProject\PhpCli\InvalidArgumentException("Unknow type '$type'.");
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
