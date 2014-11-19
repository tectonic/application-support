<?php
namespace Tectonic\Application\Commanding;

interface CommandHandlerInterface
{
	/**
	 * Handle the command.
	 *
	 * @param $command
	 */
	public function handle($command);
}
