<?php
namespace Tests\Stubs;

use Tectonic\Application\Eventing\EventListener;

class StubEventListener extends EventListener
{
	public function whenStubEvent($event)
    {
        return $event->property;
    }
}
