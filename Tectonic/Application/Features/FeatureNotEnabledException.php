<?php namespace Application\Features;

class FeatureNotEnabledException extends \Exception
{
    public function __construct(FeatureInterface $feature)
    {
        $this->message = 'The '. $feature->name().' is not currently enabled. We apologise for any inconvenience this may cause.';
    }
}
