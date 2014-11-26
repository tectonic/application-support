<?php
namespace Tectonic\Application\Eventing;

class EventListener
{
	/**
	 * Handle the event that has been triggered.
	 *
	 * @param Event $event
	 * @return mixed
	 */
	public function handle(Event $event)
	{
		$eventName = $this->getEventName($event);

		if (($method = $this->listenerIsRegistered($eventName))) {
			return call_user_func([$this, $method], $event);
		}
	}

	/**
	 * Get the event name based on the event class that is being used.
	 *
	 * @param Event $event
	 * @return string
	 */
	protected function getEventName(Event $event)
	{
		return class_basename($event);
	}

	/**
	 * Check to see if a given listener is registered for an event.
	 *
	 * @param $eventName
	 * @return mixed Returns the method name on success, or false on failure
	 */
	protected function listenerIsRegistered($eventName)
	{
		$method = "when{$eventName}";

		return method_exists($this, $method) ? $method : false;
	}
}
