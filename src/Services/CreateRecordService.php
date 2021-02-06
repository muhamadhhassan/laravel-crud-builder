<?php

namespace CrudBuilder\Services;

use CrudBuilder\CRUDBuilder;
use CrudBuilder\Traits\FilesHandler;

class CreateRecordService
{
    use FilesHandler;

    /**
     * Undocumented variable
     *
     * @var \CrudBuilder\CRUDBUilder
     */
    protected $builder;

    /**
     * class constructor
     *
     * @param \CrudBuilder\CRUDBuilder $crudBuilder
     */
    public function __construct(CRUDBuilder $crudBuilder)
    {
        $this->builder = $crudBuilder;
    }

    /**
     * save new record of the builder resource
     *
     * @return \Illuminate\Http\Response
     */
    public function save()
    {
        $request = $this->builder->request;
        $validator = $this->builder->validator($request);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $syncedRelation = $this->builder->getSyncedRelations();
        $filesNames = $this->getFilesNames($this->builder->createInputs);
        $input = $request->except($syncedRelation + $filesNames);
        $resource = $this->builder->resourceClass::create($input);

        $this->builder->attach($resource, $request->only($syncedRelation));
        $this->saveFiles($filesNames, $this->builder->resourceNamePlural, $resource, $request);

        return redirect($this->builder->route)->with('success', $this->builder->resourceName.' was created successfully');
    }
}