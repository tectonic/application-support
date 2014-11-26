<?php
namespace Tectonic\Application\Commanding;

use Illuminate\Container\Container;
use Illuminate\Log\Writer;

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
     * @var Writer
     */
    private $log;

    /**
	 * Construct the default command bus utilising the application container and the command translator.
	 *
	 * @param Container $app
	 * @param CommandTranslator $commandTranslator
	 */
	public function __construct(Container $app, CommandTranslator $commandTranslator, Writer $log)
	{
		$this->app = $app;
		$this->commandTranslator = $commandTranslator;
        $this->log = $log;
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
        $commandName = $this->getCommandName($command);

        $this->log->info("New command [$commandName]", get_object_vars($command));

		return $this->app->make($handler)->handle($command);
	}

    /**
     * @param Command $command
     * @return mixed
     */
    private function getCommandName($command)
    {
        $eventName = str_replace('\\', '.', get_class($command));

        return $eventName;
    }
}
