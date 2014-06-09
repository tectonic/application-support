<?php namespace Tectonic\Application\Eventing;

/**
 * Trait EventGenerator
 *
 * Implemented in classes that need to raise events.
 *
 * @package Application\Eventing
 */

trait EventGenerator
{
    /**
     * @var array
     */
    protected $pendingEvents = [];

    /**
     * Raise a new event, appending the event to the events array on the class.
     *
     * @param $event
     */
    public function raise(Event $event)
	{
		$this->pendingEvents[] = $event;
	}

    /**
     * Returns and clears the pending events array.
     *
     * @return array
     */
    public function releaseEvents()
	{
		$events = $this->pendingEvents;

		$this->pendingEvents = [];

		return $events;
	}
}
