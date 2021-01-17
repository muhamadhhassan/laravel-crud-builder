<?php

namespace CrudBuilder\Helpers;

class SyncedEntity
{
    /**
     * Entity full class name.
     *
     * @var string
     */
    public $className;

    /**
     * Properties to be passed to its child.
     *
     * @var array
     */
    public $properties;

    /**
     * The properties on the pivot table in addition to the foreign keys.
     *
     * @var array
     */
    public $pivotProperties;

    /**
     * Relation name as defined on its child.
     *
     * @var string
     */
    public $relation;

    /**
     * Determine if it is possible to create new records.
     *
     * @var bool
     */
    public $createNewRecord = false;

    /**
     * Constructor definition.
     *
     * @param string $className
     * @param array $properties
     * @param array $pivotProperties
     * @param string $relation
     */
    public function __construct(string $className, array $properties, array $pivotProperties = [], string $relation = null, bool $createNewRecord = false)
    {
        $this->className = $className;
        $this->properties = $properties;
        $this->createNewRecord = $createNewRecord;

        if (! $relation) {
            $relation = lcfirst(array_pop(explode('\\', $this->className)));
        }

        $this->relation = $relation;
        $this->pivotProperties = $pivotProperties;
    }
}
