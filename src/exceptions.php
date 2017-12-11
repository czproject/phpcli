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


	class ParameterParserException extends Exception
	{
	}


	class StaticClassException extends Exception
	{
	}
