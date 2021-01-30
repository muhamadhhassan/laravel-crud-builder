<?php

namespace CrudBuilder\Views\Components\Inputs;

use Illuminate\Database\Eloquent\Model;

class Checkboxes extends InputComponent
{
    /**
     * The options array of the input.
     *
     * @var array
     */
    public $options;

    /**
     * The selected value of the input.
     *
     * @var mixed
     */
    public $checked = [];

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param bool $mandatory
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param array $options
     */
    public function __construct(array $options, string $name, bool $mandatory = true, Model $resource = null)
    {
        $this->options = $options;
        parent::__construct($name, $mandatory, $resource);
    }

    protected function setPredefinedValue()
    {
        if ($this->resource) {
            $propertyName = $this->name;
            $this->checked = $this->resource->$propertyName;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view(config('crudbuilder.views.inputs.checkboxes'));
    }

    public function isChecked($value)
    {
        return in_array($value, $this->checked);
    }
}
