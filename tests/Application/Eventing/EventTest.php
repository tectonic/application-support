<?php namespace Tests\Application\Eventing;

use Mockery as m;
use Tests\Stubs\StubEvent;

class EventTest extends \Tests\TestCase
{
	public function testToJson()
	{
		$event = new StubEvent('Valuable');

		$this->assertEquals('{"property":"Valuable"}', $event->toJson());
	}

    public function testToArray()
    {
        $event = new StubEvent('El value');

        $this->assertArrayHasKey('property', $event->toArray());
        $this->assertEquals('El value', $event->toArray()['property']);
    }
}
