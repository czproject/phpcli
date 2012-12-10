<?php
	/** Example PHP script for PhpCli library
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 * @version		2012-12-10-1
	 */
	
	require __DIR__ . '/../Cli.php';
	
	class Cli extends Cz\Cli
	{
		const COLOR_ERROR = '1;31';
	}
	
	Cli::log('Hello!');
	Cli::error('Error!');
	Cli::success('Success!');
	Cli::warn('Warning!');
	Cli::info('Info!');

