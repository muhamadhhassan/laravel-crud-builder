<?php

namespace CrudBuilder\Helpers;

use Illuminate\Database\Eloquent\Model;

class IndexColumn
{
    /**
     * The property name on the resource in view.
     *
     * @var string
     */
    public $name;

    /**
     * The column name in the table header.
     *
     * @var string|null
     */
    public $label;

    /**
     * Determines if the property value is retrieved by a function call.
     *
     * @var bool
     */
    public $isFunction;

    /**
     * Determine if the property should be escaped.
     *
     * @var bool
     */
    public $isEscaped;

    public function __construct(string $name, string $label = null, bool $isFunction = false, bool $isEscaped = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->isFunction = $isFunction;
        $this->isEscaped = $isEscaped;
    }

    /**
     * Returns the value of the column.
     *
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @return mixed
     */
    public function getValue(Model $resource)
    {
        $names = explode('.', $this->name);
        if (count($names) === 2) {
            $relation = $names[0];
            $property = $names[1];

            return $this->value = $this->isFunction ? $resource->$relation->$property()
                : $resource->$relation->$property;
        }

        $property = $names[0];

        return $this->value = $this->isFunction ? $resource->$property() : $resource->$property;
    }
}
