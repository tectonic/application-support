<?php

namespace Tectonic\Application\Commanding;

interface CommandBusInterface
{
	public function execute(Command $command);
}
