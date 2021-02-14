<?php

	namespace CzProject\PhpCli\Inputs;

	use CzProject\PhpCli\Helpers;
	use CzProject\PhpCli\IInputProvider;


	class MemoryInputProvider implements IInputProvider
	{
		/** @var string[] */
		private $inputs = [];


		/**
		 * @param  string[] $inputs
		 * @return void
		 */
		public function setInputs(array $inputs)
		{
			$this->inputs = $inputs;
		}


		public function readInput()
		{
			if (empty($this->inputs)) {
				throw new \CzProject\PhpCli\InvalidStateException('Missing inputs.');
			}

			return Helpers::normalizeInput(array_shift($this->inputs));
		}
	}
