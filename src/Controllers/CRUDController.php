<?php

namespace CrudBuilder\Controllers;

use CrudBuilder\CRUDBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use CrudBuilder\Services\CreateRecordService;
use CrudBuilder\Services\EditRecordService;

abstract class CRUDController extends Controller
{
    protected $crudBuilder;

    /**
     * Class constructor.
     */
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

    /**
     * Setting up resource data.
     *
     * @return void
     */
    abstract public function setup();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $collection = $this->crudBuilder->resourceClass::paginate(10);

        return view('admin.crud.index', compact('data', 'collection'));
    }

    /**
     * Show the form of creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $this->crudBuilder->canOrFail('create');

        $pageTitle = 'New '.ucwords($this->crudBuilder->resourceName);
        $pageDescription = 'Create new '.$this->crudBuilder->resourceName;
        $fields = $this->crudBuilder->createInputs;
        $saveAction = $this->crudBuilder->getRouteName();

        return view(config('crudbuilder.views.pages.create'), compact('pageTitle', 'pageDescription', 'fields', 'saveAction'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->crudBuilder->canOrFail('create');
        
        return (new CreateRecordService($this->crudBuilder))->save();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resources.
     *
     * @param string $id
     * 
     * @return \Illuminate\Http\Response 
     */
    public function edit($id)
    {
        $this->crudBuilder->canOrFail('edit');

        $resource = $this->crudBuilder->resourceClass::findOrFail($id);
        $recognizedBy = $this->crudBuilder->recognizedBy;

        $pageTitle = 'Edit '.ucwords($resource->$recognizedBy);
        $pageDescription = 'Edit '.ucwords($resource->$recognizedBy).' Information';
        $fields = $this->crudBuilder->updateInputs;
        $updateAction = $this->crudBuilder->getRouteName()."/$id";

        return view(config('crudbuilder.views.pages.edit'), compact('resource', 'pageTitle', 'pageDescription', 'fields', 'updateAction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->crudBuilder->canOrFail('edit');

        return (new EditRecordService($this->crudBuilder))->update($id);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param string $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudBuilder->canOrFail('delete');
        $this->crudBuilder->resource = $this->crudBuilder->resourceClass::findOrFail($id);
        $recognizedBy = $this->crudBuilder->recognizedBy;
        $name = $this->crudBuilder->resource->$recognizedBy;

        $this->crudBuilder->resource->delete();

        return redirect($this->crudBuilder->route)->with('success', $name.' was deleted successfully');
    }
}
