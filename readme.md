PHP CLI Console
===============

[![Build Status](https://travis-ci.org/czproject/phpcli.svg?branch=master)](https://travis-ci.org/czproject/phpcli)

<a href="https://www.patreon.com/bePatron?u=9680759"><img src="https://c5.patreon.com/external/logo/become_a_patron_button.png" alt="Become a Patron!" height="35"></a>
<a href="https://www.paypal.me/janpecha/1eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>


Installation
------------

[Download a latest package](https://github.com/czproject/phpcli/releases) or use [Composer](http://getcomposer.org/):

```
composer require czproject/phpcli
```

PhpCli requires PHP 5.6 or later, optionaly [Readline extension](http://www.php.net/manual/en/book.readline.php).


Usage
-----

``` php
use CzProject\PhpCli\ConsoleFactory;

require __DIR__ . '/vendor/autoload.php';

$console = ConsoleFactory::createConsole();

// output
$console->output('CzProject CLI Simple Console', 'green')
	->nl() // new line
	->output('Hey!', 'yellow')
	->nl()
	->output('Fred!', 'blue')
	->nl()
	->output('Fred is dead!', 'red')
	->nl()
	->output(['nooooooo...!', ' ', 'But, no problem!'], 'gray')
	->nl()
	->output('The end.')
	->nl();

// input
$username = $console->input('Enter your name:');

$console->output('Hello! ', 'blue')
	->output($username, 'green')
	->output(' [user]', 'yellow')
	->nl() // print new line
	->output('Bye!', 'blue')
	->nl();
```

--------------------------------------------------------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
