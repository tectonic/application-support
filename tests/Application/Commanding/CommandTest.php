<?php

namespace Tests\Application\Commanding;

use Tests\Stubs\StubCommand;

class CommandTest extends \Tests\TestCase
{
	public function testToArray()
	{
		$command = new StubCommand;

		$command->name = 'Kirk';

		$this->assertEquals($command->name, $command->toArray()['name']);
	}
}
