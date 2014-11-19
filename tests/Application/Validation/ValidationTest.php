<?php
namespace Tests\Application\Validation;

use Mockery as m;
use Tectonic\Application\Validation\ValidationException;
use Tests\Stubs\StubValidator;
use Tests\UnitTestCase;

class ValidationTest extends \Tests\TestCase
{
    /**
     * @expectedException Tectonic\Application\Validation\ValidationException
     */
	public function testValidatingWithoutInputShouldThrowException()
	{
		$validator = new StubValidator([]);
        $validator->validate();
	}

    public function testReturnOfValidationErrors()
    {
        $validator = new StubValidator;

        try {
            $validator->validate();
        }
        catch (ValidationException $e) {
            $errors = $e->getFailedFields();

            $this->assertArrayHasKey('name', $errors);
        }
    }

    public function testInputReturnValues()
    {
        $input = ['key' => 'value'];

        $validator = new StubValidator;
        $validator->setInput($input);

        $this->assertEquals($input, $validator->getInput());
        $this->assertEquals('value', $validator->getValue('key'));
        $this->assertNull($validator->getValue('does not exist'));
    }
}
