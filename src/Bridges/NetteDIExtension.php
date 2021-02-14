<?php

	namespace CzProject\PhpCli\Bridges;

	use Nette;


	class NetteDIExtension extends Nette\DI\CompilerExtension
	{
		private $defaults = [
			'applicationName' => NULL,
		];


		public function loadConfiguration()
		{
			$this->validateConfig($this->defaults);

			$builder = $this->getContainerBuilder();
			$builder->addDefinition($this->prefix('application'))
				->setFactory(\CzProject\PhpCli\Application\Application::class)
				->addSetup('setApplicationName', [$this->config['applicationName']]);
		}


		public function beforeCompile()
		{
			$builder = $this->getContainerBuilder();
			$application = $builder->getDefinition($this->prefix('application'));

			foreach ($builder->findByType(\CzProject\PhpCli\Application\ICommand::class) as $definition) {
				$application->addSetup('addCommand', [$definition]);
			}
		}
	}
