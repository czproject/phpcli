<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli;


	class Types
	{
		const BOOL = 'bool';
		const BOOLEAN = 'boolean';
		const STRING = 'string';
		const INT = 'int';
		const INTEGER = 'integer';
		const FLOAT = 'float';



		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}
	}
