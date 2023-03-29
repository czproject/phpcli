PHP CLI Console
===============

[![Build Status](https://github.com/czproject/phpcli/workflows/Build/badge.svg)](https://github.com/czproject/phpcli/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/czproject/phpcli.svg)](https://packagist.org/packages/czproject/phpcli)
[![Latest Stable Version](https://poser.pugx.org/czproject/phpcli/v/stable)](https://github.com/czproject/phpcli/releases)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/czproject/phpcli/blob/master/license.md)

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>


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
$username = $console->input('Enter your name');

$console->output('Hello! ', 'blue')
	->output($username, 'green')
	->output(' [user]', 'yellow')
	->nl() // print new line
	->output('Bye!', 'blue')
	->nl();

// input with default value
$username = $console->input('Enter your name', 'John');

// confirm
$agree = $console->confirm('Do you want to continue?');

// confirm with default value
$canQuit = $console->confirm('Really?', TRUE);

// select
$value = $console->select('Select color:', [
	'value' => 'label',
	'#ff0000' => 'Red',
	'#00ff00' => 'Green',
	'#0000ff' => 'Blue',
]);

// select with default value
$value = $console->select('Select color:', [
	'value' => 'label',
	'#ff0000' => 'Red',
	'#00ff00' => 'Green',
	'#0000ff' => 'Blue',
], '#ff0000');
```


## Parameters

**Arguments**

```php
$name = $console->getArgument(0)->getValue(); // string|NULL

$size = $console->getArgument(1, 'int')
	->setRequired()
	->addRule(function ($value) {
		return $value > 0;
	})
	->getValue();

$price = $console->getArgument(2, 'float') // float
	->setDefaultValue(100.0)
	->getValue();
```


**Options**

```php
$name = $console->getOption('name')->getValue(); // string|NULL

$size = $console->getOption('size', 'int')
	->setRequired()
	->addRule(function ($value) {
		return $value > 0;
	})
	->getValue();

$price = $console->getOption('price', 'float') // float
	->setDefaultValue(100.0)
	->getValue();

$words = $console->getOption('word')
	->setRepeatable()
	->getValue();
```


**Supported types**

* `string`
* `int` and `integer`
* `float`
* `bool` and `boolean`

--------------------------------------------------------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
