<?php

namespace CrudBuilder\Services;

use CrudBuilder\CRUDBuilder;
use Illuminate\Http\Request;
use CrudBuilder\Foundation\Form;
use CrudBuilder\Foundation\Resource;

class EditRecordService extends CrudService
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
     * update a record of the resource
     *
     * @param string $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(string $id)
    {
        $request = $this->request;
        $resource = $this->resource;
        $validator = $this->form->validator($request, $id);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $syncedRelation = $this->getSyncedRelationsNames($resource->syncedEntities);
        $filesNames = $this->getFilesNames($this->form->updateInputs);
        $input = $this->hashPasswords($this->form->updateInputs, $request->except($syncedRelation + $filesNames));
        $instance = $resource->className::findOrFail($id);
        $instance->update($input);
        $this->sync($instance, $request->only($syncedRelation), $resource->syncedEntities);
        $this->updateFiles($filesNames, $resource->namePlural, $instance, $request);

        return redirect($resource->getRouteName())->with('success', $resource->name.' information was updated successfully');
    }
}