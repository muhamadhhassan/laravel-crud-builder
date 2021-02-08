<?php

namespace CrudBuilder\Foundation;

use CrudBuilder\Helpers\SyncedEntity;
use CrudBuilder\Exceptions\InvalidArgumentException;

class Resource
{
    /**
     * The resource class for example App\Models\User.
     *
     * @var string
     */
    public $className;

    /**
     * The singular name of the resource for example user.
     *
     * @var string
     */
    public $name;

    /**
     * an instance of the crud resource
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $resource;

    /**
     * The plural name of the resource for example users.
     *
     * @var string
     */
    public $namePlural;

    /**
     * The field that make the resource recognizable like name, title or full_name.
     *
     * @var string
     */
    public $recognizedBy = 'name';

    /**
     * The route of the resource.
     *
     * @var string
     */
    public $routeName;

    /**
     * The many-to-many relations that will require syncing.
     *
     * @var array
     */
    public $syncedEntities = [];

    /**
     * The allowed actions on the CRUD.
     *
     * @var array
     */
    public $actions = ['index', 'create', 'edit', 'delete', 'show'];

    /**
     * Sets the namespace of the CRUD resource.
     *
     * @param string $class
     * 
     * @return void
     */
    public function setClassName(string $class): void
    {
        if (! class_exists($class)) {
            throw new InvalidArgumentException("The model '{$class}' does not exist.", 500);
        }

        if (! is_subclass_of((new $class()), 'Illuminate\Database\Eloquent\Model')) {
            throw new InvalidArgumentException("The class '{$class}' must be an instance of 'Illuminate\Database\Eloquent\Model'", 500);
        }

        $this->className = $class;
    }

    /**
     * Sets the singular and plural names of the CRUD resource.
     *
     * @param string $single
     * @param string $plural
     * 
     * @return void
     */
    public function setNames(string $single, string $plural): void
    {
        $this->name = $single;
        $this->namePlural = $plural;
    }

    /**
     * Set the resource label
     *
     * @param string $name
     * 
     * @return void
     */
    public function setRecognizedBy(string $name): void
    {
        $this->recognizedBy = $name;
    }

    /**
     * Sets the route to the CRUD resource using named routes.
     *
     * @param string $route
     * @param array $params
     * 
     * @return void
     */
    public function setRouteName(string $route, array $params = []): void
    {
        $complete_route = $route.'.index';

        if (! \Route::has($complete_route)) {
            throw new InvalidArgumentException('There are no routes for this route name.', 404);
        }

        $this->routeName = route($complete_route, $params);
    }

    /**
     * Set the allowed actions on the resource.
     *
     * @param array $actions
     * 
     * @return void
     */
    public function setActions(array $actions): void
    {
        $this->actions = $actions;
    }

    /**
     * Returns the resource route.
     *
     * @return string
     */
    public function getRouteName(string $action = null): string
    {
        return $this->routeName;
    }

    /**
     * Add a relation to the synced relation collection.
     *
     * @param string $className
     * @param array $properties
     * @param array $pivotProperties
     * @param string $relation
     * 
     * @return void
     */
    public function addSyncedEntity(string $className, array $properties, array $pivotProperties, string $relation, bool $taggable = false): void
    {
        if (! class_exists($className)) {
            throw new InvalidArgumentException("The model '{$className}' does not exist.", 500);
        }

        if (! is_subclass_of((new $className()), 'Illuminate\Database\Eloquent\Model')) {
            throw new InvalidArgumentException("The class '{$className}' must be an instance of 'Illuminate\Database\Eloquent\Model'", 500);
        }

        array_push($this->syncedEntities, new SyncedEntity($className, $properties, $pivotProperties, $relation, $taggable));
    }
    
    /**
     * Determine if an action is permitted.
     *
     * @param string $action
     * 
     * @return bool
     */
    public function can(string $action) : bool
    {
        if (! in_array($action, $this->actions)) {
            return false;
        }

        return true;
    }

    /**
     * Determine if an action is permitted. Abort if not.
     *
     * @param string|[string] $action
     *
     * @return bool|null
     */
    public function canOrFail($action) : ?bool
    {
        if (! in_array($action, $this->actions)) {
            abort(403, 'Unauthorized Access');
        }

        return true;
    }
}