<?php

namespace Tests\Application\Commanding;

use Tests\Stubs\StubCommand;
use Tectonic\Application\Commanding\CommandTranslator;
use Mockery as m;

class CommandTranslatorTest extends \Tests\TestCase
{
	public function testSuccesfulCommandHandlerResolution()
	{
		$command = new StubCommand;
		$translator = new CommandTranslator;

		$this->assertEquals($translator->getCommandHandler($command), 'Tests\Stubs\StubCommandHandler');
	}

	public function testFailedCommandHandlerResolution()
	{
		$command = m::mock('Tectonic\Application\Commanding\Command');
		$translator = new CommandTranslator;

		$this->setExpectedException('Tectonic\Application\Commanding\CommandHandlerNotFoundException');

		$translator->getCommandHandler($command);
	}
}
