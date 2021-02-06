<?php

namespace CrudBuilder\Controllers;

use CrudBuilder\CRUDBuilder;
use CrudBuilder\Foundation\Form;
use CrudBuilder\Foundation\Listing;
use CrudBuilder\Foundation\Resource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use CrudBuilder\Services\CreateRecordService;
use CrudBuilder\Services\EditRecordService;

abstract class CRUDController extends Controller
{
    protected $builder;

    protected $resource;

    protected $form;

    protected $listing;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->resource = new Resource();
        $this->form = new Form();
        $this->listing = new Listing();
        $this->builder = new CRUDBuilder($this->resource, $this->form, $this->listing);

        $this->middleware(function ($request, $next) {
            $this->setup();

            return $next($request);
        });
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
        $this->resource->canOrFail('index');

        $data['pageTitle'] = ucwords($this->resource->namePlural);
        $data['pageDescription'] = 'List all '.$this->resource->namePlural;
        $data['columns'] = $this->listing->columns;
        $data['resourceRoute'] = $this->resource->routeName;
        $data['recognizedBy'] = $this->resource->recognizedBy;
        $data['canCreate'] = $this->resource->can('create');
        $data['canEdit'] = $this->resource->can('edit');
        $data['canDelete'] = $this->resource->can('delete');
        $collection = $this->resource->className::paginate(10);

        return view('admin.crud.index', compact('data', 'collection'));
    }

    /**
     * Show the form of creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $this->resource->canOrFail('create');

        $pageTitle = 'New '.ucwords($this->resource->name);
        $pageDescription = 'Create new '.$this->resource->name;
        $fields = $this->form->createInputs;
        $saveAction = $this->resource->getRouteName();

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
        $this->resource->canOrFail('create');
        
        return (new CreateRecordService($this->resource, $this->form, $request))->save();
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
        $this->resource->canOrFail('edit');

        $instance = $this->resource->className::findOrFail($id);
        $recognizedBy = $this->resource->recognizedBy;

        $pageTitle = 'Edit '.ucwords($instance->$recognizedBy);
        $pageTitle = 'Edit '.ucwords($instance->$recognizedBy);
        $pageDescription = 'Edit '.ucwords($instance->$recognizedBy).' Information';
        $fields = $this->form->updateInputs;
        $updateAction = $this->resource->getRouteName()."/$id";

        return view(config('crudbuilder.views.pages.edit'), compact('instance', 'pageTitle', 'pageDescription', 'fields', 'updateAction'));
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
        $this->resource->canOrFail('edit');

        return (new EditRecordService($this->resource, $this->form, $request))->update($id);
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
        $this->resource->canOrFail('delete');
        $instance = $this->builder->resourceClass::findOrFail($id);
        $recognizedBy = $this->resource->recognizedBy;
        $name = $instance->$recognizedBy;

        $instance->delete();

        return redirect($this->resource->getRouteName())->with('success', $name.' was deleted successfully');
    }
}
