<?php

namespace CzProject\PhpCli\Tests;

use CzProject\PhpCli\Application\ICommand;
use CzProject\PhpCli\Console;


class TestCommand implements ICommand
{
	private $description;
	private $options;
	private $callback;


	public function setCallback($callback)
	{
		$this->callback = $callback;
		return $this;
	}


	public function getDescription()
	{
		return $this->description;
	}


	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}


	public function getOptions()
	{
		return $this->options;
	}


	public function setOptions($options)
	{
		$this->options = $options;
		return $this;
	}


	public function run(Console $console, array $options, array $arguments)
	{
		if (isset($this->callback)) {
			call_user_func($this->callback, $console, $options, $arguments);
		}
	}


	public static function create()
	{
		return new static;
	}
}
