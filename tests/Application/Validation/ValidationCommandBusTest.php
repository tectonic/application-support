<?php

namespace Tests\Application\Validation;

use Tectonic\Application\Validation\ValidationCommandBus;
use Mockery as m;
use Tests\Stubs\StubCommand;

class ValidationCommandBusTest extends \Tests\TestCase
{
    private $defaultCommandBus;
    private $container;
    private $validationCommandBus;

    public function setUp()
    {
        $this->defaultCommandBus = m::mock('Tectonic\Application\Commanding\DefaultCommandBus')->makePartial();
        $this->container = m::mock('Illuminate\Container\Container')->makePartial();

        $this->validationCommandBus = new ValidationCommandBus($this->defaultCommandBus, $this->container);
    }

    /**
     * The following test should not execute any validation as the validator should not exist.
     */
    public function testExecutionWithNonExistentValidator()
	{
        $command = m::mock('Tectonic\Application\Commanding\Command');

        $this->defaultCommandBus->shouldReceive('execute')->once()->andReturn('executed');

        $response = $this->validationCommandBus->execute($command);

		$this->assertEquals($response, 'executed');
	}

    /**
     * The following should succeed but also pass through the validator object.
     */
    public function testExecutionWithValidator()
    {
        $command = new StubCommand();

        $this->defaultCommandBus->shouldReceive('execute')->once()->andReturn('all is well');

        $response = $this->validationCommandBus->execute($command);

        $this->assertEquals($response, 'all is well');
    }
}
