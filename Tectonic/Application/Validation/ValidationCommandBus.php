<?php
namespace Tectonic\Application\Validation;

use Tectonic\Application\Commanding\Command;
use Tectonic\Application\Commanding\CommandBusInterface;
use Tectonic\Application\Commanding\DefaultCommandBus;
use Illuminate\Container\Container;
use ReflectionException;

/**
 * Class ValidationCommandBus
 *
 * Shamelessly stolen from the LIO codebase: https://github.com/LaravelIO/laravel.io
 * Basically wraps our default CommandBus and implements validation rules, hence acting as a decorator
 * for the default command bus.
 *
 * @package Application\Commanding
 */

class ValidationCommandBus implements CommandBusInterface
{
	/**
	 * Stores the application container instance.
	 *
	 * @var
	 */
	private $app;

	/**
	 * Stores the default command bus which we'll execute commands against if validation succeeds.
	 *
	 * @var DefaultCommandBus
	 */
	private $bus;

	/**
	 * Setup our constructor, make sure we have access to the default command bus which will be used
	 * to execute any functionality if validation passes.
	 *
	 * @param DefaultCommandBus $bus
	 * @param Container $app
	 */
	public function __construct(DefaultCommandBus $bus, Container $app)
	{
		$this->bus = $bus;
		$this->app = $app;
	}

	/**
	 * Execute the command, but first run it through our custom validation command handlers.
	 *
	 * @param Command $command
	 * @return mixed
	 */
	public function execute(Command $command)
	{
		$this->validate($command);

		return $this->bus->execute($command);
	}

	/**
	 * Validate any input based on the command provided.
	 *
	 * @param $command
	 * @return mixed
	 */
	private function validate($command)
	{
		$validatorClass = $this->getValidatorClassName($command);

        if (class_exists($validatorClass)) {
			$validator = $this->app->make($validatorClass);
			$validator->validate($command);
		}
	}

	/**
	 * Returns the name of the required validation class.
	 *
	 * @param $command
	 * @return string
	 */
	private function getValidatorClassName($command)
	{
		return preg_replace('/Command$/', 'Validator', get_class($command));
	}
} 
