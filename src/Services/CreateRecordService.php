<?php

namespace CrudBuilder\Services;

use CrudBuilder\CRUDBuilder;
use CrudBuilder\Foundation\Form;
use CrudBuilder\Foundation\Resource;
use Illuminate\Http\Request;

class CreateRecordService extends CrudService
{
    /**
     * Class constructor.
     *
     * @param \CrudBuilder\Foundation\Resource $resource
     * @param \CrudBuilder\Foundation\Form $form
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Resource $resource, Form $form, Request $request)
    {
        parent::__construct($resource, $form, $request);
    }

    /**
     * save new record of the builder resource
     *
     * @return \Illuminate\Http\Response
     */
    public function save()
    {
        $request = $this->request;
        $resource = $this->resource;
        $validator = $this->form->validator($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $syncedRelation = $this->getSyncedRelationsNames($resource->syncedEntities);
        $filesNames = $this->getFilesNames($this->form->createInputs);
        $input = $this->hashPasswords($this->form->createInputs, $request->except($syncedRelation + $filesNames));
        $instance = $resource->className::create($input);
        
        $this->attach($instance, $request->only($syncedRelation), $resource->syncedEntities);
        $this->saveFiles($filesNames, $resource->namePlural, $instance, $request);

        return redirect($resource->getRouteName())->with('success', $resource->name.' was created successfully');
    }
}