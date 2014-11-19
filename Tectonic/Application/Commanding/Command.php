<?php
namespace Tectonic\Application\Commanding;

use Illuminate\Support\Contracts\ArrayableInterface;

class Command implements ArrayableInterface
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
