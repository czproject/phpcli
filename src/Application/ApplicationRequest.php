<?php

	namespace CzProject\PhpCli\Application;


	class ApplicationRequest
	{
		/** @var string */
		private $commandName;

		/** @var array */
		private $options;

		/** @var array */
		private $arguments;


		/**
		 * @param string
		 */
		public function __construct($commandName, array $options, array $arguments)
		{
			$this->commandName = $commandName;
			$this->options = $options;
			$this->arguments = $arguments;
		}


		/**
		 * @return array
		 */
		public function getCommandName()
		{
			return $this->commandName;
		}


		/**
		 * @return array
		 */
		public function getOptions()
		{
			return $this->options;
		}


		/**
		 * @return array
		 */
		public function getArguments()
		{
			return $this->arguments;
		}
	}
