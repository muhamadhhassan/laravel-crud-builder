<?php

namespace CrudBuilder\Views\Components\Inputs;

use Illuminate\Database\Eloquent\Model;

class Text extends InputComponent
{
    /**
     * The default value of the input.
     *
     * @var string
     */
    public $value;

    /**
     * The text type of the input
     *
     * @var string
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param bool $mandatory
     * @param \Illuminate\Database\Eloquent\Model $resource
     */
    public function __construct(string $name, bool $mandatory = true, Model $resource = null, string $type = 'text')
    {
        $this->type = $type;
        parent::__construct($name, $mandatory, $resource);
    }

    protected function setPredefinedValue()
    {
        if ($this->resource && $this->type !== 'password') {
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
        return view(config('crudbuilder.views.inputs.text'));
    }
}
