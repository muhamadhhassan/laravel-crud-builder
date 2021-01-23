<?php

namespace CrudBuilder\Views\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

abstract class InputComponent extends Component
{
    /**
     * The input name that will be used in the name attribute
     * and also for retrieving the default value.
     *
     * @var string
     */
    public $name;

    /**
     * The value default value of the input tag.
     *
     * @var string
     */
    public $value;

    /**
     * Determines if the input is required.
     *
     * @var bool
     */
    public $mandatory;

    /**
     * In editing scenario this will be the resource being edited.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    public $resource;

    abstract protected function setPredefinedValue();

    /**
     * Undocumented function.
     *
     * @param string $name
     * @param bool $mandatory
     * @param \Illuminate\Database\Eloquent\Model $resource
     */
    public function __construct(string $name, bool $mandatory = true, Model $resource = null)
    {
        $this->name = $name;
        $this->mandatory = $mandatory;
        $this->resource = $resource;
        $this->setPredefinedValue();
    }
}
