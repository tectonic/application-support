<?php

namespace Tests\Application\Commanding;

use Tectonic\Application\Commanding\DefaultCommandBus;
use Mockery as m;

class DefaultCommandBusTest extends \Tests\TestCase
{
	public function testExecution()
	{
        $command = m::mock('Tectonic\Application\Commanding\Command');
        $container = m::mock('Illuminate\Container\Container')->makePartial();
        $translator = m::mock('Tectonic\Application\Commanding\CommandTranslator')->makePartial();

        $translator->shouldReceive('getCommandHandler')->with($command)->andReturn('handler');

        $container->shouldReceive('make')->once()->with('handler')->andReturn($container);
        $container->shouldReceive('handle')->once()->with($command)->andReturn('execution result');


		$commandBus = new DefaultCommandBus($container, $translator);
        $response = $commandBus->execute($command);

		$this->assertEquals($response, 'execution result');
	}
}
