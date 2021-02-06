<?php

namespace CrudBuilder\Services;

use CrudBuilder\CRUDBuilder;
use CrudBuilder\Traits\FilesHandler;

class EditRecordService
{
    use FilesHandler;

    /**
     * class constructor
     *
     * @param \CrudBuilder\CRUDBuilder $builder
     */
    public function __construct(CRUDBuilder $builder)
    {
        $this->builder = $builder;
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
        $request = $this->builder->request;
        $validator = $this->builder->validator($request, $id);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $syncedRelation = $this->builder->getSyncedRelations();
        $fileNames = $this->getFilesNames($this->builder->updateInputs);
        $input = $request->except($syncedRelation + $fileNames);
        $resource = $this->builder->resourceClass::findOrFail($id);
        $resource->update($input);
        $this->builder->sync($resource, $request->only($syncedRelation));
        $this->updateFiles($fileNames, $this->builder->resourceNamePlural, $resource, $request);

        return redirect($this->builder->route)->with('success', $this->builder->resourceName.' information was updated successfully');
    }
}