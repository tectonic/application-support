<?php
namespace Tectonic\Application\Validation;

use Validator as ValidatorFacade;

/**
 * Class Validator
 *
 * The validator class provides the base functionality required for any other validation classes for resources to
 * set rules, define the user input, and validate the input against these rules.
 *
 * If validation fails for whatever reason, a ValidationException is thrown, which contains a generic message
 * as well as the specific errors for each individual error that may have occurred.
 *
 * @package Tectonic\Shift\Library\Validator
 */
abstract class Validator
{
    /**
     * Stores the array of data that a user provided as part of the request.
     *
     * @var array
     */
    protected $input = [];

    /**
     * Stores the messages that should be returned when an error fails.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * If you do not wish to define custom rules for each method, you can define a rules array on the validator class itself.
     * If no method is defined for setting the validation rules, then the rules array will be used as the basis for the validation.
     * If no rules are provided, then validation will pass.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Every validator requires the input to validate.
     *
     * @param array $input
     */
    public function __construct(array $input = [])
    {
        $this->setInput($input);
    }

	/**
	 * Set the input for validation.
	 *
	 * @param array $input
	 * @return Validator
	 */
	public function setInput(array $input = [])
	{
		$this->input = $input;

		return $this;
	}

    /**
     * Returns the input array that was defined for validation.
     *
     * @return array
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Returns the value of a single field.
     *
     * @param $field
     * @return mixed
     */
    public function getValue($field)
    {
        if (isset($this->input[$field])) {
            return $this->input[$field];
        }

        return;
    }

    /**
     * Validates the rules provided either by a custom method or on the class against the user input provided.
     *
     * @throws ValidationException
     * @return boolean
     */
    public function validate()
    {
        $validator = ValidatorFacade::make($this->getInput(), $this->getRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }

    /**
     * Retrieves the rules that have defined for the validation.
     *
     * @return array
     * @throws ValidationConfigurationException
     */
    public function getRules()
    {
        if (!is_array($this->rules)) {
            throw new ValidationConfigurationException('Validator rules defined must be provided as an array.');
        }

        return $this->rules;
    }
}
