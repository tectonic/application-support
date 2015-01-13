<?php
namespace Tectonic\Application\Eventing;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Event
 * @package Application\Eventing
 */

abstract class Event implements Jsonable, Arrayable
{
    /**
     * When the dispatcher fires off each of the events, logging may be required. This provides
     * a JSON format of the data that was provided as part of the event for easy storage.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    /**
     * Return an array of the property-value pairs of the object.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
} 