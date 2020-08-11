<?php

	namespace CzProject\PhpCli;


	class Exception extends \Exception
	{
	}


	class ApplicationException extends Exception
	{
	}


	class ConsoleException extends Exception
	{
	}


	class InputException extends Exception
	{
	}


	class InvalidArgumentException extends MissingException
	{
	}


	class InvalidStateException extends MissingException
	{
	}


	class InvalidValueException extends MissingException
	{
	}


	class MissingException extends Exception
	{
	}


	class MissingParameterException extends MissingException
	{
	}


	class OutputException extends Exception
	{
	}


	class ParametersParserException extends Exception
	{
	}


	class StaticClassException extends Exception
	{
	}
