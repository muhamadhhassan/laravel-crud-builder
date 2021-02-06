<?php

namespace CrudBuilder\Foundation;

use Illuminate\Http\Request;
use CrudBuilder\Helpers\Forms\Input;
use Illuminate\Support\Facades\Validator;
use CrudBuilder\Exceptions\InvalidArgumentException;

class Form
{
    /**
     * The inputs in the creation form.
     *
     * @var array
     */
    public $createInputs = [];

    /**
     * The inputs in the edit form.
     *
     * @var array
     */
    public $updateInputs = [];

    /**
     * The request used to validate resource creation.
     *
     * @var string
     */
    public $createRequest;

    /**
     * The request used to validate resource creation.
     *
     * @var string
     */
    public $updateRequest;

    /**
     * The many-to-many relations that will require syncing.
     *
     * @var array
     */
    public $syncedEntities = [];

    /**
     * The store request validator custom class.
     *
     * @var string
     */
    public $storeValidator = 'Illuminate\Http\Request';

    /**
     * The update request validator custom class.
     *
     * @var string
     */
    public $updateValidator = 'Illuminate\Http\Request';

    /**
     * Add input(s) to the create inputs array.
     *
     * @param mixed $inputs
     * 
     * @return void
     */
    public function addCreateInputs($inputs): void
    {
        if (! is_array($inputs)) {
            $this->addCreateInput($inputs);
            
            return;
        }

        foreach ($inputs as $input) {
            $this->addCreateInput($input);
        }
    }

    /**
     * Add an input(s) to the update inputs array.
     *
     * @param mixed $inputs
     * 
     * @return void
     */
    public function addUpdateInputs($inputs): void
    {
        if (! is_array($inputs)) {
            $this->addUpdateInput($inputs);
            return;
        }

        foreach ($inputs as $input) {
            $this->addUpdateInput($input);
        }
    }

    /**
     * Undocumented function
     *
     * @param \CrudBuilder\Helpers\Forms\Input $input
     * 
     * @return void
     */
    protected function addCreateInput(Input $input): void
    {
        array_push($this->createInputs, $input);
    }

    /**
     * Undocumented function
     *
     * @param \CrudBuilder\Helpers\Forms\Input $input
     * 
     * @return void
     */
    protected function addUpdateInput(Input $input): void
    {
        array_push($this->updateInputs, $input);
    }

    /**
     * Set both store and update form validation class.
     *
     * @param string $customValidator
     * @return void
     */
    public function setFormValidator(string $customValidator)
    {
        $this->validateCustomValidator($customValidator);
        $this->storeValidator = $this->updateValidator = $customValidator;
    }

    /**
     * Set the store form validation class.
     *
     * @param string $customValidator
     * 
     * @return void
     */
    public function setStoreFormValidator(string $customValidator): void
    {
        $this->validateCustomValidator($customValidator);
        $this->storeValidator = $customValidator;
    }

    /**
     * Set the update form validation class.
     *
     * @param string $customValidator
     * 
     * @return void
     */
    public function setUpdateFormValidator(string $customValidator): void
    {
        $this->validateCustomValidator($customValidator);
        $this->updateValidator = $customValidator;
    }

    /**
     * Check the type of the passed validator class
     *
     * @param string $validator
     * 
     * @return void
     */
    protected function validateCustomValidator($validator)
    {
        if (! class_exists($validator)) {
            throw new InvalidArgumentException("The request '{$validator}' does not exist.", 500);
        }

        if (! is_subclass_of((new $validator()), 'Illuminate\Http\Request')) {
            throw new InvalidArgumentException("The class '{$validator}' is not a request validator.", 500);
        }
    }

    /**
     * Validates the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return array
     */
    public function validationRules($method, $id): array
    {
        $validator = $this->getValidator($method);
        
        return (new $validator)->rules($id);
    }

    /**
     * Return a validator instance of the specified request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * 
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, $id = null)
    {
        $rules = $this->validationRules($request->method(), $id);

        return Validator::make($request->all(), $rules);
    }

    /**
     * Get the validation class for the specified method.
     *
     * @param string $method
     * 
     * @return string
     */
    protected function getValidator($method)
    {
        if($method === 'POST') {
            return $this->storeValidator ?? 'Illuminate\Http\Request';
        }

        return $this->updateValidator?? 'Illuminate\Http\Request';
    }
}