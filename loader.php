<?php
	require __DIR__ . '/src/IInputProvider.php';
	require __DIR__ . '/src/IOutputFormatter.php';
	require __DIR__ . '/src/IParametersParser.php';

	require __DIR__ . '/src/Inputs/DefaultInputProvider.php';
	require __DIR__ . '/src/Inputs/ReadlineInputProvider.php';

	require __DIR__ . '/src/Outputs/BaseOutput.php';
	require __DIR__ . '/src/Outputs/TextOutput.php';
	require __DIR__ . '/src/Outputs/ColoredOutput.php';
	require __DIR__ . '/src/Outputs/NullOutput.php';

	require __DIR__ . '/src/Parameters/BaseParser.php';
	require __DIR__ . '/src/Parameters/DefaultParametersParser.php';

	require __DIR__ . '/src/Console.php';
	require __DIR__ . '/src/ConsoleFactory.php';

