<?php namespace Tests\Application\Eventing;

use Mockery as m;
use Tests\Stubs\StubEvent;
use Tests\Stubs\StubEventGenerator;

class EventGeneratorTest extends \Tests\TestCase
{
	public function testGenerator()
	{
        $event = new StubEvent('value');

		$generator = new StubEventGenerator;
        $generator->raise($event);

		$this->assertEquals([$event], $generator->releaseEvents());
	}
}
