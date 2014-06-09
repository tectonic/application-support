<?php namespace Tests\Application\Eventing;

use Tectonic\Application\Eventing\EventDispatcher;
use Mockery as m;
use Tests\Stubs\StubEvent;

class EventListenerTest extends \Tests\TestCase
{
    private $dispatcher;
    private $illuminateDispatcher;
    private $logger;

    public function setUp()
    {
        $this->illuminateDispatcher = m::mock('Illuminate\Events\Dispatcher');
        $this->logger = m::mock('Illuminate\Log\Writer');

        $this->dispatcher = new EventDispatcher($this->illuminateDispatcher, $this->logger);
    }

	public function testGenerator()
	{
        $event = new StubEvent('value');
        $events = [$event];

        $this->logger->shouldReceive('info')->once()->with('Tests.Stubs.StubEvent was fired with: {"property":"value"}');
        $this->illuminateDispatcher->shouldReceive('fire')->once()->with('Tests.Stubs.StubEvent', $event);

		$this->dispatcher->dispatch($events);
	}
}
