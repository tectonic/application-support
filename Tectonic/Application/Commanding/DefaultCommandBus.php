<?php
namespace Tectonic\Application\Commanding;

use Illuminate\Container\Container;

class DefaultCommandBus implements CommandBusInterface
{
	/**
	 * Stores the application container instance.
	 *
	 * @var \Illuminate\Container\Container
	 */
	private $app;

	/**
	 * Stores the command translator.
	 *
	 * @var CommandTranslator
	 */
	protected $commandTranslator;

	/**
	 * Construct the default command bus utilising the application container and the command translator.
	 *
	 * @param Container $app
	 * @param CommandTranslator $commandTranslator
	 */
	public function __construct(Container $app, CommandTranslator $commandTranslator)
	{
		$this->app = $app;
		$this->commandTranslator = $commandTranslator;
	}

	/**
	 * Execute the required command against the command handler.
	 *
	 * @param Command $command
	 * @return mixed
	 */
	public function execute(Command $command)
	{
		$handler = $this->commandTranslator->getCommandHandler($command);

		return $this->app->make($handler)->handle($command);
	}
}
