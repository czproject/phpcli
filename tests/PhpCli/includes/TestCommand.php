<?php

namespace CzProject\PhpCli\Tests;

use CzProject\PhpCli\Application\ICommand;
use CzProject\PhpCli\Application\CommandParameters;
use CzProject\PhpCli\Console;


class TestCommand implements ICommand
{
	private $description;
	private $parameters;
	private $callback;


	public function getName()
	{
		return 'TEST';
	}


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


	public function getParameters()
	{
		return $this->parameters;
	}


	public function setParameters(callable $parametersFactory)
	{
		$parameters = new CommandParameters;
		$parametersFactory($parameters);
		$this->parameters = $parameters;
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
