<?php

namespace CrudBuilder\Services;

use CrudBuilder\Foundation\Form;
use CrudBuilder\Foundation\Resource;

class DeleteRecordService extends CrudService
{
    public function __construct(Resource $resource, Form $form)
    {
        parent::__construct($resource, $form);
    }

    public function delete(string $id)
    {
        $resource = $this->resource;
        $instance = $resource->className::findOrFail($id);
        $resourceName = $resource->recognizedBy;
        $name = $instance->$resourceName;
        $filesNames = $this->getFilesNames($this->form->updateInputs);
        $this->deleteFiles($filesNames, $instance);
        $instance->delete();
        
        return redirect($resource->getRouteName())->with('success', $name.' information was deleted successfully');
    }
}