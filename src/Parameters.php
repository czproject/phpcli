<?php

	namespace CzProject\PhpCli;


	class Parameters
	{
		/** @var array */
		private $options;

		/** @var array */
		private $arguments;


		public function __construct(array $options, array $arguments)
		{
			$this->options = $options;
			$this->arguments = array_values($arguments);
		}


		public function hasParameters()
		{
			return !empty($this->options) || !empty($this->arguments);
		}


		public function getOptions()
		{
			return $this->options;
		}


		public function getArguments()
		{
			return $this->arguments;
		}


		/**
		 * @param  string $name
		 * @return bool
		 */
		public function hasOption($name)
		{
			if (!is_string($name) || $name === '') {
				throw new InvalidArgumentException('Option name must be non-empty string.');
			}

			return isset($this->options[$name]);
		}


		/**
		 * @param  string $name
		 * @return mixed
		 */
		public function getOption($name)
		{
			if (!$this->hasOption($name)) {
				throw new MissingException("Missing option '$name'.");
			}

			return $this->options[$name];
		}


		/**
		 * @param  int $position
		 * @return bool
		 */
		public function hasArgument($position)
		{
			if (!is_int($position) || $position < 0) {
				throw new InvalidArgumentException('Position must be positive integer.');
			}

			return isset($this->arguments[$position]);
		}


		/**
		 * @param  int $position
		 * @return mixed
		 */
		public function getArgument($position)
		{
			if (!$this->hasArgument($position)) {
				throw new MissingException("Missing argument '$position'.");
			}

			return $this->arguments[$position];
		}
	}
