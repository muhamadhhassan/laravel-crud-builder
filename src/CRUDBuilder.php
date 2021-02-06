<?php

namespace CrudBuilder;

use CrudBuilder\Foundation\Form;
use CrudBuilder\Foundation\Listing;
use CrudBuilder\Foundation\Resource;
class CRUDBuilder
{
    /**
     * The resource data
     *
     * @var \CrudBuilder\Foundation\Resource
     */
    public $resource;

    /**
     * Forms data
     *
     * @var \CrudBuilder\Foundation\Form
     */
    public $form;

    /**
     * Listing/Indexing data
     *
     * @var \CrudBuilder\Foundation\Listing
     */
    public $listing;

    /**
     * Constructor
     *
     * @param \CrudBuilder\Foundation\Resource $resource
     * @param \CrudBuilder\Foundation\Form $form
     */
    public function __construct(Resource $resource, Form $form, Listing $listing)
    {
        $this->resource = $resource;
        $this->form = $form;
        $this->listing = $listing;
    }

    /**
     * Sets the namespace of the CRUD resource.
     *
     * @param string $class
     * 
     * @return \CRUDBuilder
     */
    public function setResourceClass(string $class)
    {
        $this->resource->setClassName($class);

        return $this;
    }

    /**
     * Sets the singular and plural names of the CRUD resource.
     *
     * @param string $single
     * @param string $plural
     * 
     * @return \CRUDBuilder
     */
    public function setResourceNames(string $single, string $plural)
    {
        $this->resource->setNames($single, $plural);

        return $this;
    }

    /**
     * Sets the route to the CRUD resource using named routes.
     *
     * @param string $route
     * @param array $params
     * 
     * @return \CRUDBuilder
     */
    public function setRouteName(string $route, array $params = [])
    {
        $this->resource->setRouteName($route, $params);

        return $this;
    }

    /**
     * Set the allowed actions on the CRUD.
     *
     * @param array $actions
     * 
     * @return \CRUDBuilder
     */
    public function setActions(array $actions)
    {
        $this->resource->setActions($actions);

        return $this;
    }

    /**
     * Add an input to the create inputs collection.
     *
     * @param mixed $inputs
     * 
     * @return \CRUDBuilder
     */
    public function addCreateInputs($inputs)
    {
        $this->form->addCreateInputs($inputs);

        return $this;
    }

    /**
     * Add an input to the update inputs collection.
     *
     * @param mixed $inputs
     * 
     * @return \CRUDBuilder
     */
    public function addUpdateInputs($inputs)
    {
        $this->form->addUpdateInputs($inputs);

        return $this;
    }

    /**
     * Add a column to the index columns collection.
     *
     * @param mixed $columns
     * 
     * @return \CRUDBuilder
     */
    public function addIndexColumns($columns)
    {
        $this->listing->addColumns($columns);

        return $this;
    }

    /**
     * Add a relation to the synced relation collection.
     *
     * @param string $className
     * @param array $properties
     * @param array $pivotProperties
     * @param string $relation
     * 
     * @return \CRUDBuilder
     */
    public function addSyncedEntity(string $className, array $properties, array $pivotProperties, string $relation, bool $taggable = false)
    {
        $this->resource->addSyncedEntity($className, $properties, $pivotProperties, $relation, $taggable);
        
        return $this;
    }

    /**
     * Set store and update form validators.
     *
     * @param string $customValidator
     * 
     * @return \CrudBuilder\CRUDBuilder
     */
    public function setValidator(string $customValidator)
    {
        $this->form->setFormValidator($customValidator);

        return $this;
    }

    /**
     * Set the store request validation class.
     *
     * @param string $customValidator
     * 
     * @return \CRUDBuilder
     */
    public function setStoreValidator(string $customValidator)
    {
        $this->form->setStoreFormValidator($customValidator);

        return $this;
    }

    /**
     * Set the update request validation class.
     *
     * @param string $customValidator
     * 
     * @return \CRUDBuilder
     */
    public function setUpdateValidator(string $customValidator)
    {
        $this->form->setUpdateFormValidator($customValidator);

        return $this;
    }
}
