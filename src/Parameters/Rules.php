<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli\Parameters;


	class Rules
	{
		/** @var array<array{0: callable, 1: string|NULL}> */
		private $rules = [];


		/**
		 * @param  string|NULL $errorMessage
		 * @return void
		 */
		public function addRule(callable $rule, $errorMessage = NULL)
		{
			$this->rules[] = [$rule, $errorMessage];
		}


		/**
		 * @param  mixed $value
		 * @param  string|NULL $errorSuffix
		 * @return void
		 */
		public function validate($value, $errorSuffix = NULL)
		{
			foreach ($this->rules as $rule) {
				$isValid = call_user_func($rule[0], $value);

				if (!$isValid) {
					throw new \CzProject\PhpCli\InvalidValueException('Invalid value'
						. ($errorSuffix !== NULL ? " for $errorSuffix"  : '')
						. ($rule[1] !== NULL ? ": {$rule[1]}" : '') . '.'
					);
				}
			}
		}
	}
