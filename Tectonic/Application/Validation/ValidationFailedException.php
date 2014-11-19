<?php
namespace Tectonic\Application\Validation;

use Illuminate\Support\Contracts\JsonableInterface;

class ValidationFailedException extends \Exception implements JsonableInterface
{
    /**
     * The generic message for the failed validation.
     *
     * @var string
     */
    protected $message = 'Validation failed. Please check the information provided and try again.';

    /**
     * Stores an array of errors that can be returned along with the exception.
     *
     * @var
     */
    protected $errors;

    /**
     * Build the exception, providing the necessary errors array. If you want to change the message
     * use the generic setMessage method provided as part of the base class.
     *
     * @param string $errors
     */
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Allows us to return the exception directly for some Laravel APIs.
     *
     * @param int $options
     * @return json
     */
    public function toJson($options = 0)
    {
        $response = [
            'message' => $this->message,
            'errors' => $this->getErrors()
        ];

        return json_encode($response);
    }

    /**
     * Return the array of errors that were generated as part of the failed validation.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
