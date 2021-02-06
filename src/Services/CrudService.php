<?php

namespace CrudBuilder\Services;

use Illuminate\Http\Request;
use CrudBuilder\Foundation\Form;
use CrudBuilder\Foundation\Resource;
use CrudBuilder\Traits\FilesHandler;
use CrudBuilder\Traits\SyncedRelation;
use CrudBuilder\Traits\PasswordsHandler;

class CrudService
{
    use FilesHandler, PasswordsHandler, SyncedRelation;

    /**
     * Resource data
     *
     * @var \CrudBuilder\Foundation\Resource
     */
    public $resource;

    /**
     * Form data
     *
     * @var \CrudBuilder\Foundation\Form
     */
    public $form;

    /**
     * Store Request
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Class constructor.
     *
     * @param \CrudBuilder\Foundation\Resource $resource
     * @param \CrudBuilder\Foundation\Form $form
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Resource $resource, Form $form, Request $request)
    {
        $this->resource = $resource;
        $this->form = $form;
        $this->request = $request;
    }
}