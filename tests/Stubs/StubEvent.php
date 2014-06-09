<?php namespace Tests\Stubs;

use Tectonic\Application\Eventing\Event;

class StubEvent extends Event
{
    public function __construct($property)
    {
        $this->property = $property;
    }
}
