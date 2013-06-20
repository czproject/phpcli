<?php
	require __DIR__ . '/IInputProvider.php';
	require __DIR__ . '/IOutputFormatter.php';
	require __DIR__ . '/IParametersParser.php';
	
	require __DIR__ . '/Inputs/DefaultInputProvider.php';
	require __DIR__ . '/Inputs/ReadlineInputProvider.php';
	
	require __DIR__ . '/Outputs/BaseOutput.php';
	require __DIR__ . '/Outputs/TextOutput.php';
	require __DIR__ . '/Outputs/ColoredOutput.php';
	
	require __DIR__ . '/Parameters/BaseParser.php';
	require __DIR__ . '/Parameters/DefaultParametersParser.php';
	
	require __DIR__ . '/Console.php';
	require __DIR__ . '/ConsoleFactory.php';

