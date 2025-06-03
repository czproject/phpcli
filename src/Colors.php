<?php

	declare(strict_types=1);

	namespace CzProject\PhpCli;


	class Colors
	{
		const NO_COLOR = 'nocolor';
		const BLUE = 'blue';
		const GRAY = 'gray';
		const GREEN = 'green';
		const RED = 'red';
		const YELLOW = 'yellow';



		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}
	}
