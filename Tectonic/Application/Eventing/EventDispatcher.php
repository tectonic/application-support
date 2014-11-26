<?php
namespace Tectonic\Application\Eventing;

use Illuminate\Events\Dispatcher;
use Illuminate\Log\Writer;

/**
 * Class EventDispatcher
 *
 * @package Application\Eventing
 */
class EventDispatcher
{
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $event;

    /**
     * @var \Illuminate\Log\Writer
     */
    protected $log;

    /**
     * @param Dispatcher $event
     * @param Writer $log
     */
    public function __construct(Dispatcher $event, Writer $log)
    {
        $this->event = $event;
        $this->log = $log;
    }

    /**
     * Dispatches the array of events, firing off the appropriate event name for each and logging the event fired.
     *
     * @param array $events
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $eventName = $this->getEventName($event);
            
            $this->log->info("New event [$eventName]", [get_object_vars($event)]);
            $this->event->fire($eventName, $event);
        }
    }

    /**
     * Retrieve the event name for a given event. The string returned will be in dot notation.
     * For example, if the event raised is called Domain\UserHasRegisteredToday then the event fired would be:
     *
     * Domain.UserHasRegistered
     *
     * Think of it as dot notation for PHP namespaces.
     *
     * @param Event $event
     * @return string
     */
    protected function getEventName(Event $event)
    {
        $eventName = str_replace('\\', '.', get_class($event));

        return $eventName;
    }
}
