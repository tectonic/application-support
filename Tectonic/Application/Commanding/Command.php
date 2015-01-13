<?php
namespace Tectonic\Application\Commanding;

use Illuminate\Contracts\Support\Arrayable;

class Command implements Arrayable
{
	/**
	 * Returns an array of properties the command has registered.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return get_object_vars($this);
	}
}
