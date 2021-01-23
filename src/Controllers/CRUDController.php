<?php

namespace CrudBuilder\Controllers;

use Illuminate\Http\Request;
use CrudBuilder\CRUDBuilder;
use Illuminate\Routing\Controller;

abstract class CRUDController extends Controller
{
    protected $crudBuilder;

    public function __construct()
    {
        if (! $this->crudBuilder) {
            $this->crudBuilder = new CRUDBuilder();

            $this->middleware(function ($request, $next) {
                $this->crudBuilder->request = $request;
                $this->setup();

                return $next($request);
            });
        }
    }

    abstract public function setup();

    public function index()
    {
        $this->crudBuilder->canOrFail('index');

        $data['pageTitle'] = ucwords($this->crudBuilder->resourceNamePlural);
        $data['pageDescription'] = 'List all '.$this->crudBuilder->resourceNamePlural;
        $data['columns'] = $this->crudBuilder->indexColumns;
        $data['resourceRoute'] = $this->crudBuilder->route;
        $data['recognizedBy'] = $this->crudBuilder->recognizedBy;
        $data['canCreate'] = $this->crudBuilder->can('create');
        $data['canEdit'] = $this->crudBuilder->can('edit');
        $data['canDelete'] = $this->crudBuilder->can('delete');
        $collection = $this->crudBuilder->resource::all();

        return view('admin.crud.index', compact('data', 'collection'));
    }

    public function create()
    {
        $this->crudBuilder->canOrFail('create');

        $pageTitle = 'New '.ucwords($this->crudBuilder->resourceName);
        $pageDescription = 'Create new '.$this->crudBuilder->resourceName;
        $fields = $this->crudBuilder->createInputs;
        $saveAction = $this->crudBuilder->getRouteName();

        return view(config('crudbuilder.pages.create'), compact('pageTitle', 'pageDescription', 'fields', 'saveAction'));
    }

    public function store(Request $request)
    {
        $this->crudBuilder->canOrFail('create');
        $validator = $this->crudBuilder->validator($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $syncedRelation = $this->crudBuilder->getSyncedRelations();
        $input = $request->except($syncedRelation);
        $resource = $this->crudBuilder->resource::create($input);

        $this->crudBuilder->attach($resource, $request->only($syncedRelation));

        return redirect($this->crudBuilder->route)->with('success', $this->crudBuilder->resourceName.' Was created successfully');
    }

    public function show()
    {
    }

    public function edit($id)
    {
        $this->crudBuilder->canOrFail('edit');

        $resource = $this->crudBuilder->resource::findOrFail($id);
        $recognizedBy = $this->crudBuilder->recognizedBy;

        $pageTitle = 'Edit '.ucwords($resource->$recognizedBy);
        $pageDescription = 'Edit '.ucwords($resource->$recognizedBy).' Information';
        $fields = $this->crudBuilder->updateInputs;
        $updateAction = $this->crudBuilder->getRouteName()."/$id";

        return view(config('crudbuilder.pages.edit'), compact('resource', 'pageTitle', 'pageDescription', 'fields', 'updateAction'));
    }

    public function update(Request $request, $id)
    {
        $this->crudBuilder->canOrFail('edit');
        $validator = $this->crudBuilder->validator($request, $id);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $syncedRelation = $this->crudBuilder->getSyncedRelations();
        $input = $request->except($syncedRelation);
        $resource = $this->crudBuilder->resource::findOrFail($id);
        $resource->update($input);
        $this->crudBuilder->sync($resource, $request->only($syncedRelation));

        return redirect($this->crudBuilder->route)->with('success', $resource->name.' information was updated successfully');
    }

    public function destroy($id)
    {
        $this->crudBuilder->canOrFail('delete');
        $resource = $this->crudBuilder->resource::findOrFail($id);
        $recognizedBy = $this->crudBuilder->recognizedBy;
        $name = $resource->$recognizedBy;

        $resource->delete();

        return redirect($this->crudBuilder->route)->with('success', $name.' was deleted successfully');
    }
}
