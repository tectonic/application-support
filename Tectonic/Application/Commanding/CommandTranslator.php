<?php namespace Tectonic\Application\Commanding;

/**
 * Class CommandTranslator
 *
 * The command translator looks at a command's class name and derives the handler from it. The command
 * handler should resolve to the same namespace as the command handler. If no command handler can be
 * found for the required command, it will throw a CommandNotFoundException.
 *
 * @package Application\Commanding
 */

class CommandTranslator
{
    /**
     * Retrieves the command handler for a given command.
     *
     * @param Command $command
     * @return mixed
     * @throws CommandHandlerNotFoundException
     */
    public function getCommandHandler(Command $command)
	{
		$handler = str_replace('Command', 'CommandHandler', get_class($command));

		if (!class_exists($handler)) {
            throw new CommandHandlerNotFoundException($handler);
		}

		return $handler;
	}
}
