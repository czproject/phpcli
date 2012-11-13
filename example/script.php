<?php
	/** Example PHP script for PhpCli library
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 * @version		2012-11-13-1
	 */
	
	use Cz\Cli;
	
	require __DIR__ . '/../Cli.php';
	
	Cli::log('Hello!');
	Cli::error('Error!');
	Cli::success('Success!');
	Cli::warn('Warning!');
	Cli::info('Info!');

