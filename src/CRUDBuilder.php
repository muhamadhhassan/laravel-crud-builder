<?php

namespace CrudBuilder;

use CrudBuilder\Traits\RequestValidator;
use CrudBuilder\Traits\SyncedRelation;

class CRUDBuilder
{
    use RequestValidator, SyncedRelation;

    /**
     * The resource class for example App\Models\User.
     *
     * @var string
     */
    public $resourceClass;

    /**
     * The singular name of the resource for example user.
     *
     * @var string
     */
    public $resourceName;

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
    public $resourceNamePlural;

    /**
     * The route of the resource.
     *
     * @var string
     */
    public $route;

    /**
     * The route of the resource.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * The field that make the resource recognizable like name, title or full_name.
     *
     * @var string
     */
    public $recognizedBy = 'name';

    /**
     * The inputs in the creation form.
     *
     * @var array
     */
    public $createInputs = [];

    /**
     * The inputs in the edit form.
     *
     * @var array
     */
    public $updateInputs = [];

    /**
     * The request used to validate resource creation.
     *
     * @var string
     */
    public $createRequest;

    /**
     * The request used to validate resource creation.
     *
     * @var string
     */
    public $updateRequest;

    /**
     * The columns that will be in the index page.
     *
     * @var array
     */
    public $indexColumns = [];

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
     * @return \CRUDBuilder
     */
    public function setResourceClass(string $class)
    {
        if (! class_exists($class)) {
            throw new \Exception("The model '{$class}' does not exist.", 500);
        }

        if (! is_subclass_of((new $class()), 'Illuminate\Database\Eloquent\Model')) {
            throw new \Exception("The class '{$class}' must be an instance of 'Illuminate\Database\Eloquent\Model'", 500);
        }

        $this->resourceClass = $class;

        return $this;
    }

    /**
     * Sets the singular and plural names of the CRUD resource.
     *
     * @param string $single
     * @param string $plural
     * @return \CRUDBuilder
     */
    public function setResourceNames(string $single, string $plural)
    {
        $this->resourceName = $single;
        $this->resourceNamePlural = $plural;

        return $this;
    }

    /**
     * Sets the route to the CRUD resource.
     *
     * @param string $route
     * @return \CRUDBuilder
     */
    public function setRoute(string $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Sets the route to the CRUD resource using named routes.
     *
     * @param string $route
     * @param array $params
     * @return \CRUDBuilder
     */
    public function setRouteName(string $route, array $params = [])
    {
        $complete_route = $route.'.index';

        if (! \Route::has($complete_route)) {
            throw new \Exception('There are no routes for this route name.', 404);
        }

        $this->route = route($complete_route, $params);

        return $this;
    }

    /**
     * Set the allowed actions on the CRUD.
     *
     * @param array $actions
     * @return \CRUDBuilder
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Returns the resource route.
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->route;
    }

    /**
     * Add an input to the create inputs collection.
     *
     * @param mixed $inputs
     * @return \CRUDBuilder
     */
    public function addCreateInputs($inputs)
    {
        if (! is_array($inputs)) {
            array_push($this->createInputs, $inputs);

            return $this;
        }

        foreach ($inputs as $input) {
            if ($input instanceof \CrudBuilder\Helpers\Forms\Input) {
                array_push($this->createInputs, $input);
            } else {
                throw new \Exception('Form inputs must be an instance of App\Helpers\CRUD\Forms\Input.php.', 500);
            }
        }

        return $this;
    }

    /**
     * Add an input to the update inputs collection.
     *
     * @param mixed $inputs
     * @return \CRUDBuilder
     */
    public function addUpdateInputs($inputs)
    {
        if (! is_array($inputs)) {
            array_push($this->updateInputs, $inputs);

            return $this;
        }

        foreach ($inputs as $input) {
            if ($input instanceof \CrudBuilder\Helpers\Forms\Input) {
                array_push($this->updateInputs, $input);
            } else {
                throw new \Exception('Form inputs must be an instance of App\Helpers\CRUD\Forms\Input.php.', 500);
            }
        }

        return $this;
    }

    /**
     * Add a column to the index columns collection.
     *
     * @param mixed $columns
     * @return \CRUDBuilder
     */
    public function addIndexColumns($columns)
    {
        if (! is_array($columns)) {
            array_push($this->indexColumns, $columns);

            return $this;
        }

        foreach ($columns as $column) {
            if ($column instanceof \CrudBuilder\Helpers\IndexColumn) {
                array_push($this->indexColumns, $column);
            } else {
                throw new \Exception('Index table columns must be an instance of App\Helpers\CRUD\IndexColumn.php.', 500);
            }
        }

        return $this;
    }

    /**
     * Determine if an action is permitted.
     *
     * @param string $action
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
