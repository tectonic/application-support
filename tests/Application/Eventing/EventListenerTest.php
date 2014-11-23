<?php
namespace Tests\Application\Eventing;

use Mockery as m;
use Tests\Stubs\StubEvent;
use Tests\Stubs\StubEventListener;
use Tests\Stubs\StubUnhandledEvent;

class EventListenerTest extends \Tests\TestCase
{
    public function testListenOnAValidEventMethodShouldExecuteTheEventListener()
	{
        $string = 'listening for events..';
        $event = new StubEvent($string);
        $listener = new StubEventListener;

		$this->assertEquals($string, $listener->handle($event));
	}

    public function testNoMethodIsCalledIfNoListenerMethodIsPresent()
    {
        $listener = new StubEventListener;

        $this->assertNull($listener->handle(new StubUnhandledEvent('blah')));
    }
}
