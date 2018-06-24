PHP CLI Console
===============

<a href="https://www.patreon.com/bePatron?u=9680759"><img src="https://c5.patreon.com/external/logo/become_a_patron_button.png" alt="Become a Patron!" height="35"></a>
<a href="https://www.paypal.me/janpecha/1eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>


Installation
------------

[Download a latest package](https://github.com/czproject/phpcli/releases) or use [Composer](http://getcomposer.org/):

```
composer require czproject/phpcli
```

PhpCli requires PHP 5.3.0 or later, optionaly [Readline extension](http://www.php.net/manual/en/book.readline.php).


Usage
-----

``` php
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

$console->info('Hello! ')
	->success($username)
	->warning(' [user]')
	->nl() // print new line
	->info('Bye!')
	->nl();

```

--------------------------------------------------------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
