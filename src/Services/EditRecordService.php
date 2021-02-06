<?php

namespace CrudBuilder\Services;

use CrudBuilder\CRUDBuilder;
use CrudBuilder\Traits\FilesHandler;
use CrudBuilder\Traits\PasswordsHandler;

class EditRecordService
{
    use FilesHandler, PasswordsHandler;

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
        $filesNames = $this->getFilesNames($this->builder->updateInputs);
        $input = $this->hashPasswords($this->builder->createInputs, $request->except($syncedRelation + $filesNames));
        $resource = $this->builder->resourceClass::findOrFail($id);
        $resource->update($input);
        $this->builder->sync($resource, $request->only($syncedRelation));
        $this->updateFiles($filesNames, $this->builder->resourceNamePlural, $resource, $request);

        return redirect($this->builder->route)->with('success', $this->builder->resourceName.' information was updated successfully');
    }
}