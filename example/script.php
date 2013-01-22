<?php
	/** Example PHP script for PhpCli library
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 * @version		2013-01-22-1
	 */
	
	use Cz\Cli;
	
	require __DIR__ . '/../Cli.php';
	
	Cli::log('Hello!');
	Cli::error('Error!');
	Cli::success('Success!');
	Cli::warn('Warning!');
	Cli::info('Info!');
	
	Cli::format('Hello!!');
	Cli::format('Hello!!', TRUE);
	Cli::format('Hello!!', FALSE, Cli::C_YELLOW);
	Cli::format('Hello!!', TRUE, Cli::C_YELLOW);
	Cli::format('Hello!!', FALSE, Cli::C_RED);
	Cli::format('Hello!!', TRUE, Cli::C_RED);
	Cli::format('Hello!!', TRUE, Cli::C_CYAN);
	Cli::format('$ php -f heymaster.phpc', TRUE, Cli::C_BLUE);
	
	echo "\n\n";
	Cli::format(' $ ', 0, Cli::C_WHITE);
	Cli::format('php', 0, Cli::C_GREEN);
	Cli::format(' -f ', 0, Cli::C_BLUE);
	Cli::format('heymaster.phpc', 0, Cli::C_YELLOW);
	Cli::format(' -- ', 0, Cli::C_BLUE);
	Cli::format('heymaster.neon', 0, Cli::C_RED);
	Cli::format(' [<params>] ', 0, Cli::C_PURPLE);
	
	echo "\n";
