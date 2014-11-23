<?php
namespace Tests\Application\Eventing;

use Tectonic\Application\Eventing\EventDispatcher;
use Mockery as m;
use Tests\Stubs\StubEvent;

class EventDispatcherTest extends \Tests\TestCase
{
    private $dispatcher;
    private $illuminateDispatcher;
    private $logger;

    public function setUp()
    {
        parent::setUp();

        $this->illuminateDispatcher = m::spy('Illuminate\Events\Dispatcher');
        $this->logger = m::spy('Illuminate\Log\Writer');

        $this->dispatcher = new EventDispatcher($this->illuminateDispatcher, $this->logger);
    }

	public function testDispatcher()
	{
        // Arrange/given
        $events = [new StubEvent('value')];

        // Act/when
		$this->dispatcher->dispatch($events);

        // Assert/then
        $this->illuminateDispatcher->shouldHaveReceived('fire')->once();
        $this->logger->shouldHaveReceived('info')->once();
	}
}
