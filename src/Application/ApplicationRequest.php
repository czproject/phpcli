<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli\Application;


	class ApplicationRequest
	{
		/** @var string */
		private $commandName;

		/** @var array<string, mixed> */
		private $options;

		/** @var array<int, mixed> */
		private $arguments;


		/**
		 * @param string $commandName
		 * @param array<string, mixed> $options
		 * @param array<int, mixed> $arguments
		 */
		public function __construct($commandName, array $options, array $arguments)
		{
			$this->commandName = $commandName;
			$this->options = $options;
			$this->arguments = $arguments;
		}


		/**
		 * @return string
		 */
		public function getCommandName()
		{
			return $this->commandName;
		}


		/**
		 * @return array<string, mixed>
		 */
		public function getOptions()
		{
			return $this->options;
		}


		/**
		 * @return array<int, mixed>
		 */
		public function getArguments()
		{
			return $this->arguments;
		}
	}
