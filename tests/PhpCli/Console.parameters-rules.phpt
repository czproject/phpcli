<?php

declare(strict_types=1);

use CzProject\PhpCli\Tests;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$console = Tests\TestConsoleFactory::create([
	'image.jpg',
	'--width', '1000',
	'--height', '1500',
]);


Assert::exception(function () use ($console) {

	$console->getOption('width', 'int')
		->addRule(function ($value) {
			return $value > 1500;
		})
		->getValue();

}, CzProject\PhpCli\InvalidValueException::class, "Invalid value for option 'width'.");



Assert::exception(function () use ($console) {

	$console->getOption('height', 'int')
		->addRule(function ($value) {
			return $value > 1500;
		}, 'Height must be greater than 1500')
		->getValue();

}, CzProject\PhpCli\InvalidValueException::class, "Invalid value for option 'height': Height must be greater than 1500.");


Assert::exception(function () use ($console) {

	$console->getArgument(0, 'string')
		->addRule(function ($value) {
			return substr($value, -4) === '.png';
		}, 'Only PNG is supported')
		->getValue();

}, CzProject\PhpCli\InvalidValueException::class, "Invalid value for argument #0: Only PNG is supported.");
