PHP CLI Console
===============

Usage
-----

``` php
<?php
use CzProject\PhpCli\ConsoleFactory;
require __DIR__ . '/loader.php';

$console = ConsoleFactory::createConsole();

// output
$console->success('CzProject CLI Simple Console')
	->warning('Hey!')
	->info('Fred!')
	->error('Fred is dead!')
	->output('The end.');

// input
$username = $console->input('Enter your name:');

// disabled auto new line
$console->setAutoNewLine(FALSE) // disable auto new line
	->info('Hello! ')
	->success($username)
	->warning(' [user]')
	->setAutoNewLine(TRUE) // enable auto new line
	->nl() // print new line
	->info('Bye!');
```


Installation
------------

[Download a latest package](https://github.com/czproject/phpcli/releases) or use [Composer](http://getcomposer.org/):

```
composer require [--dev] czproject/phpcli
```

PhpCli requires PHP 5.3.0 or later, optionaly [Readline extension](http://www.php.net/manual/en/book.readline.php).


--------------------------------------------------------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, http://janpecha.iunas.cz/

