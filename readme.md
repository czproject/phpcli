PHP CLI Console
===============

Usage
-----

``` php
<?php

use CzProject\PhpCli\ConsoleFactory;

require __DIR__ . '/vendor/autoload.php';

$console = ConsoleFactory::createConsole();

// output
$console->success('CzProject CLI Simple Console')
	->nl() // new line
	->warning('Hey!')
	->nl()
	->info('Fred!')
	->nl()
	->error('Fred is dead!')
	->nl()
	->muted('nooooooo...!', ' ', 'But, no problem!')
	->nl()
	->output('The end.')
	->nl();

// input
$username = $console->input('Enter your name:');

// disabled auto new line
$console->info('Hello! ')
	->success($username)
	->warning(' [user]')
	->nl() // print new line
	->info('Bye!')
	->nl();

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
