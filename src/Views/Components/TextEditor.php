<?php

namespace CrudBuilder\Views\Components;

use Illuminate\Database\Eloquent\Model;

class TextEditor extends InputComponent
{
    /**
     * The default value of the input.
     *
     * @var string
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param bool $mandatory
     * @param \Illuminate\Database\Eloquent\Model $resource
     */
    public function __construct(string $name, bool $mandatory = true, Model $resource = null)
    {
        parent::__construct($name, $mandatory, $resource);
    }

    protected function setPredefinedValue()
    {
        if ($this->resource) {
            $propertyName = $this->name;
            $this->value = $this->resource->$propertyName;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('crudbuilder::components.text-editor');
    }
}
