<?php
namespace Tectonic\Application\Commanding;

class CommandHandlerNotFoundException extends \Exception
{
    public function __construct($handler)
    {
        $this->message = $message = "Command handler [$handler] does not exist.";
    }
}
