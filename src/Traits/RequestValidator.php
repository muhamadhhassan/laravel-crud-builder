<?php

namespace CrudBuilder\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait RequestValidator
{
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
     * Set the store request validation class.
     *
     * @param string $customValidator
     * @return \CRUDBuilder
     */
    public function setStoreValidator(string $customValidator)
    {
        if (! class_exists($customValidator)) {
            throw new \Exception("The request '{$customValidator}' does not exist.", 500);
        }

        if (! is_subclass_of((new $customValidator()), 'Illuminate\Http\Request')) {
            throw new \Exception("The class '{$customValidator}' is not a request validator.", 500);
        }

        $this->storeValidator = $customValidator;

        return $this;
    }

    /**
     * Set the update request validation class.
     *
     * @param string $customValidator
     * @return \CRUDBuilder
     */
    public function setUpdateValidator(string $customValidator)
    {
        if (! class_exists($customValidator)) {
            throw new \Exception("The request '{$customValidator}' does not exist.", 500);
        }

        $this->updateValidator = $customValidator;

        return $this;
    }

    /**
     * Validates the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function validationRules($method, $id): array
    {
        if ($method === 'POST') {
            $validatorClass = $this->storeValidator;
        }

        if ($method === 'PATCH') {
            $validatorClass = $this->updateValidator;
        }

        return (new $validatorClass())->rules($id);
    }

    public function validator(Request $request, $id = null)
    {
        $rules = $this->validationRules($request->method(), $id);

        return Validator::make($request->all(), $rules);
    }
}
