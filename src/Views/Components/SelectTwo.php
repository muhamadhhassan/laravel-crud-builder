<?php

namespace CrudBuilder\Views\Components;

use Illuminate\Database\Eloquent\Model;

class SelectTwo extends InputComponent
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
    public $selected = [];

    /**
     * Determine if the user is able to add new elements.
     *
     * @var bool
     */
    public $taggable = false;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param bool $mandatory
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param array $options
     */
    public function __construct(array $options, bool $taggable, string $name, bool $mandatory = true, Model $resource = null)
    {
        $this->options = $options;
        $this->taggable = $taggable;
        parent::__construct($name, $mandatory, $resource);
    }

    protected function setPredefinedValue()
    {
        if ($this->resource) {
            $propertyName = $this->name;
            $propertyValue = $this->resource->$propertyName;
            if (is_array($propertyValue)) {
                $this->selected = $propertyValue;
            } elseif (is_object($propertyValue) && count($propertyValue)) {
                $key = $propertyValue->first()->getKeyName();
                $this->selected = $propertyValue->map(function ($instance) use ($key) {
                    return $instance->$key;
                })->toArray();
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('crudbuilder::components.select-two');
    }

    public function isSelected($value)
    {
        return in_array($value, $this->selected);
    }
}
