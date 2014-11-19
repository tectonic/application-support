<?php
namespace Tectonic\Application\Validation;

use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Validation\Validator as LaravelValidator;

class ValidationException extends \Exception implements JsonableInterface
{
    /**
     * The default message for all validation. This gets returned along with the errors.
     *
     * @var string
     */
    protected $message = 'There is something wrong with the input provided. Please check the information you have entered and try again.';

    /**
     * Holds the validator instance that was used for validation.
     *
     * @var Validator
     */
    private $validator;

    public function __construct(LaravelValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Returns the validation errors that were generated at validation time.
     *
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validator->messages()->all();
    }
    
    /**
     * Returns an array of the field names that failed validation.
     *
     * @return array
     */
    public function getFailedFields()
    {
        return $this->validator->failed();
    }

    /**
     * Returns the validator that was used for the validation.
     *
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Required for the JsonableInterface implementation.
     *
     * @param integer $options
     * @return array
     */
    public function toJson($options = 0)
    {
        return $this->validator->messages()->toJson();
    }
}
