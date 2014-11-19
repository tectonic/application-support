<?php
namespace Tests\Stubs;

use Tectonic\Application\Validation\Validator;

class StubValidator extends Validator
{
    protected $rules = [
        'name' => 'required'
    ];
}
